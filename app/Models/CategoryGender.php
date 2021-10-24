<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryGender extends Model
{
    use HasFactory;

    protected $table = 'category_gender';

    protected $guarded = ['id'];

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function rootCategory() {
        return $this->belongsTo(Category::class, 'category_id', 'id')->whereNull('parent_id');
    }

    public function gender() {
        return $this->belongsTo(Gender::class);
    }

    public function allProducts()
    {
        return $this->hasMany(Product::class)->withoutGlobalScopes();
    }

    public function activeProducts()
    {
        return $this->hasMany(Product::class);
    }
}
