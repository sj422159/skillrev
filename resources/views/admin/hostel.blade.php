@extends('admin/layout')
@section('title','Hostel')
@section('Dashboard_select','active')
@section('container')
<a href="{{url('admin/hostel/add')}}">
<button type="button" class="btn btn-primary">Create</button>  </a>
<div class="row">
    <div class="col-md-12">
        <div class="card-body table-responsive p-0">
            <table class="table table-borderless table-data3">
                <thead>
                    <br>
                    <tr>
                        <th>Hostel</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($hostel as $list)
                    <tr>
                        <td>{{$list->hostel}}</td>
                        <td>
                            <a href="{{url('admin/hostel/add')}}/{{$list->id}}"><button type="button" class="btn btn-success">Edit</button>
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