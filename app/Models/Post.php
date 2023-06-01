<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    public $fillable = ['title', 'slug', 'content', 'is_post'];

    protected $appends = [
        'created_date',
        'updated_date',
    ];

    public function createdDate(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value) => $this->created_at?->format('D M Y')
        );
    }

    public function updatedDate(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value) => $this->updated_at?->format('D M Y')
        );
    }
}
