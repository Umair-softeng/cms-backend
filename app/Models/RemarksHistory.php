<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RemarksHistory extends Model
{
    use HasFactory;
    protected $table = 'remarksHistory';
    protected $primaryKey = 'remarksHistoryID';
    protected $guarded = [];

    public function complaint()
    {
        return $this->belongsTo(Complaints::class, 'complaintID', 'complaintID');
    }
}
