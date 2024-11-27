<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    protected $table = 'providers';
    public $primaryKey = 'id';

    
    //Ova relacija povezuje model Provider sa više zapisa u modelu ProductRating.
    //hasMany znači da svaki zapis u tabeli providers može imati više povezanih zapisa u tabeli product_ratings

    public function productrating() {
        return $this->hasMany(ProductRating::class);
    }

    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'years_of_experience'
    ];
}
