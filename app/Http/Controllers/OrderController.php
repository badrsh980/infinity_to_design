<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Earning;
use App\Models\Gig;
use App\Models\Order;
use App\Models\Rate;
use App\Models\Review;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OrderController extends Controller
{
    public function orders(Request $request)
    {
        $categories = Category::get();

        $orders = Order::with(['gig', 'user'])
            ->whereIn('gig_id', Gig::select('id')->where('user_id', user()->id))
            ->get();

        return Inertia::render('Orders', compact('categories', 'orders'));
    }

    public function purchases()
    {
        $categories = Category::get();
        $orders  = Order::with([
            'gig' => function ($q) {
                $q->withCount([
                    'reviews as review' => function ($q) {
                        $q->where('user_id', user()->id);
                    }
                ]);
            },
            'user'
        ])
            ->where('user_id', user()->id)
            ->get();

        $options = getOption('reviews_types', []);

        return Inertia::render('Purchases', compact('categories', 'orders', 'options'));
    }

    public function update($id, Request $request)
    {
        $order = Order::where([
            'id' => $id,
        ]);

        if ($request->status) {
            switch ($request->status) {
                case "cancel":
                    $order = $order->whereHas(
                        'gig',
                        function ($q) {
                            $q->where('gigs.user_id', user()->id);
                        }
                    )
                        ->with('gig.user')
                        ->where('status', 'pending')
                        ->first();

                    if ($order) {
                        $order->status = "canceled";
                        $order->save();

                        $order->gig->user->increment('balance', $order->amount);
                    }
                    break;
                case "deliver":
                    $order = $order->where('user_id', user()->id)
                        ->with('gig.user')
                        ->where('status', 'completed')
                        ->first();

                    if ($order) {
                        $order->status = "delivered";
                        $order->save();

                        Earning::create([
                            'status' => 'pending',
                            'amount' => $order->amount,
                            'user_id' => user()->id
                        ]);
                    }
                    break;

                case "complete":
                    $order = $order->whereHas(
                        'gig',
                        function ($q) {
                            $q->where('gigs.user_id', user()->id);
                        }
                    )
                        ->with('gig.user')
                        ->where('status', 'active')
                        ->first();

                    if ($order) {
                        $order->status = "completed";
                        $order->save();

                        // Earning::create([
                        //     'status' => 'pending',
                        //     'amount' => $order->amount,
                        //     'user_id' => user()->id
                        // ]);
                    }
                    break;
                case "activate":
                    $order = $order->whereHas(
                        'gig',
                        function ($q) {
                            $q->where('gigs.user_id', user()->id);
                        }
                    )
                        ->with('gig.user')
                        ->where('status', 'pending')
                        ->first();

                    if ($order) {
                        $order->status = "active";
                        $order->save();

                        // Earning::create([
                        //     'status' => 'pending',
                        //     'amount' => $order->amount,
                        //     'user_id' => user()->id
                        // ]);
                    }
                    break;
                case "reject":
                    $order = $order->whereHas(
                        'gig',
                        function ($q) {
                            $q->where('gigs.user_id', user()->id);
                        }
                    )
                        ->with('gig.user')
                        ->where('status', 'pending')
                        ->first();

                    if ($order) {
                        $order->status = "rejected";
                        $order->save();

                        // Earning::create([
                        //     'status' => 'pending',
                        //     'amount' => $order->amount,
                        //     'user_id' => user()->id
                        // ]);
                    }
                    break;
            }
        }
    }

    public function rate(Request $request)
    {
        $request->validate([
            'content' => 'required|max:500|string',
            'gig_id' => 'required|exists:gigs,id',
        ]);

        $gig = Gig::where([
            'id' => $request->gig_id,
            'status' => 'active'
        ])->first();

        if ($gig) {
            $order = Order::where([
                'user_id' => user()->id,
                'gig_id' => $gig->id,
            ])->first();

            if ($order) {
                $review = Review::create([
                    'content' => $request->content,
                    'reply' => null,
                    'user_id' => user()->id,
                    'gig_id' => $gig->id
                ]);

                foreach ($request->ratings as $key => $name) {
                    Rate::create([
                        'name' => $key,
                        'count' => $name,
                        'review_id' => $review->id,
                        'gig_id' => $gig->id
                    ]);
                }
            }
        }

        return to_route('purchases')->with('message', __('Thanks for your review'));
    }
}
