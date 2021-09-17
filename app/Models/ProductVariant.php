<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;

class ProductVariant extends Model
{
    use HasFactory, Userstamps;

    protected $guarded = ['id'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function optionValues()
    {
        return $this->belongsToMany(
            OptionValue::class,
            'variant_values',
            'product_variant_id',
            'option_value_id'
        )->withTimestamps();
    }
}
