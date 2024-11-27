<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
     // Vezuje model za tabelu "products"
    protected $table = 'products';

    public $primaryKey = 'id';

    // Relacija - jedan Product ima mnogo ProductRating-a
    public function productrating() {
        return $this->hasMany(ProductRating::class);
    }

    protected $fillable = [
        'name',
    ];
}
