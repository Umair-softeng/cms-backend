<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Branches;
use App\Models\Complaints;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function getBranchesDetails()
    {
        $branches = Branches::all();
        if ($branches) {
            return response()->json([
                'branches' => $branches,
                'status' => 200,
                'message' => "success"
            ]);
        }else {
            return response()->json([
                'message' => 'failed',
                'status' => 404,
            ]);
        }
    }

    function getDateRange($type, $start = null, $end = null)
    {
        switch ($type) {
            case 'Daily':
                $startDate = Carbon::today()->startOfDay();
                $endDate = Carbon::today()->endOfDay();

                break;

            case 'Weekly':
                $startDate = Carbon::now()->startOfWeek();
                $endDate = Carbon::now()->endOfWeek();
                break;

            case 'Monthly':
                $startDate = Carbon::now()->startOfMonth();
                $endDate = Carbon::now()->endOfMonth();
                break;

            case 'Yearly':
                $startDate = Carbon::now()->startOfYear();
                $endDate = Carbon::now()->endOfYear();
                break;

            case 'Custom':
                $startDate = $start ? Carbon::parse($start)->startOfDay() : null;
                $endDate = $end ? Carbon::parse($end)->endOfDay() : null;
                break;

            default:
                $startDate = null;
                $endDate = null;
        }

        return [$startDate, $endDate];
    }

    public function reports(Request $request, $reportType)
    {
        $type = $reportType;
        $start = $request->startDate ?? null;
        $end = $request->endDate ?? null;

        [$startDate, $endDate] = $this->getDateRange($type, $start, $end);

        // If dates are null, return empty response or handle appropriately
        if (!$startDate || !$endDate) {
            return response()->json([
                'message' => 'No Complaint Details Found',
            ]);
        }
        $complaints = Complaints::whereBetween('created_at', [$startDate, $endDate])->get();
        $allComplaints = Complaints::whereBetween('created_at', [$startDate, $endDate])->count();
        $statusCounts = $complaints->groupBy('status')->map->count();
        $priorityCounts = $complaints->groupBy('priority')->map->count();
        return response()->json([
            'status' => $statusCounts,
            'priority' => $priorityCounts,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'total' => $allComplaints,
        ]);
    }

}
