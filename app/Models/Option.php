<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;

class Option extends Model
{
    use HasFactory, Userstamps;

    protected $guarded = ['id'];

    public function values()
    {
        return $this->hasMany(OptionValue::class);
    }

    public function products()
    {
        return $this->belongsToMany(
            Product::class,
            'product_options',
            'option_id',
            'product_id'
        )->withTimestamps();
    }
}
