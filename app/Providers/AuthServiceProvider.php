<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Mail\GigApproved;
use App\Models\Gig;
use App\Models\User;
use App\Notifications\GigApproved as NotificationsGigApproved;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {

        // $user = User::where([
        //     'status' => 'active'
        // ])->first();


        // $user->notify(new NotificationsGigApproved(Gig::with(['user'])->where('user_id', $user->id)->first()));

        // if (!auth()->check()) {
        //     $user = User::where([
        //         'status' => 'active'
        //     ])->first();

        //     if ($user) {
        //         $user->assignRole('Admin');

        //         Auth::login($user);
        //     }
        // }
    }
}
