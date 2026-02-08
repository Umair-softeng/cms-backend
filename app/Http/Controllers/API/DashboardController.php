<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Complaints;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function resolvedComparison(){
        $complaintsStatistics = Complaints::getComplaintStatistics();
        return response()->json([
            'data' => $complaintsStatistics,
        ]);
    }

    public function priorityComplaints(){
        $normal = Complaints::where('priority', 'Normal')->count();
        $escalated = Complaints::where('priority', 'Escalated')->count();
        $superEscalated = Complaints::where('priority', 'Super Escalated')->count();
        $totalComplaints = Complaints::count('complaintID');
        return response()->json([
            'normal' => $normal,
            'escalated' => $escalated,
            'superEscalated' => $superEscalated,
            'totalComplaints' => $totalComplaints,
        ]);
    }

    public function statusComplaints(){
        $complaintsStatusStatistics = Complaints::getComplaintStatusStatistics();
        return response()->json([
            'data' => $complaintsStatusStatistics,
        ]);
    }

    public function allStatusComplaints(){
        $allComplaints = Complaints::count('complaintID');
        $new = Complaints::where('status', 'New')->count();
        $progress = Complaints::where('status', 'In-Progress')->count();
        $resolved = Complaints::where('status', 'Resolved')->count();
        $dropped = Complaints::where('status', 'Dropped')->count();
        return response()->json([
            'allComplaints' => $allComplaints,
            'new' => $new,
            'progress' => $progress,
            'resolved' => $resolved,
            'dropped' => $dropped,
        ]);
    }
}
