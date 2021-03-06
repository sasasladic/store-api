<?php

namespace App\Models;

use App\Scopes\ActiveScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Spatie\Translatable\HasTranslations;
use Wildside\Userstamps\Userstamps;

/**
 * @property mixed active
 * @property mixed|null category_id
 * @property mixed id
 */
class Product extends Model
{
    use HasFactory, Userstamps, SoftDeletes, HasTranslations;

    public array $translatable = ['name', 'description'];

    protected $guarded = ['id'];

    public function categoryGender()
    {
        return $this->belongsTo(CategoryGender::class)->with('category');
    }

    public function allVariants()
    {
        return $this->hasMany(ProductVariant::class, 'product_variant_id')->withoutGlobalScopes();
    }

    public function activeVariants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImages::class);
    }

    public function options()
    {
        return $this->belongsToMany(
            Option::class,
            'product_options',
            'product_id',
            'option_id'
        )->with('values')->withTimestamps();
    }

    /**
     * Scope a query to only include active users.
     *
     * @param Builder $query
     * @param null $licenses
     * @return Builder
     */
    public function scopeUniquePrice($query)
    {
        return $query->join(
            DB::raw("( SELECT product_id, MIN(price) as lowest FROM product_variants
                     group by product_id ) AS variants"),
            function ($join) {
                $join->on('products.id', 'variants.product_id');
            });
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
