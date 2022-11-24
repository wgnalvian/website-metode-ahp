<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlternativeData extends Model
{
    use HasFactory;
    protected $table = 'alternative_data';
    protected $guarded = [];

    public function mahasiswa(){
        return $this->belongsTo(Mahasiswa::class,'mahasiswa_id','id');
    }

    public function subcategory(){
        return $this->belongsTo(SubCategory::class,'subcategory_id','id');
    }
}
