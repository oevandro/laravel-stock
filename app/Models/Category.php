<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    protected $fillable = ['name'];

    protected $casts = [
        'created_at' => 'datetime:d/m/Y h:i',
        'updated_at' => 'datetime:d/m/Y h:i'
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
