<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Extra extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'price',
        'change_gig_date',
        'extra_time',
        'gig_id'
    ];

    protected $appends = [
        'price_formated',
        'time_formated'
    ];

    public function gig()
    {
        $this->belongsTo(Gig::class);
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
                if ($this->extra_time == 1) {
                    return __('يوم واحد');
                } else if ($this->extra_time == 2) {
                    return __('يومين');
                } else if ($this->extra_time >= 3 && $this->extra_time <= 10) {
                    return $this->extra_time . ' ' . __('أيام');
                } else {
                    return $this->extra_time . ' ' . __('يوما');
                }
            },
            set: fn () => null
        );
    }
}
