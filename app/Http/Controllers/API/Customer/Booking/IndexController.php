<?php

namespace App\Http\Controllers\API\Customer\Booking;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Booking;
use App\Http\Resources\BookingCollection;
use App\Http\Requests\BookingStoreRequest;
use Auth;
use App\Models\User;
class IndexController extends Controller
{
    public function list(){

        $user_id = auth::user()->id;
        $bookings = Booking::where('user_id',$user_id)->latest()->get();
        // dd($bookings);
        if($bookings){
            return new BookingCollection($bookings);
            // return response()->json(['status'=>true,'count'=>$bookings->count(),'data' => new BookingCollection($bookings)],200);
        }
        return response()->json(['status'=>false,'message'=>'No bookings are found.'],404);
        
    }

    public function store(BookingStoreRequest $request){ 
       
        try {

            $booking_quota = auth()->user()->booking_quota;            
            if($booking_quota > 0){
                // Create booking
                $booking = Booking::create([  
                    'user_id' => auth()->user()->id,
                    'email' => $request->email,
                    'date' => $request->date,
                    'time' => $request->time,
                    'address' => $request->address,
                    'description' => $request->description,
                    'mobile_no' => $request->mobile_no
                ]);
                if( intval($booking->id) > 0 ){
                    // Update booking quota
                    $user_id = auth()->user()->id;
                    $user = User::find($user_id);
                    if($user){
                        $user->booking_quota = auth()->user()->booking_quota - 1;
                        $user->save();
                    }
                    return response()->json(['status'=>true,'message' => 'Booking has been created successfully.'],200);
                }
                return response()->json(['status'=>false,'message' => 'Some error occurred.'],500);            
            }
            return response()->json(['status'=>false,'message' => 'Booking quota limit has exceeded.'],500);

        } catch (\Exception $exception) {
            return response()->json(['status'=>false,'message' => $exception->getMessage()],500);            
        }
        
    }
}
