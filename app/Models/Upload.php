<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Upload extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia {
        getMedia as protected getMediaTrait;
        getFirstMediaUrl as protected getFirstMediaUrlTrait;
    }

    public $fillable = [
        'uuid'
    ];

    private $performed = 'default';

    /**
     * @param Media|null $media
     * @throws InvalidManipulation
     */
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->fit(Manipulations::FIT_CROP, 200, 200)
            ->sharpen(10);

        $this->addMediaConversion('icon')
            ->fit(Manipulations::FIT_CROP, 100, 100)
            ->sharpen(10);
    }

    // TODO
    public function getFirstMediaUrl($collectionName = 'default', $conversion = '')
    {
        $exptime = Carbon::now()->addMinutes(10);
        $url = $this->getFirstMediaUrlTrait($collectionName);
        if($url){
            $array = explode('.', $url);
            $extension = strtolower(end($array));
            if (in_array($extension, ['jpg', 'png', 'gif', 'bmp', 'jpeg'])) {
                if($this->media->first()->disk != "s3")
            {
                return asset($this->getFirstMediaUrlTrait($collectionName, $conversion));
            }

            return $this->getFirstTemporaryUrl($exptime,$collectionName, $conversion);
            } else {
                return asset('images/icons/' . $extension . '.png');
            }
        }else{
            return asset('images/image_default.png');
        }
    }

    /**
     * @return string
     */
    public function getPerformed(): string
    {
        return $this->performed;
    }

    /**
     * @param string $performed
     */
    public function setPerformed(string $performed): void
    {
        $this->performed = $performed;
    }

    public function getMedia(string $collectionName = 'default', $filters = []): MediaCollection
    {

        if (count($this->getMediaTrait($collectionName))) {
            return $this->getMediaTrait($collectionName, $filters);
        }
        return $this->getMediaTrait('default', $filters);
    }
}
