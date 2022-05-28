<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Plans; 
use Yajra\DataTables\DataTables;

class PlansController extends Controller
{
    public function index(Request $request){
        
        if(request()->ajax()) {

            $data = Plans::get();
            return Datatables::of($data)

                ->addIndexColumn()
                ->addColumn('name', function($row){                      
                    return $row->name;
                })
                ->addColumn('price', function($row){                      
                    return $row->price;
                })
                ->addColumn('bookings', function($row){                      
                    return $row->bookings;
                })
                ->addColumn('created_at', function($row){                      
                    return $row->created_at;
                })
                // ->addColumn('time', function($row){  
                //     return \Carbon\Carbon::createFromFormat('H:i:s',$row->time)->format('h:i A');
                // })
                ->addColumn('action', function($row){                     
                    $btn = '<a href="'.route('booking',$row->id).'" class="btn btn-info btn-fill pull-right">View</a>&nbsp;';
                    return $btn;
                })
                ->rawColumns(['action']) 
                ->make(true);

        }
        return view('admin.plans.index');
    }

    // Edit plan
    public function edit($id){
        $plan = Plans::find($id);
        if($plan){
            return view('admin.plans.edit',compact('plan',$plan));
        }
    }
}
