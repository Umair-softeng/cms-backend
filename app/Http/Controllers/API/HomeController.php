<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Branches;

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
}
