<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Chat;
use App\Models\ChatMessage;
use App\Models\Gig;
use App\Models\Invoice;
use App\Models\Message;
use App\Models\Option;
use App\Models\Post;
use App\Models\Rate;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Closure;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::get();
        $faqs = getOption("faqs", []);

        return Inertia('Welcome', compact('categories', 'faqs'));
    }

    public function gigsBycategory($slug, Request $request)
    {
        $category = Category::where('slug', $slug)->firstOrfail();
        $gigs = Gig::with([
            'user'
        ]);

        $gigs->withCount('reviews as r_count');
        $gigs->withAvg([
            'rates as r_avg'
        ], 'count');

        $gigs->when($request->search, function ($query, $search) {
            $query->where('gigs.title', 'like', '%' . $search . '%');
        });

        $gigs->when($request->rate, function ($query, $rate) {
            $query->whereRelation(
                'rates',
                Rate::select(DB::raw('AVG(rates.count)'))->whereColumn('gigs.id', '=', 'rates.gig_id'),
                '>=',
                $rate
            );
        });

        $gigs->where([
            'category_id' => $category->id,
            'status' => 'active'
        ]);

        $gigs = $gigs->inRandomOrder()->paginate(20);

        $categories = Category::withCount([
            'gigs as count' => function ($q) {
                $q->where('status', 'active');
            }
        ])->get();

        return Inertia('GigsBycategory', compact('category', 'gigs', 'slug', 'categories'));
    }

    public function search($slug)
    {
        $gigs = Gig::with([
            'user'
        ]);

        $gigs->withCount('reviews as r_count');
        $gigs->withAvg([
            'rates as r_avg'
        ], 'count');

        $gigs->where([
            'status' => 'active'
        ]);

        $gigs->where('title', 'like', "%$slug%");

        $gigs = $gigs->inRandomOrder()->paginate(20);

        return Inertia::render('Search', compact('gigs'));
    }

    public function gig($slug, Request $request)
    {
        $gig = Gig::with(['user', 'category', 'extras', 'reviews', 'reviews.user', 'reviews.rates'])
            ->where([
                'slug' => $slug,
                'status' => 'active'
            ])
            ->withCount([
                'reviews as r_count',
                'orders as o_count',
                'orders as a_count' => function ($q) {
                    return $q->where('status', 'active');
                }
            ])
            ->withAvg([
                'rates as r_avg'
            ], 'count')
            ->firstOrFail();

        $recommended_gigs = Gig::with(['user', 'category'])->where([
            'status' => 'active',
            'category_id' => $gig->category_id
        ])->inRandomOrder()->limit(6)->get();

        $reviews_types = getOption('reviews_types', []);
        $categories = Category::get();

        return Inertia::render('Gig', compact('gig', 'recommended_gigs', 'reviews_types', 'categories'));
    }

    public function user($username)
    {
        $categories = Category::get();

        $user = User::withCount(['gigs', 'orders'])->with([
            'gigs' => function ($q) {
                $q->where(['status' => 'active'])->with(['user'])->withCount('reviews as r_count')
                    ->withAvg([
                        'rates as r_avg'
                    ], 'count');
            }
        ])->where('username', $username)->firstOrFail();

        $count = 0;
        $avg = 0;


        foreach ($user->gigs as $gig) {
            if ($gig->r_count) {
                $count += $gig->r_count;
            }
            if ($gig->r_avg) {
                $avg += $gig->r_avg;
            }
        }

        if ($count > 0)
            $avg /= $count;

        return Inertia::render("User", compact('categories', 'user', 'avg', 'count'));
    }

    public function credit(Request $request)
    {

        $user = User::where('id', user()->id)->with(['invoices'])->withSum(['earnings as pending_balance' => function ($q) {
            $q->where('status', 'pending');
        }], 'amount')->firstOrFail();

        if ($request->isMethod('post') && $request->page == "withdraw") {
            if ($user->balance > 5) {
                Invoice::create([
                    'status' => 'pending',
                    'type' => 'withdraw',
                    'payment_method' => $user->withdrawal_method ?? 'paypal',
                    'details' => null,
                    'amount' => $user->balance,
                    'order_id' => null,
                    'user_id' => $user->id,
                ]);

                $user->balance = 0;
                $user->save();

                return to_route('credit');
            }
        }

        $categories = Category::get();

        $balance = $user->balance;

        $pending_balance = $user->pending_balance;

        $all = $balance + $pending_balance;

        return Inertia::render('Credit', compact('categories', 'balance', 'pending_balance', 'all', 'user'));
    }

    public function profile(Request $request)
    {
        $user = user();
        $categories = Category::get();
        $countries = get_countries();
        $methods = getOption('withdrawal_methods');
        $withdrawal_methods = collect($methods)->map(function ($value) {
            return __($value);
        });

        if ($request->isMethod('post')) {
            $user = User::where('id', $user->id)->firstOrFail();

            if ($request->thumbnail) {
                $request->validate([
                    'thumbnail' => 'required|mimes:jpg,jpeg,png,gif|max:2048'
                ]);

                try {
                    if ($request->thumbnail instanceof UploadedFile) {
                        $thumbnail = $request->thumbnail;

                        try {
                            $name = unique_str() . $thumbnail->getClientOriginalName();

                            $thumbnail->storeAs('/public/images/users/', $name);

                            $user->thumbnail = $name;
                            $user->save();

                            session()->flash('message', __('Profile Image has been updated'));
                            return to_route('profile');
                        } catch (\Throwable $th) {
                            return false;
                        }
                    }
                } catch (\Throwable $th) {
                    //throw $th;
                }
            }

            $password = $user->password;

            $request->validate([
                // 'username' => 'required|unique:users,username|max:100',
                'name' => 'required|string|max:100',
                // "email" => 'required|',
                "address" => 'required|string|max:200',
                "country" => 'required|in:' . implode(',', array_keys($countries)),
                "specialization" => 'required|string|max:30',
                "description" => 'required|string|max:500',
                "withdrawal_email" => 'required|email|max:100',
                "withdrawal_method" => 'required|in:' . implode(',', array_keys($methods)),
            ]);

            if ($request->password) {
                $request->validate([
                    'old_password' => [
                        function (string $attribute, mixed $value, Closure $fail) use ($user) {
                            if (!Hash::check($value, $user->password)) {
                                $fail(__('Old Password Incorrect'));
                            }
                        }
                    ],
                    'password' => [
                        'required',
                        'confirmed',
                    ],
                ]);

                $password = Hash::make($request->password);
            }

            $user->update([
                'status' => 'pending',
                'name' => $request->name,
                'password' => $password,
                'address' => $request->address,
                'country' => $request->country,
                'specialization' => $request->specialization,
                'description' => $request->description,
                'withdrawal_method' => $request->withdrawal_method,
            ]);

            session()->flash('message', __('Profile has been updated'));
            return to_route('profile');
        }


        return Inertia::render('Profile', compact('user', 'categories', 'countries', 'withdrawal_methods'));
    }

    public function support(Request $request)
    {
        $categories = Category::get();

        if ($request->isMethod('post')) {
            $request->validate([
                'name' => 'required|string|max:100',
                'subject' => 'required|string|max:100',
                'email' => 'required|email|max:100',
                'message' => 'required|string|max:1000',
            ]);

            Message::create([
                'name' => $request->name,
                'subject' => $request->subject,
                'email' => $request->email,
                'message' => $request->message,
            ]);

            session()->flash('message', __('Message has been sent'));
            return to_route('support');
        }

        return Inertia::render("Support", compact('categories'));
    }

    public function message($chat, Request $request)
    {
        $categories = Category::get();


        $mychat = Chat::with([
            'messages' => fn ($q) => $q->with(['user']),
            'order',
            'order.gig',
            'one',
            'two'
        ])
            ->where('id', $chat)
            ->where([
                'user_one' => user()->id
            ])
            ->orWhere(fn ($q) => $q->where('id', $chat)->where(['user_two' => user()->id]))
            ->firstOrFail();

        $recipient = (user()->id == $mychat->user_one) ? $mychat->two : $mychat->one;

        $milestones = Invoice::where([
            'type' => 'milestone',
            'user_id' => user()->id,
            'recipient_id' => $recipient->id
        ])->get();

        if ($request->isMethod('post')) {

            if ($request->content instanceof \Illuminate\Http\UploadedFile) {
                $request->validate([
                    'content' => 'required|file|mimes:png,jpg,jpeg,gif,pdf,docs,txt,rar,zip|max:' . 1024 * 200
                ]);

                $file = $request->content;
                $name = unique_str() . $file->getClientOriginalName();
                $file->storeAs("/public/files/", $name);

                ChatMessage::create([
                    'content' => $name,
                    'readed' => 'no',
                    'file' => 'yes',
                    'chat_id' => $mychat->id,
                    'user_id' => user()->id,
                ]);

                return to_route('chats.message', ['chat' => $mychat->id]);
            }

            $request->validate([
                'content' => 'required|max:1000|string'
            ]);

            ChatMessage::create([
                'content' => $request->content,
                'readed' => 'no',
                'chat_id' => $mychat->id,
                'user_id' => user()->id,
            ]);

            return to_route('chats.message', ['chat' => $mychat->id]);
        }

        return Inertia::render('Chat', [
            'categories' => $categories,
            'chat' => $mychat,
            'recipient' => $recipient,
            'milestones' => $milestones
        ]);
    }

    public function settings(Request $request)
    {
        $options = Option::get()->pluck('content', 'name')->toArray();


        if ($request->isMethod('post')) {

            $request->validate([
                "options.faqs" => "required|array",
                "options.faqs.*" => "required|array:id,title,body",

                "options.about_menu" => "required|array",
                "options.about_menu.*" => "required|array:id,title,link",

                "options.footer_menu" => "required|array",
                "options.footer_menu.*" => "required|array:id,title,link",

                "options.reviews_types" => "required|array",
                "options.withdrawal_methods" => "required|array",

                // "options.facebook_url" => "required",
                // "options.twitter_url" => "required",
                // "options.currency_code" => "required",
                // "options.payment_fees" => "required",
                // "options.stripe_secret_key" => "required",
                // "options.stripe_public_key" => "required",
                // "options.paypal_client_id" => "required",
            ]);
            foreach ($request->options as $key => $value) {
                $option = Option::where('name', $key)->first();

                if ($key == 'reviews_types' || $key == 'withdrawal_methods') {
                    $content = [];

                    foreach ($value as $v) {
                        $content[$v['key']] = $v['name'];
                    }


                    if ($option) {
                        $option->content = $content;
                        $option->save();
                    }
                } else {

                    if ($option) {
                        $option->content = $value;
                        $option->save();
                    }
                }
            }

            return to_route('admin.settings');
        }

        return Inertia::render("Admin/Settings", compact('options'));
    }

    public function blog($slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();
        $categories = Category::get();

        return Inertia::render("Post", compact('post', 'categories'));
    }

    // api

    public function chats()
    {
        try {
            $chats = Chat::with([
                'user_one',
                'user_two'
            ])->where([
                'user_one' => user()->id
            ])
                ->orWhere(fn ($q) => $q->where(['user_two' => user()->id]))
                ->whereHas('messages')
                ->get();

            return response()->json([
                'chats' => $chats,
                'showBullChats' => ($chats->count() == 0) ? false : $chats->every(function ($chat) use ($chats) {
                    if ($chat->messages->where('readed', 'no')->first()) {
                        return true;
                    }
                })
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ]);
        }
    }

    public function getUsers(Request $request)
    {
        $users = User::select('name', 'id')->where('name', 'like', "%$request->search%")->limit(10)->get()->pluck('name', 'id')->toArray();

        return response()->json([
            'users' => $users
        ]);
    }

    public function createChat($user_id, $order_id = null)
    {
        $user = User::where('id', $user_id)->where('id', '!=', user()->id)->firstOrFail();

        $chat = Chat::where([
            'user_one' => $user->id,
            'user_two' => user()->id,
            'order_id' => $order_id
        ])
            ->orWhere(function ($q) use ($user, $order_id) {
                $q->where([
                    'user_one' => user()->id,
                    'user_two' => $user->id,
                    'order_id' => $order_id
                ]);
            })->first();

        if (!$chat) {
            $chat = Chat::create([
                'user_one' => $user->id,
                'user_two' => user()->id,
                'order_id' => $order_id
            ]);
        }

        return to_route('chats.message', ['chat' => $chat->id]);
    }
}
