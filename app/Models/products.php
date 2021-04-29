<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class products extends Model
{
    use HasFactory;

    protected $fillable = ['name_product', 'image', 'description', 'price', 'categories_id'];

    protected $hidden = [
        'updated_at',
        'created_at',
    ];
}
