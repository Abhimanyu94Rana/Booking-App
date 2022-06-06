@extends('admin.layouts.master')
@section('content')
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Booking Information</h4>
        <div class="table-responsive">
          <table class="table">
                <tr>
                    <td>Name:</td>
                    <td>{{$booking->user->name ?? ""}}</td>
                </tr>
                <tr>
                    <td>Email:</td>
                    <td>{{$booking->email ?? ""}}</td>
                </tr>
                <tr>
                    <td>Date:</td>
                    <td>{{$booking->date ?? ""}}</td>
                </tr>
                <tr>
                    <td>Time:</td>
                    <td>{{\Carbon\Carbon::createFromFormat('H:i:s',$booking->time)->format('h:i A')}}
                    </td>
                </tr>
                <tr>
                    <td>Address:</td>
                    <td>{{$booking->address ?? ""}}</td>
                </tr>
                <tr>
                    <td>Description:</td>
                    <td>{{$booking->description ?? ""}}</td>
                </tr>
                <tr>
                    <td>Mobile Number:</td>
                    <td>{{$booking->mobile_no ?? ""}}</td>
                </tr>
                <tr>
                    <td>Created At:</td>
                    <td>{{$booking->created_at->diffForHumans() ?? ""}}</td>
                </tr>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection