<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BusinessType extends Model
{
   	use HasFactory , SoftDeletes; 

   	protected $table = 'business_types';

    protected $fillable = ['name'];
}
