<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicule extends Model
{
    //
    protected $table = 'vehicules';
    protected $fillable = ['name' , 'model' , 'price' , 'images'];


    
    
}
