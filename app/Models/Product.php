<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\HasTranslatableSlug;
use Spatie\Sluggable\SlugOptions;

class Product extends Model implements HasMedia
{
    use HasFactory, HasSlug, SoftDeletes;
    use InteractsWithMedia {
        getFirstMediaUrl as protected getFirstMediaUrlTrait;
    }

    protected $fillable = [
        'name',
        'slug',
        'description',
        'category_id',
        'brand_id',
        'added_by',
        'gender',
        'purchase_type',
        'is_active',
        'step',
    ];
    protected $casts = [
        'is_active' => 'boolean',
        'updated_at' => 'datetime:Y-m-d',
    ];
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->slugsShouldBeNoLongerThan(50)
            ->usingSeparator('_')
            ->preventOverwrite();
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->fit(Manipulations::FIT_CROP, 200, 200)
            ->sharpen(10);

        $this->addMediaConversion('icon')
            ->fit(Manipulations::FIT_CROP, 100, 100)
            ->sharpen(10);
    }

    /**
     * to generate media url in case of fallback will
     * return the file type icon
     * @param string $conversion
     * @return string url
     */
    public function getFirstMediaUrl($collectionName = 'default', $conversion = '')
    {
        $exptime = Carbon::now()->addMinutes(10);
        $url = $this->getFirstMediaUrlTrait($collectionName);
        Log::info($url);
        if ($url) {
            $array = explode(".", $url);
            $extension = strtolower(end($array));
            if (in_array($extension, config('media-library.extensions_has_thumb'))) {
                if($this->media->first()->disk != "s3")
                {
                    return asset($this->getFirstMediaUrlTrait($collectionName, $conversion));
                }

                return $this->getFirstTemporaryUrl($exptime,$collectionName, $conversion);
            } else {
                return asset(config('media-library.icons_folder') . '/' . $extension . '.png');
            }
        } else {
            return asset('images/avatar_default.png');
        }
    }
    public function scopeFindBySlug($query, $slug, $columns = ['*'])
    {
        $field = $this->getSlugOptions()->slugField;

        $field = in_array(HasTranslatableSlug::class, class_uses_recursive(static::class))
            ? "{$field}->{$this->getLocale()}"
            : $field;

        return $query->where($field, $slug)->first($columns);
    }
    /**
     * Add Media to api results
     * @return bool
     */
    public function getHasMediaAttribute(): bool
    {
        return $this->hasMedia('product');
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function addedBy()
    {
        return $this->belongsTo(User::class, 'added_by');
    }

    public function productToVariations()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function groupByVariation()
    {
        return $this->productToVariations->groupBy('variation.name');
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    public function defaultStock()
    {
        return $this->hasOne(Stock::class)->where('is_default',1);
    }

    public function getHasVariationsAttribute()
    {
        return $this->productToVariations()->exists();
    }

    public function getHasStocksAttribute()
    {
        return $this->stocks()->exists();
    }

    // public function reviews()
    // {
    //     return $this->hasMany(ProductReview::class);
    // }

    // public function getRatingAttribute()
    // {
    //     return $this->reviews->avg('rating');
    // }

    // public function orderDetails()
    // {
    //     return $this->hasMany(OrderDetails::class, 'product_id', 'id');
    // }
}
