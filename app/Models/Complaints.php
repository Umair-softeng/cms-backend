<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaints extends Model
{
    use HasFactory;
    protected $table = 'complaints';
    protected $primaryKey = 'complaintID';
    protected $guarded = [];

    public function images()
    {
        return $this->hasMany(ComplaintImages::class);
    }

    public function branch(){
        return $this->belongsTo(Branches::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
