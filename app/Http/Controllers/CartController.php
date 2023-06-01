<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\Gig;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\OrderExtra;
use App\Models\User;
use App\Notifications\OrderCreated;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $cart = $this->hasOrCreateCart();
        $categories = Category::get();

        if ($request->isMethod('post') && $request->item_id) {
            $item = CartItem::where('id', $request->item_id)->first();

            if ($item)
                $item->delete();
        }

        return Inertia::render('Cart', [
            'cart' => $cart,
            'categories' => $categories
        ]);
    }

    public function addItem(Request $request)
    {
        try {
            $cart = $this->hasOrCreateCart();

            CartItem::create([
                'extras' => $request->extras,
                'gig_id' => $request->gig_id,
                'cart_id' => $cart->id
            ]);

            return response()->json([
                "status" => true
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => false
            ]);
        }
    }

    public function pay()
    {
        $items_price = 0;
        $gigs_price = 0;

        $total = 0;
        $fees = (int) getOption('payment_fees', 2);
        $all = 0;

        $cart = $this->hasOrCreateCart();

        if ($cart->items->count() == 0) {
            return to_route('cart');
        }

        $cart->load([
            'items',
            'items.gig',
        ]);

        foreach ($cart->items as $item) {
            $gigs_price += $item->gig->price;

            $a = collect($item->extras)->sum('price');

            $items_price += $a;
        }

        $total = $items_price + $gigs_price;
        $all = $total + $fees;

        $intent = $this->setupStripe($all);
        $intent_id = $intent->id;

        $stripe_client_secret = $intent->client_secret;

        $categories = Category::get();

        return Inertia::render('Pay', compact('cart', 'total', 'fees', 'all', 'stripe_client_secret', 'intent_id', 'categories'));
    }

    public function updateCartItems($item_id, Request $request)
    {
        try {
            $item = CartItem::with(['cart'])->where('id', $item_id)->first();
            $extras = [];

            if ($item) {
                if ($item->cart->user_id == user()->id) {

                    foreach ($request->extras as $key => $value) {
                        $extras[] = [
                            "id" => $key,
                            "price" => $value['price']
                        ];
                    }

                    $item->update([
                        'extras' => $extras
                    ]);
                }
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    protected function hasOrCreateCart()
    {
        $cart = Cart::with(['items' => [
            'gig' => [
                'user',
                'extras'
            ]
        ]])->where([
            'user_id' => user()->id
        ])->first();

        if (!$cart) {
            $cart = Cart::create([
                'token' => Str::random(20),
                'user_id' => user()->id
            ]);
            $cart->load(['items' => [
                'gig' => [
                    'user',
                    'extras'
                ]
            ]]);
        }


        return $cart;
    }

    protected function setupStripe($amount)
    {
        Stripe::setApiKey(getOption('stripe_secret_key'));

        try {
            $paymentIntent = PaymentIntent::create([
                'amount' => to_pennies($amount),
                'currency' => 'usd',
                'automatic_payment_methods' => [
                    'enabled' => true,
                ],
            ]);

            return $paymentIntent;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function confirmPayment($type, Request $request, $complete = false)
    {
        try {
            switch ($type) {
                case 'card':
                    Stripe::setApiKey(getOption('stripe_secret_key'));
                    $intent = PaymentIntent::retrieve($request->data['id']);

                    if ($intent->status == "succeeded") {
                        if ($complete) {
                            return $this->createMilestone('card', $request->data, $request->amount, $request->recipient);
                        }
                        $this->makeOrder($type, $request->data);
                    }
                    break;
                case 'paypal':
                    if (strtoupper($request->data['status']) == "COMPLETED") {
                        if ($complete) {
                            return $this->createMilestone('paypal', $request->data, $request->amount, $request->recipient);
                        }
                        $this->makeOrder($type, $request->data);
                    }
                    break;
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    protected function calculateOrderAmount($item)
    {
        $amount = 0;

        $amount += $item->gig?->price;

        foreach ($item->extras as $extra) {
            $amount += $extra->price;
        }

        return $amount;
    }

    protected function makeOrder($type, $details)
    {
        $amount = 0;
        $cart = $this->hasOrCreateCart();

        foreach ($cart->items as $item) {
            $order = Order::create([
                'status' => 'pending',
                'amount' => $this->calculateOrderAmount($item),
                'delivery_at' => Carbon::now()->addDays($item->gig?->delivery_time),

                'user_id' => user()->id,
                'gig_id' => $item->gig?->id,
            ]);

            $amount += $item->gig?->price;

            foreach ($item->extras as $extra) {

                $extra = $item->gig?->extras->where('id', $extra->id)->first();

                $amount += $extra->price;

                if ($extra) {
                    OrderExtra::create([
                        'order_id' => $order->id,
                        'extra_id' => $extra->id
                    ]);
                }
            }

            Invoice::create([
                'status' => 'completed',
                'type' => 'order',
                'payment_method' => $type,
                'details' => $details,
                'amount' => $amount,
                'order_id' => $order->id,
                'user_id' => user()->id
            ]);
        }

        $user = User::where('id', user()->id)->first();
        $user->notify(new OrderCreated($order));

        $cart->empty();
    }

    // api

    public function createOfferPayment($complete = 'no', Request $request)
    {


        $request->validate([
            'amount' => 'required|numeric|between:5,5000'
        ]);

        if ($complete == 'yes') {
            $request->validate([
                'recipient' => 'required|numeric|exists:users,id',
                'data' => 'required'
            ]);

            return $this->confirmPayment($request->type, $request, true);
        }

        Stripe::setApiKey(getOption('stripe_secret_key'));

        try {
            $paymentIntent = PaymentIntent::create([
                'amount' => to_pennies($request->amount),
                'currency' => 'usd',
                'automatic_payment_methods' => [
                    'enabled' => true,
                ],
            ]);

            return response()->json([
                'status' => true,
                'paymentIntent' => $paymentIntent->client_secret
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false
            ]);
        }
    }

    public function completeOffer($invoice_id, Request $request)
    {
        $invoice = Invoice::with(['recipient'])
            ->where([
                'type' => 'milestone',
                'user_id' => user()->id,
                'id' => $invoice_id,
                'status' => 'pending'
            ])->first();

        if ($invoice) {
            $invoice->update([
                'status' => 'completed'
            ]);

            $invoice->recipient->increment('balance', $invoice->amount);

            return back();
        }
    }

    protected function createMilestone($type, $details, $amount, $recipient_id)
    {
        Invoice::create([
            'status' => 'pending',
            'type' => 'milestone',
            'payment_method' => $type,
            'details' => $details,
            'amount' => $amount,
            'order_id' => null,
            'user_id' => user()->id,
            'recipient_id' => $recipient_id
        ]);
    }
}
