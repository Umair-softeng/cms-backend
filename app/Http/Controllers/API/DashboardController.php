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
}
