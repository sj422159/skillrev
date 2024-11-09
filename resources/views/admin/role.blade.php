@extends('admin/layout')
@section('title','Role')
@section('Dashboard_select','active')
@section('container')
<a href="{{url('admin/role/addrole')}}">
<button type="button" class="btn btn-primary">Create</button>  </a>
<div class="row">
    <div class="col-md-12">
        <div class="card-body table-responsive p-0">
            <table class="table table-borderless table-data3">
                <thead>
                    <br>
                    <tr>
                        <th>Role</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($role as $list)
                    <tr>
                        <td>{{$list->role}}</td>
                        <td>
                            <a href="{{url('admin/role/addrole')}}/{{$list->id}}"><button type="button" class="btn btn-success">Edit</button>
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