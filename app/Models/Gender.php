<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gender extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    /**
     * The users that belong to the role.
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class)->whereNull('parent_id')->withTimestamps();
    }

//    public function rootCategory() {
//        return $this->belongsTo(Category::class, 'category_id', 'id')->whereNull('parent_id');
//    }

}
