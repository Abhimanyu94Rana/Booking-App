@extends('admin.layouts.master')

@section('content')

<div class="content-wrapper">
    <div class="row">
         
       <div class="col-lg-12 grid-margin stretch-card">
          <div class="card">
             <div class="card-body">
                <h4 class="card-title">Booking Data</h4>               
                <div class="table-responsive pt-3">
                   <table class="table table-bordered" id="example">
                      <thead>
                         <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Date</th>
                            <th>Time</th>
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
            ajax: "{{ route('dashboard') }}",
            columns: [
               { data: 'DT_RowIndex', name: 'DT_RowIndex' },
               { data: 'name', name: 'name' },
               { data: 'email', name: 'email' },
               { data: 'date', name: 'date' },
               { data: 'time', name: 'time' },
               { data: 'action', name: 'action', orderable: false},
            ],
            order: [[0, 'desc']]
         });
      });
   </script>
@endpush