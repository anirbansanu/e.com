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
class Stock extends Model implements HasMedia
{
    use HasFactory,SoftDeletes;
    use InteractsWithMedia {
        getFirstMediaUrl as protected getFirstMediaUrlTrait;
    }
    protected $fillable = ['product_id', 'product_price_id', 'sku', 'quantity'];

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
        return $this->belongsToMany('App\Models\ProductToVariation', 'combinations', 'stock_id', 'product_to_variation_id');
    }

    public function scopeWithCombinations($query)
    {
        return $query->join('combinations', 'stocks.id', '=', 'combinations.stock_id')
                    ->join('product_to_variations', 'combinations.product_to_variation_id', '=', 'product_to_variations.id')
                    ->join('variations', 'product_to_variations.variation_id', '=', 'variations.id')
                    ->select('stocks.*',
                            \DB::raw('GROUP_CONCAT(variations.name) as variation_names'),
                            \DB::raw('GROUP_CONCAT(product_to_variations.variant_value) as variant_values')
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
