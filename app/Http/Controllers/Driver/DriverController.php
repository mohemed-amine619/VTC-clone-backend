<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Models\DriverStatus;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    //
    public function ChangeDriverStatus(Request $request){
        $userId = $request->userId;
        $status = $request->status;
        
        $isValidStatus = DriverStatus::CheckDriverStatus($status);
        $DriverStatus = DriverStatus::where('user_id' , $userId)->first();
        if(!$isValidStatus){
            return response([
                "errors" => [
                    'message' => 'invalid status'
                    ]
            ] , 422);
        }
        if(!is_null($DriverStatus)){
            if($DriverStatus->status == DriverStatus::Busy){
                DriverStatus::where('user_id' , $userId)->update([
                    'status' => DriverStatus::AvailableStatus,
                ]);
                return response(['message' => 'status changed successfully '], 200);
            }else{
                DriverStatus::where('user_id' , $userId)->update([
                    'status' => DriverStatus::Busy,
                ]);
                return response(['message' => 'status changed successfully '], 200);
            }
        }else{
            DriverStatus::create([
                'user_id' => $userId,
                'status' => $status
            ]);
            return response(['message' => 'status changed successfully '] , 200);
        }
    }
}
