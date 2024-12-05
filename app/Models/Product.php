<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    // Vezuje model za tabelu "products"
    protected $table = 'products';

    // Primarni ključ tabele
    protected $primaryKey = 'id';

    // Relacija - jedan Product ima mnogo ProductRating-a
    public function productRatings()
    {
        return $this->hasMany(ProductRating::class);
    }
    
    protected $fillable = [
        'name',
    ];
}
