@extends('admin/layout')
@section('title','Manager')
@section('manager_select','active')
@section('container')
<a href="{{url('admin/manager/addmanager')}}">
<button type="button" class="btn btn-primary">Create</button>  </a>
<div class="row">
    <div class="col-md-12">
        <div class="card-body table-responsive p-0">
            <table class="table table-borderless table-data3">
                <thead>
                    <br>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($manager as $list)
                    <tr>
                        <td>{{$list->mname}}</td>
                        <td>{{$list->memail}}</td>
                        <td>{{$list->mnumber}}</td>
                        <td>
                        @if($list->status==1)
                          <a href="{{url('admin/manager/status/0')}}/{{$list->id}}"><button type="button" class="btn btn-primary">Active</button></a>
                        @elseif($list->status==0)
                           <a href="{{url('admin/manager/status/1')}}/{{$list->id}}"><button type="button" class="btn btn-warning">Deactive</button></a>
                        @endif
                        </td>
                        <td>
                            <a href="{{url('admin/manager/addmanager')}}/{{$list->id}}"><button type="button" class="btn btn-success">Edit</button>
                            </a>
                            <a href="{{url('admin/manager/delete')}}/{{$list->id}}"><button type="button" class="btn btn-danger">Delete</button>
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