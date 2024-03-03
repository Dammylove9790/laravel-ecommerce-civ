<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'added_by',
        'role',
        'name',
        'categoryID',
        'slug',
        'picture_id',
        'price',
        'quantity',
        'measurement',
        'description',
        'address',
        'city',
        'state',
        'status',
        'updated_by'
    ];

    public function picture()
    {
        return $this->belongsTo(Picture::class);
    }
}