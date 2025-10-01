<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DriverStatus extends Model
{
    //

    protected $guarded = [];

    const AvailableStatus = 1;
    const Busy = 0;

    public static function CheckDriverStatus($status)
    {
        if($status === null){
            return false;
        }
        if(intval($status) === self::AvailableStatus || intval($status) === self::Busy){
            return true;
        }else{
            return false;
        }
    }
    public function User()
    {
        return $this->hasOne(User::class);
    }
}
