<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;

class Order extends Model
{
    use HasFactory, Userstamps;

    const STATUS = [
        'ordered' => 'O',
        'sent' => 'S',
        'delivered' => 'A',
//        'blocked' => 'B',
        'waiting' => 'W',
        'cancelled' => 'C'
    ];

    protected $guarded = ['id'];

    public function user()
    {
        //Doesn't work without this
        return $this->belongsTo(User::class, 'user_id')->withoutGlobalScopes();
    }

    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id')->withoutGlobalScopes();
    }

    public function scopeCreatedBetween(Builder $query, $start, $end): Builder
    {
        return $query->whereBetween('created_at', [$start . ' 00:00:00', $end . ' 23:59:59']);
    }
}
