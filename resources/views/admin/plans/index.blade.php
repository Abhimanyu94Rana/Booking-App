@extends('admin.layouts.master')

@section('content')

<div class="content-wrapper">
    <div class="row">
         
       <div class="col-lg-12 grid-margin stretch-card">
          <div class="card">
             <div class="card-body">
                <h4 class="card-title">Plans List</h4>               
                <div class="table-responsive pt-3">
                   <table class="table table-bordered" id="example">
                      <thead>
                         <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Bookings</th>
                            <th>Created At</th>
                            <th>Action</th>
                         </tr>
                      </thead>
                      <tbody>
                          
                      </tbody>
                   </table>
                </div>
             </div>
          </div>
       </div> 
    </div>
 </div>

@endsection
@push('js')
   <script>
      $(document).ready( function () {
         $.ajaxSetup({
               headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               }
         });
         $('#example').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('plans.index') }}",
            columns: [
               { data: 'DT_RowIndex', name: 'DT_RowIndex' },
               { data: 'name', name: 'name' },
               { data: 'price', name: 'price' },
               { data: 'bookings', name: 'bookings' },
               { data: 'created_at', name: 'created_at' },
               { data: 'action', name: 'action', orderable: false},
            ],
            order: [[0, 'desc']]
         });
      });
   </script>
@endpush