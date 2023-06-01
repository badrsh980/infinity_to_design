<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'amount',
        'delivery_at',

        'user_id',
        'gig_id',
    ];

    protected $appends = [
        'tr_status',
        'price_formated',
        'time_formated',
        'created_date',
        'updated_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function gig()
    {
        return $this->belongsTo(Gig::class);
    }

    public function extras()
    {
        return $this->hasMany(OrderExtra::class);
    }

    public function trStatus(): Attribute
    {
        return Attribute::make(
            get: fn () => __($this->status),
            set: fn () => null
        );
    }

    public function priceFormated(): Attribute
    {
        return Attribute::make(
            get: fn () => price_format($this->amount),
            set: fn () => null
        );
    }

    public function timeFormated(): Attribute
    {
        return Attribute::make(
            get: fn () => Carbon::parse($this->delivery_at)->diffForHumans(),
            set: fn () => null
        );
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
}
