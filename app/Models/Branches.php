<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branches extends Model
{
    use HasFactory;
    protected $table = 'branches';
    protected $fillable = ['name_en', 'name_ur'];
    protected $primaryKey = 'branchID';

    public function users()
    {
        return $this->hasMany(User::class, 'branchID', 'branchID');
    }

    public function complaints(){
        return $this->hasMany(Complaints::class, 'branchID', 'branchID');
    }
}
