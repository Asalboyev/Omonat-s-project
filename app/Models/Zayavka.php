<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zayavka extends Model
{
    use HasFactory;

    protected $fillable = ['first_name','product_id', 'email','phone_number', 'descriptions','created_at', 'updated_at'];


    public function product()
    {
        return $this->belongsTo(Product::class);
    }



}
