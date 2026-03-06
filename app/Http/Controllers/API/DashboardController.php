<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Complaints;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function resolvedComparison(){
        $complaintsStatistics = Complaints::getComplaintStatistics();
        return response()->json([
            'data' => $complaintsStatistics,
        ]);
    }

    public function priorityComplaints(){
        if (Auth::user()->id === 1) {
            $normal = Complaints::where('priority', 'Normal')->count();
            $escalated = Complaints::where('priority', 'Escalated')->count();
            $superEscalated = Complaints::where('priority', 'Super Escalated')->count();
            $totalComplaints = Complaints::count('complaintID');

        }else{
            $normal = Complaints::where('userID', Auth::user()->id)->where('priority', 'Normal')->count();
            $escalated = Complaints::where('userID', Auth::user()->id)->where('priority', 'Escalated')->count();
            $superEscalated = Complaints::where('userID', Auth::user()->id)->where('priority', 'Super Escalated')->count();
            $totalComplaints = Complaints::where('userID', Auth::user()->id)->count();

        }
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
        if (Auth::user()->id === 1) {
            $allComplaints = Complaints::count('complaintID');
            $new = Complaints::where('status', 'New')->count();
            $progress = Complaints::where('status', 'In-Progress')->count();
            $resolved = Complaints::where('status', 'Resolved')->count();
            $dropped = Complaints::where('status', 'Dropped')->count();
        }else{
            $allComplaints = Complaints::where('userID', Auth::user()->id)->count('complaintID');
            $new = Complaints::where('userID', Auth::user()->id)->where('status', 'New')->count();
            $progress = Complaints::where('userID', Auth::user()->id)->where('status', 'In-Progress')->count();
            $resolved = Complaints::where('userID', Auth::user()->id)->where('status', 'Resolved')->count();
            $dropped = Complaints::where('userID', Auth::user()->id)->where('status', 'Dropped')->count();
        }

        return response()->json([
            'allComplaints' => $allComplaints,
            'new' => $new,
            'progress' => $progress,
            'resolved' => $resolved,
            'dropped' => $dropped,
        ]);
    }
}
