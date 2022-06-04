<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking; 
use Yajra\DataTables\DataTables;

class IndexController extends Controller
{
    public function dashboard(Request $request){
        
        if(request()->ajax()) {

            $data = Booking::select('id','email','user_id','start_date','end_date','time')->get();
            return Datatables::of($data)

                ->addIndexColumn()
                ->addColumn('name', function($row){                      
                    return $row->user->name;
                })
                ->addColumn('email', function($row){                      
                    return $row->email;
                })
                ->addColumn('start_date', function($row){                      
                    return $row->start_date;
                })
                ->addColumn('end_date', function($row){                      
                    return $row->end_date;
                })
                ->addColumn('time', function($row){  
                    return \Carbon\Carbon::createFromFormat('H:i:s',$row->time)->format('h:i A');
                })
                ->addColumn('action', function($row){  
                    $btn = '<a href="'.route('booking',$row->id).'" class="btn btn-info btn-fill pull-right">View</a>&nbsp;';
                    return $btn;
                })
                ->rawColumns(['action']) 
                ->make(true);

        }
        return view('admin.dashboard');
    }

    // Display booking info
    public function booking($id){
        $booking = Booking::find($id);
        if($booking){
            return view('admin.booking_info',compact('booking',$booking));
        }
    }
}
