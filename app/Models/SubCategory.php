<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
  
    protected $table = 'sub_categories';
    protected $guarded = [];

    public function category(){
        return $this->belongsTo(Category::class,'category_id','id');
    }

    public function subcategoryMA(){
        return $this->hasMany(SubCategoryComparM::class,'subcategory_id_a','id');
    } 

    public function alternativeData(){
        return $this->hasMany(AlternativeData::class,'subcategory_id','id');
    }
}
