<?php

namespace App\Http\Middleware;

use App\Models\Gig;
use App\Models\Option;
use App\Models\Order;
use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $pending_orders = 0;
        if (auth()->check()) {
            $pending_orders = Order::whereIn('gig_id', Gig::select('id')->where('user_id', user()?->id)->where('status', 'active'))->where('status', 'pending')->count();
        }
        $options = Option::whereIn('name', [
            'currency_code',
            'about_menu',
            'facebook_url',
            'twitter_url',
            'footer_menu',
            'stripe_public_key',
            'paypal_client_id',
        ])->get()->pluck('content', 'name');

        $posts = Post::select("id", "title", "slug")->limit(5)->get();
        return array_merge(parent::share($request), [
            'auth' => [
                'authenticated' => auth()->check(),
                'user' => $request->user(),
                'unreaded_notifications' => $request->user()?->unreadNotifications()->count(),
                'pending_orders' => $pending_orders
            ],
            'ziggy' => function () use ($request) {
                return array_merge((new Ziggy)->toArray(), [
                    'location' => $request->url(),
                ]);
            },
            'options' =>  $options->put(
                'language',
                app()->getLocale()
            ),
            'posts' => $posts,
            'flash' => [
                'message' => fn () => $request->session()->get('message')
            ],
        ]);
    }
}
