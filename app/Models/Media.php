<?php
/*
 * File name: Media.php
 * Last modified: 2022.02.02 at 19:14:31
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2022
 */

namespace App\Models;

use Carbon\Carbon;
use Spatie\MediaLibrary\HasMedia as MediaLibraryHasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media as BaseMedia;

/**
 * @property mixed size
 */
class Media extends BaseMedia implements MediaLibraryHasMedia
{
    use InteractsWithMedia {
        getFirstMediaUrl as protected getFirstMediaUrlTrait;
    }

    protected $appends = [
        'url',
        'thumb',
        'icon',
        'formated_size',
        'cast_uuid'
    ];

    protected $hidden = [
        "responsive_images",
        "order_column",
        "created_at",
        "updated_at",
    ];

    public function getUrlAttribute()
    {

        $exptime = Carbon::now()->addMinutes(10);
        if($this->disk != "s3")
        {
            return $this->getFullUrl();
        }

        return $this->getTemporaryUrl($exptime);

    }

    public function getThumbAttribute()
    {
        if($this->hasGeneratedConversion('thumb')){
            return $this->getFirstMediaUrl('thumb');
        }else{
            return  $this->getFullUrl();
        }
    }

    /**
     * to generate media url in case of fallback will
     * return the file type icon
     * @param string $conversion
     * @return string url
     */
    public function getFirstMediaUrl($conversion = '')
    {
        $exptime = Carbon::now()->addMinutes(10);
        $url = $this->getUrl();
        $array = explode('.', $url);
        $extension = strtolower(end($array));
        if (in_array($extension, config('media-library.extensions_has_thumb'))) {

            if($this->disk != "s3")
            {
                return asset($this->getUrl($conversion));
            }

            return $this->getTemporaryUrl($exptime,$conversion);

        } else {
            return asset(config('media-library.icons_folder') . '/' . $extension . '.png');
        }
    }

    public function getIconAttribute()
    {
        if($this->hasGeneratedConversion('icon')){
            return $this->getFirstMediaUrl('icon');
        }else{
            return  $this->getFullUrl();
        }
    }
    public function getFormatedSizeAttribute()
    {
        return formatedSize($this->size);
    }

    public function getCastUuidAttribute()
    {
        return $this->custom_properties['uuid'];
    }
    public function toArray(): array
    {
        if(!$this->hasGeneratedConversion('icon')){
            parent::makeHidden('icon');
        }
        if(!$this->hasGeneratedConversion('thumb')){
            parent::makeHidden('thumb');
        }
        parent::makeHidden(['model_type','model_id','collection_name','file_name','disk','size','manipulations','custom_properties']);
        return parent::toArray();
    }
}
