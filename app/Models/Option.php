<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'content'];

    protected function content(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value) {
                if (isJson($value))
                    return json_decode($value, true);

                return $value;
            },
            set: function (mixed $value) {
                if (is_array($value)) {
                    return json_encode($value);
                }

                return $value;
            },
        );
    }
}
