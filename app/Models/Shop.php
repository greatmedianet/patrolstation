<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'shops';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email','phone', 'photo','address', 'short_name', 'confirmed_nozzle',
    ];

    public function FuelTypes()

    {
        return $this->hasMany('App\Models\FuelType');
    }

     public function Tanks()

    {
        return $this->hasMany('App\Models\Tank');
    }

    public function Users()
    {
        return $this->hasMany('App\Models\User');
    }
}
