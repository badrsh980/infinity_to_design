<?php

namespace App\Models;

use App\Models\Scopes\MineScope;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'extras',
        'gig_id',
        'cart_id'
    ];

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function gig()
    {
        return $this->belongsTo(Gig::class)->withoutGlobalScope(new MineScope);
    }

    protected function extras(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value) {
                if (isJson($value))
                    return json_decode($value);

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
