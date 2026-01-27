<?php

namespace App\Http\Controllers\API;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Http\Requests\ComplaintRegister;
use App\Models\Branches;
use App\Models\Complaints;
use App\Models\ComplaintImages;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ComplaintsController extends Controller
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

    public function register(ComplaintRegister $request){
        DB::beginTransaction();
        try {
            $userID = User::where('branchID', $request->branchID)->first('id');
            $complaint = Complaints::create([
                'trackingID' => Helpers::genrateTrackingID(),
                'name' => $request->name,
                'cnic' => $request->cnic,
                'mobileNo' => $request->mobileNo,
                'title' => $request->title,
                'branchID' => $request->branchID,
                'complaint' => $request->complaint,
                'location' => $request->location,
                'userID' => $userID->id,
            ]);

            if($request->hasFile('images')){
                foreach($request->file('images') as $file){
                    $fileName = "Complaint-{$complaint->complaintID}-".time()."_".uniqid().".".$file->getClientOriginalExtension();
                    $file->move(storage_path('app/public/complaints'), $fileName);

                    ComplaintImages::create([
                        'complaintID' => $complaint->complaintID,
                        'image' => $fileName
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'trackingID' => $complaint->trackingID,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong: ' . $e->getMessage()
            ]);
        }
    }

    public function trackComplaint($trackingID)
    {
        try {
            $record = Complaints::where('trackingID', $trackingID)->first();
            if ($record) {
                return response()->json([
                    'success' => true,
                    'record' => [
                        'trackingID' => $record->trackingID,
                        'name' => $record->name ?? '',
                        'status' => $record->status ?? '',
                        'mobileNo'=> $record->mobileNo ?? '',
                        'remarks' => $record->remarks ?? 'No Remarks',
                        'created_at' => $record->created_at ? $record->created_at->format('d M Y') : '',
                    ]
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'No Record Found For This Tracking Number'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong: ' . $e->getMessage()
            ]);
        }
    }

    public function trackCnic($cnic)
    {
        try {
            $record = Complaints::where('cnic', $cnic)->first();
            if ($record) {
                return response()->json([
                    'success' => true,
                    'record' => [
                        'trackingID' => $record->trackingID,
                        'name' => $record->name ?? '',
                        'status' => $record->status ?? '',
                        'mobileNo'=> $record->mobileNo ?? '',
                        'remarks' => $record->remarks ?? 'No Remarks',
                        'created_at' => $record->created_at ? $record->created_at->format('d M Y') : '',
                    ]
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'No Record Found For This Cnic Number'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong: ' . $e->getMessage()
            ]);
        }
    }
}
