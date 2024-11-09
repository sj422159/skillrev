@extends('admin/layout')
@section('title','Rooms')
@section('Dashboard_select','active')
@section('container')

@if(session()->has('danger'))
        <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
            <span class="badge badge-pill badge-danger"></span>
            {{session('danger')}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
            </button>
        </div>
@endif

<a href="{{url('admin/rooms/addrooms')}}">
<button type="button" class="btn btn-primary">Create</button>  </a>

<div class="row">
    <div class="col-md-12">
        <div class="card-body table-responsive p-0">
            <table class="table table-borderless table-data3">
                <thead>
                    <br>
                    <tr>
                        <th>Room</th>
                        <th>Allocation</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($room as $list)
                    <tr>
                        <td>{{$list->roomname}}</td>
                        <td>
                            @if($list->allocation==1)
                            YES
                            @else
                            NO
                            @endif
                        </td>
                        <td>
                            <a href="{{url('admin/rooms/addrooms')}}/{{$list->id}}"><button type="button" class="btn btn-success">Edit</button>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection