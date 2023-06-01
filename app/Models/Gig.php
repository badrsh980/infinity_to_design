<?php

namespace App\Models;

use App\Models\Scopes\MineScope;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gig extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'title',
        'slug',
        'description',
        'thumbnails',
        'delivery_time',
        'instructions',
        'price',
        'user_changes',
        'language',
        'user_id',
        'category_id',
    ];

    protected $appends = [
        'price_formated',
        'tr_status',
        'time_formated',
        'updated_date',
        'created_date',
    ];

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        // static::addGlobalScope(new MineScope);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function extras()
    {
        return $this->hasMany(Extra::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function rates()
    {
        return $this->hasMany(Rate::class);
    }


    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    protected function thumbnails(): Attribute
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
            get: fn () => price_format($this->price),
            set: fn () => null
        );
    }

    public function timeFormated(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->delivery_time == 1) {
                    return __('يوم واحد');
                } else if ($this->delivery_time == 2) {
                    return __('يومين');
                } else if ($this->delivery_time >= 3 && $this->delivery_time <= 10) {
                    return $this->delivery_time . ' ' . __('أيام');
                } else {
                    return $this->delivery_time . ' ' . __('يوما');
                }
            },
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
