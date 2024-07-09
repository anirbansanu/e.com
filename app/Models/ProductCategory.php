<?php

// app\Models\ProductCategory.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'is_active',
    ];
    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
