<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class expert_consul extends Model
{
    use HasFactory;

    protected $fillable = [
        'expert_id',
        'consultation_id',

    ];


   //  * Get the expert that owns the expert_consul

    public function expert()
    {
        return $this->belongsToMany(expert::class);
    }



    public function consultations()
    {
        return $this->belongsToMany(consultations::class);
    }
}
