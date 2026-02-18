<?php

namespace App\Http\Controllers\API;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Http\Requests\ComplaintRegister;
use App\Models\Branches;
use App\Models\Complaints;
use App\Models\ComplaintImages;
use App\Models\Feedback;
use App\Models\RemarksHistory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ComplaintsController extends Controller
{
    //Branches Details
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

    //Complaint Registration
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

    //Complaint Tracking By Tracking ID
    public function trackComplaint($trackingID)
    {
        try {
            $record = Complaints::where('trackingID', $trackingID)->first();
            if ($record) {
                return response()->json([
                    'success' => true,
                    'record' => $record->load('remarksHistories')
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

    //Complaint Tracking By cnic
    public function trackCnic($cnic)
    {
        try {
            $record = Complaints::where('cnic', $cnic)->first();
            if ($record) {
                return response()->json([
                    'success' => true,
                    'record' => $record->load('remarksHistories')
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

    //Getting Complaint Figures
    public function figures(){
        $allComplaints = Complaints::count();
        $newComplaints = Complaints::where('status', "New")->count();
        $progressComplaints = Complaints::where('status', "In-Progress")->count();
        $resolvedComplaints = Complaints::where('status', "Resolved")->count();
        $droppedComplaints = Complaints::where('status', "Dropped")->count();

        return response()->json([
            'allComplaints' => $allComplaints,
            'newComplaints' => $newComplaints,
            'progressComplaints' => $progressComplaints,
            'resolvedComplaints' => $resolvedComplaints,
            'droppedComplaints' => $droppedComplaints,

        ]);
    }

    //Getting All Complaints
    public function getComplaints(){
        $complaints = Complaints::all();
        if ($complaints) {
            return response()->json([
                'complaints' => $complaints->load(['branch', 'images', 'remarksHistories']),
                'status' => 200,
                'success' => true,
            ]);
        }else{
            return response()->json([
                'status' => 404,

            ]);
        }
    }

    //Updating Status & Remarks
    public function updateStatus(Request $request)
    {
        $complaint = Complaints::where('complaintID', $request->complaintID)->firstOrFail();

        $oldRemarks = $complaint->remarks; // save old remarks

        $complaint->update([
            'status' => $request->status,
            'remarks' => $request->remarks,
        ]);

        if(!empty($request->remarks) && $request->remarks !== $oldRemarks) {
            RemarksHistory::create([
                'complaintID' => $complaint->complaintID,
                'remarks' => $request->remarks,
                'created_at' => now(),
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully!',
            'complaint' => $complaint->load(['branch', 'images'])
        ]);
    }


    //Updating Branch & Remarks
    public function updateBranch(Request $request){
        $complaint = Complaints::where('complaintID', $request->complaintID)->firstOrFail();

        $oldRemarks = $complaint->remarks; // save old remarks

        $complaint->update([
            'branchID' => $request->branchID,
            'remarks' => $request->remarks,
        ]);

        if(!empty($request->remarks) && $request->remarks !== $oldRemarks) {
            RemarksHistory::create([
                'complaintID' => $complaint->complaintID,
                'remarks' => $request->remarks,
                'created_at' => now(),
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully!',
            'complaint' => $complaint->load(['branch', 'images'])
        ]);
    }

    //Delete Complaint
    public function destroy($complaintID)
    {
        if (Auth::user()->status !== 'Active') {
            return response()->json([
                'ok' => false,
                'message' => 'Inactive user cannot delete complaint'
            ], 403);
        }

        // Find the complaint manually
        $complaint = Complaints::where('complaintID', $complaintID)->firstOrFail();

        $complaint->delete();

        return response()->json([
            'ok' => true,
            'message' => 'Complaint deleted successfully'
        ], 200);
    }

    //Complaint Feedback
    public function feedback(Request $request){
        DB::beginTransaction();
        try {
            Feedback::create([
               'name' => (string) $request['name'],
               'location' => (string) $request['location'],
               'rating' => (int) $request['rating'],
               'feedback' => (string) $request['feedback'],
            ]);
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Feedback added successfully'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong: ' . $e->getMessage()
            ]);
        }
    }

    //Complaint Feedback Data
    public function feedbackData(){
        $feedbacks = Feedback::all();
        if ($feedbacks) {
            return response()->json($feedbacks);
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'No Record Found'
            ]);
        }
    }
}
