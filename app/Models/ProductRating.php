<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductRating extends Model
{
    use HasFactory;
    protected $table = 'product_ratings';

    public $primaryKey = 'id';

    public function userkey() {
        return $this->belongsTo(User::class, 'user');
    }

    //belongsTo znači da svaki zapis u tabeli product_ratings pripada tačno jednom zapisu u tabeli products.
    public function productkey() {
        return $this->belongsTo(Product::class, 'product');
    }

    //Koristi kolonu provider u tabeli product_ratings kao strani ključ koji se povezuje sa primarnim ključem u tabeli providers
    //belongsTo znači da svaki zapis u tabeli product_ratings pripada tačno jednom zapisu u tabeli providers
    public function providerkey() {
        return $this->belongsTo(Provider::class, 'provider');
    }

    protected $fillable = [
        'date_and_time',
        'product',
        'provider',
        'user',
        'description',
        'rating'
    ];

}
