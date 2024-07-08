<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductToVariation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'product_id',
        'variation_id',
        'unit_id',
        'variant_value',
    ];
    protected $appends = [
        'variant_name',
        'unit_name',
        'has_unit',
    ];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function variation()
    {
        return $this->belongsTo(Variation::class);
    }

    public function unit()
    {
        return $this->belongsTo(ProductUnit::class);
    }

    public function getVariantNameAttribute()
    {
        return $this->variation->name;
    }
    public function getUnitNameAttribute()
    {
        return $this->unit ? $this->unit->unit_name : null;
    }
    public function getHasUnitAttribute()
    {
        return $this->variation->has_unit;
    }
}
