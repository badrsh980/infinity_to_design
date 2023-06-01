<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'thumbnail'
    ];

    protected $appends = [
        'image',
        'created_date',
        'updated_date',
    ];

    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn () => asset('/storage/images/' . $this->thumbnail),
        );
    }

    public function gigs()
    {
        return $this->hasMany(Gig::class);
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
