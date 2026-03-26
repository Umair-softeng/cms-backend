<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'branchID',
        'system_reserve'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function branch(){
        return $this->belongsTo(Branches::class, 'branchID', 'branchID');
    }

    public function complaints(){
        return $this->hasMany(Complaints::class);
    }

    public function complaintImages(){
        return $this->hasMany(ComplaintImages::class, 'createdByUserID','id');
    }

    public function remarksHistory(){
        return $this->hasMany(RemarksHistory::class, 'createdByUserID','id');
    }
}
