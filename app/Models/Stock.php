<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Stock extends Model implements HasMedia
{
    use HasFactory,HasSlug,SoftDeletes;
    use InteractsWithMedia {
        getFirstMediaUrl as protected getFirstMediaUrlTrait;
    }
    protected $fillable = ['product_id', 'price', 'sku', 'quantity'];

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('sku')
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
        return 'sku';
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

    /**
     * Add Media to api results
     * @return bool
     */
    public function getHasMediaAttribute(): bool
    {
        return $this->hasMedia('image');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function combinations()
    {
        return $this->belongsToMany('App\Models\ProductVariant', 'combinations', 'stock_id', 'product_variant_id');
    }

    public function scopeWithCombinations($query)
    {
        return $query->join('combinations', 'stocks.id', '=', 'combinations.stock_id')
                    ->join('product_variants', 'combinations.product_variant_id', '=', 'product_variants.id')
                    ->select('stocks.*',
                            DB::raw('GROUP_CONCAT(product_variants.attribute_name) as attribute_names'),
                            DB::raw('GROUP_CONCAT(product_variants.attribute_value) as attribute_values')
                    )
                    ->groupBy('stocks.id');
    }

    // public function orderDetails()
    // {
    //     return $this->hasMany(OrderDetails::class, 'stock_id', 'id');
    // }

    // public function wistlist()
    // {
    //     return $this->hasMany(Wishlist::class, 'stock_id', 'id');
    // }
    // public function shippingInformation()
    // {
    //     return $this->hasOne(ShippingInformation::class);
    // }
}
