<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Availble_Time extends Model
{
    use HasFactory;
    protected $table='availble_times';
    protected $fillable = [
    'expert_id',
    'From',
    'To',
];


public function expert()
{
    return $this->belongsTo(expert::class,'expert_id');
}





}
