<?php

namespace App\Models;

use App\Models\consultations;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Laravel\Sanctum\HasApiTokens as SanctumHasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Expert extends Authenticatable
{
    use HasApiTokens
    , HasFactory, Notifiable;
   // protected $with='consultations';
    protected $table='experts';
    protected $fillable = [
        'expert_name',
        'email',
        'password',
        'profile_img_url',
        'phone_num','Adress','wallet','details',
        'consulPrice',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];


    public function consults() {
        return $this->belongsToMany(consultations::class,'expert_consul');
    }

    public function availableTimes() {
        return $this->hasMany(Availble_Time::class,'expert_id');
    }

    public function bookings() {
        return $this->hasMany(bookings::class, 'user_id');
    }

    public function booking() {
        return $this->hasMany(bookings::class, 'expert_id');
    }

}
