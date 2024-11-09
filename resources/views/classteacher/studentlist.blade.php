@extends('classteacher/layout')
@section('title','Student List')
@section('Dashboard_select','active')
@section('container')
<div class="row">
    <div class="col-md-12">
        <div class="card-body table-responsive p-0">
            <table class="table table-borderless table-data3">
                <thead>
                    <br>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Number</th>
                        <th>Profile</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($details as $list)
                    <tr>
                        <td>{{$list->sname}}</td>
                        <td>{{$list->semail}}</td>
                        <td>{{$list->snumber}}</td>
                        <td>
                            <a href="{{url('classteacher/studentdetails/view')}}/{{$list->id}}"><button type="button" class="btn btn-sm btn-success">view</button>
                            </a>
                        </td>
                        <td>
                            @if($list->status==1)
                                <button type="button" class="btn btn-sm btn-primary">Active</button>       
                            @elseif($list->status==0)
                                <button type="button" class="btn btn-sm btn-warning">Deactive</button>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection