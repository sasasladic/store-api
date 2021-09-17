<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;

class UserOrder extends Model
{
    use HasFactory, Userstamps;


    public function user()
    {
        //Doesn't work without this
        return $this->belongsTo(User::class, 'user_id')->withoutGlobalScopes();
    }

    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id')->withoutGlobalScopes();
    }
}
