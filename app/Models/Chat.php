<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_one',
        'user_two',
        'order_id'
    ];

    protected $appends = [
        'message',
        'created_date'
    ];

    public function user_one()
    {
        return $this->belongsTo(User::class, 'user_one');
    }

    public function user_two()
    {
        return $this->belongsTo(User::class, 'user_two');
    }

    public function one()
    {
        return $this->belongsTo(User::class, 'user_one');
    }

    public function two()
    {
        return $this->belongsTo(User::class, 'user_two');
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function messages()
    {
        return $this->hasMany(ChatMessage::class, 'chat_id');
    }

    public function message(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->hasMany(ChatMessage::class)->orderBy('id', 'desc')->first()
        );
    }

    public function createdDate(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->created_at->diffForHumans()
        );
    }
}
