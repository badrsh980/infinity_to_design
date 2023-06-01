<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'status',
        'email',
        'password',

        'username',
        'specialization',
        'thumbnail',
        'description',

        'token'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = [
        'created_date',
        'updated_date',
        'get_notifications',
        'tr_status',
        'email_verified_at_date'
    ];

    /**
     * Get the user's preferred locale.
     */
    public function preferredLocale(): string
    {
        return 'ar';
    }

    public function gigs()
    {
        return $this->hasMany(Gig::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function earnings()
    {
        return $this->hasMany(Earning::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function createdDate(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value) => $this->created_at->format('D M Y')
        );
    }

    public function updatedDate(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value) => $this->updated_at->format('D M Y')
        );
    }

    public function trStatus(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value) => __($this->status)
        );
    }

    public function emailVerifiedAtDate(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value) => $this->email_verified_at?->format('d, M Y')
        );
    }

    public function getNotifications(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value) => $this->notifications()->limit(10)->get()->each(function ($notification) {
                $notification->formated_created_at = $notification->created_at->diffForHumans();
            })
        );
    }
}
