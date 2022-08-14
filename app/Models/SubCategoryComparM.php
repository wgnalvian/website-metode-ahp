<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategoryComparM extends Model
{
    use HasFactory;
    protected   $table = 'sub_categories_compar';
    protected $guarded = [];
    
    public function subcategoryA(){
        return $this->belongsTo(SubCategory::class,'subcategory_id_a','id');
    }
     public function subcategoryB(){
        return $this->belongsTo(SubCategory::class,'subcategory_id_b','id');
    }
    
}
