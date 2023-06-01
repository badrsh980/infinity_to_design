<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'type',
        'payment_method',
        'details',
        'amount',
        'order_id',
        'user_id',
        'recipient_id'
    ];

    protected $appends = [
        'tr_type',
        'tr_status',
        'method',
        'created_date'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function recipient()
    {
        return $this->belongsTo(User::class, 'recipient_id');
    }

    protected function details(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value) {
                if (isJson($value))
                    return json_decode($value, true);

                return $value;
            },
            set: function (mixed $value) {
                if (is_array($value))
                    return json_encode($value);

                return $value;
            }
        );
    }

    protected function trType(): Attribute
    {
        return Attribute::make(
            get: fn () => __($this->type)
        );
    }

    protected function trStatus(): Attribute
    {
        return Attribute::make(
            get: fn () => __($this->status)
        );
    }

    protected function method(): Attribute
    {
        return Attribute::make(
            get: fn () => __($this->payment_method)
        );
    }

    protected function createdDate(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->created_at->diffForHumans()
        );
    }
}
