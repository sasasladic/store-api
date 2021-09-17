<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;

class OptionValue extends Model
{
    use HasFactory, Userstamps;

    protected $guarded = ['id'];

    public function option()
    {
        return $this->belongsTo(Option::class);
    }

    public function variants()
    {
        return $this->belongsToMany(
            OptionValue::class,
            'variant_values',
            'option_value_id',
            'product_variant_id'
        )->withTimestamps();
    }
}
