<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Complaints extends Model
{
    use HasFactory;
    protected $table = 'complaints';
    protected $primaryKey = 'complaintID';
    protected $guarded = [];

    public function images()
    {
        return $this->hasMany(ComplaintImages::class, 'complaintID', 'complaintID');
    }

    public function branch(){
        return $this->belongsTo(Branches::class, 'branchID', 'branchID');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function remarksHistories(){
        return $this->hasMany(RemarksHistory::class, 'complaintID', 'complaintID');
    }

    protected function getComplaintStatistics(){
        $year = 2026;
        $months = [
            1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
            5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
            9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
        ];

        $totalCases = [];
        $resolvedCases = [];

        foreach ($months as $num => $name) {
            $totalCases[] = "SUM(CASE WHEN MONTH(created_at) = {$num} THEN 1 ELSE 0 END) AS `{$name}_total`";
            $resolvedCases[] = "SUM(CASE WHEN MONTH(created_at) = {$num} AND status = 'Resolved' THEN 1 ELSE 0 END) AS `{$name}_resolved`";
        }

        $query = "SELECT " . implode(", ", $totalCases) . ", " . implode(", ", $resolvedCases) . "
          FROM complaints
          WHERE YEAR(created_at) = {$year}";

        $result = DB::select($query);

        return $result;
    }

    protected function getComplaintStatusStatistics(){
        $year = 2026;

        $months = [
            1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
            5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
            9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
        ];

        $statuses = ['New', 'In-Progress', 'Resolved', 'Dropped'];

        $caseStatements = [];

        foreach ($months as $num => $name) {
            foreach ($statuses as $status) {
                // For example: SUM(CASE WHEN MONTH(created_at) = 1 AND status='New' THEN 1 ELSE 0 END) AS January_New
                $caseStatements[] = "SUM(CASE WHEN MONTH(created_at) = {$num} AND status = '{$status}' THEN 1 ELSE 0 END) AS `{$name}_{$status}`";
            }
        }

        // Build query
        $query = "SELECT " . implode(", ", $caseStatements) . "
          FROM complaints
          WHERE YEAR(created_at) = {$year}";

        // Execute
        $result = DB::select($query);

        return $result;

    }
}
