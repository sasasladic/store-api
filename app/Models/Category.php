<?php

namespace App\Models;

use App\Scopes\ActiveScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;
use Wildside\Userstamps\Userstamps;

/**
 * @property mixed active
 * @property mixed parent_id
 * @property mixed id
 */
class Category extends Model
{
    use HasFactory, Userstamps, SoftDeletes, HasTranslations;

    public array $translatable = ['name', 'description'];

    protected $guarded = ['id'];

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function allProducts()
    {
        return $this->hasMany(Product::class, 'product_id')->withoutGlobalScopes();
    }

    public function activeProducts()
    {
        return $this->hasMany(Product::class);
    }

    public function genders()
    {
        return $this->belongsToMany(Gender::class)->withTimestamps()->withPivot('id');
    }

    public function checkBelongsToGender($gender_id)
    {
        return $this->genders()->where('gender_id', $gender_id)->first();
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope(new ActiveScope());
    }
}
