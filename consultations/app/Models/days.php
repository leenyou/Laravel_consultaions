<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class days extends Model
{
    use HasFactory;
    protected $table='days';
    protected $fillable = ['name'];

    public function experts() {
        return $this->belongsToMany(Expert::class,'availble_times');
    }



    
}
