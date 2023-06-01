<?php

namespace App\Models;

use App\Models\Scopes\MineScope;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'count',
        'review_id',
        'gig_id'
    ];

    protected $appends = [
        'tr_name'
    ];

    public function review()
    {
        return $this->belongsTo(Review::class);
    }

    public function gig()
    {
        return $this->belongsTo(Gig::class)->withoutGlobalScope(new MineScope);
    }

    protected function trName(): Attribute
    {
        $rates = getOption('reviews_types');

        return Attribute::make(
            get: fn (mixed $value) => $rates[$this->name] ?? ''
        );
    }
}
