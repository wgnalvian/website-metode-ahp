<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryComparM extends Model
{
    protected $table = 'categories_compar';
    protected $guarded = [];


    public function categoryA(){
        return $this->belongsTo(Category::class,'category_id_A','id');
    }
     public function categoryB(){
        return $this->belongsTo(Category::class,'category_id_B','id');
    }
}
