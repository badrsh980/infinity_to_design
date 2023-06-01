<?php

use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\GigsController;
use App\Http\Controllers\Admin\MessagesController;
use App\Http\Controllers\Admin\OrdersController;
use App\Http\Controllers\Admin\PostsController;
use App\Http\Controllers\Admin\ReviewsController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\GigController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RequestController;
use App\Models\Category;
use App\Models\Chat;
use App\Models\Request;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index']);
Route::get('/categories/{slug}', [HomeController::class, 'gigsBycategory'])->name('category');
Route::match(['get', 'post'], '/support', [HomeController::class, 'support'])->name('support');
Route::get('/user/{username}', [HomeController::class, 'user'])->name('user');
Route::match(['get', 'post'], '/gig/{slug}', [HomeController::class, 'gig'])->name('gig');
Route::get('/blog/{slug?}', [HomeController::class, 'blog'])->name('blog');
Route::get('/search/{slug}', [HomeController::class, "search"])->name('search');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::match(['get', 'post'], '/cart', [CartController::class, 'index'])->name('cart');
    Route::match(['get', 'post'], '/cart/pay', [CartController::class, 'pay'])->name('pay');
    Route::post('/add-item', [CartController::class, 'addItem'])->name('cart.add');
    Route::post('/create-offer/{complete?}', [CartController::class, 'createOfferPayment'])->name('cart.create-offer');
    Route::post('/complete-offer/{invoice_id}', [CartController::class, 'completeOffer'])->name('cart.complete-offer');

    Route::get('/requests', [RequestController::class, 'requests'])->name('requests');
    Route::match(['get', 'post'], '/requests/{slug}', [RequestController::class, 'requests_show'])->name('requests.show');

    // Route::prefix('user')->as('user.')->group(function () {
    //     Route::get('orders')->name('orders');
    // });

    Route::prefix('member')->as('member.')->group(function () {
        Route::resource('requests', RequestController::class)->except('show');
    });

    Route::middleware(['role:Admin'])->prefix('admin')->as('admin.')->group(function () {
        Route::resource('/users', UsersController::class);
        Route::post('/gigs/{gig}', [GigsController::class, 'update'])->name('gigs.update');
        Route::resource('/gigs', GigsController::class)->except('update');
        Route::resource('/orders', OrdersController::class);
        Route::post('/categories/{category}', [CategoriesController::class, 'update'])->name('categories.update');
        Route::resource('/categories', CategoriesController::class)->except('update');
        Route::resource('/messages', MessagesController::class);
        Route::post('/posts/{post}', [PostsController::class, 'update'])->name('posts.update');
        Route::resource('/posts', PostsController::class)->except('update');
        Route::resource('/reviews', ReviewsController::class);
        Route::match(['get', 'post'], '/settings', [HomeController::class, 'settings'])->name('settings');
        Route::post('/get-users', [HomeController::class, 'getUsers'])->name('api.get-users');
    });

    Route::post('/gigs/{gig}', [GigController::class, 'update'])->name('gigs.update');
    Route::post('/gigs/delete-extra/{extra}/{gig}', [GigController::class, 'deleteExtra'])->name('gigs.delete-extra');
    Route::resource('/gigs', GigController::class)->except('update');

    Route::match(['get', 'post'], '/credit', [HomeController::class, 'credit'])->name('credit');
    Route::match(['get', 'post'], '/profile', [HomeController::class, 'profile'])->name('profile');
    Route::match(['get', 'post'], '/message/{chat}', [HomeController::class, 'message'])->name('chats.message');

    Route::get('/orders', [OrderController::class, 'orders'])->name('orders');
    Route::post('/orders/update/{id}', [OrderController::class, 'update'])->name('orders.update');
    Route::post('/orders/rate', [OrderController::class, 'rate'])->name('orders.rate');
    Route::get('/purchases', [OrderController::class, 'purchases'])->name('purchases');

    Route::post('/create-chat/{user_id}/{order_id?}', [HomeController::class, 'createChat'])->name('create-chat');

    Route::post('/update-cart-items/{item_id}', [CartController::class, 'updateCartItems'])->name('api.update-items-cart');
    Route::post('/confirm-payment/{type}', [CartController::class, 'confirmPayment'])->name('api.confirm-payment');
    Route::post('/get-chats', [HomeController::class, 'chats'])->name('api.chats');

    Route::post('/get-cats', function () {
        $categories = Category::get();

        return response()->json([
            'categories' => $categories
        ]);
    })->name('get-cats');

    Route::post('/notifications/read/{id}', function ($id, Request $request) {
        $notification = User::where('id', user()->id)->first()->unreadNotifications()->where('id', $id)->first();
        $notification->markAsRead();
        return redirect($notification->data['link']);
    })->name('notifications.read');

    Route::post('/messages/read/{chat}', function ($chat, Request $request) {
        $chat = Chat::where('id', $chat)->with([
            'messages' => function ($q) {
                $q->where('user_id', '!=', user()->id);
            }
        ])->first();

        if ($chat) {
            $chat->messages()->update([
                'readed' => 'yes'
            ]);
        }
    })->name('messages.read');

    Route::post('/review-reply', function (HttpRequest $request) {
        $request->validate([
            'content' => 'required|string|max:1000'
        ]);

        $review = Review::where([
            'reply' => null,
            'gig_id' => $request->gig_id,
            'id' => $request->review_id
        ])->first();

        if ($review) {
            $review->reply = $request->content;
            $review->save();

            return to_route('gig', ['slug' => $request->slug]);
        }
    })->name('create-reply');
});

Route::get('/config', function () {
    \Illuminate\Support\Facades\Artisan::call('migrate:fresh --seed');
    // \Illuminate\Support\Facades\Artisan::call('storage:link');

    // Mail::to('ajama3abdo32@gmail.com')->send(new GigApproved(Gig::first()));
});

require __DIR__ . '/auth.php';
