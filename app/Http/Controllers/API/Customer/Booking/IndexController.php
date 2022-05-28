<?php

namespace App\Http\Controllers\API\Customer\Booking;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Booking;
use App\Http\Resources\BookingCollection;
use App\Http\Requests\BookingStoreRequest;

class IndexController extends Controller
{
    public function list(){
        $bookings = Booking::latest()->get();
        if($bookings->count() > 0){
            return new BookingCollection($bookings);
            // return response()->json(['status'=>true,'count'=>$bookings->count(),'data' => new BookingCollection($bookings)],200);
        }
        return response()->json(['status'=>false,'message'=>'No bookings are found.'],404);
        
    }

    public function store(BookingStoreRequest $request){ 
       
        try {
            // Create booking
            $booking = Booking::create([  
                'user_id' => auth()->user()->id,
                'email' => $request->email,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'time' => $request->time,
                'address' => $request->address,
                'description' => $request->description,
                'mobile_no' => $request->mobile_no
            ]);

            return response()->json(['status'=>true,'message' => 'Booking has been created successfully.'],200);

        } catch (\Exception $exception) {
            return response()->json(['status'=>false,'message' => $exception->getMessage()],500);            
        }
        
    }
}
