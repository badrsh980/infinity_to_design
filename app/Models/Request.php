<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'title',
        'slug',
        'content',
        'user_id',
    ];

    protected $appends  = ['created_date', 'tr_status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function lastComment()
    {
        return $this->hasOne(Comment::class)->latest()->select('*');
    }

    protected function createdDate(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value) => $this->created_at->diffForHumans()
        );
    }

    protected function trStatus(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value) => __($this->status)
        );
    }
}
