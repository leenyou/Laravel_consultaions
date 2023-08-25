<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class consultations extends Model
{
    use HasFactory;
    protected $table='consultations';
  //  protected $with='experts';
    protected $fillable = ['name'];


    public function experts() {
        return $this->belongsToMany(Expert::class,'expert_consul');
    }



}
