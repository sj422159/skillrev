@extends('supervisor/layout')
@section('title','Competition')
@section('Sector_select','active')
@section('container')
<a href="{{url('groupmanager/competition/addcompetition')}}">
<button type="button" class="btn btn-primary">Create</button>  </a>
<div class="row">
    <div class="col-md-12">
        <div class="card-body table-responsive p-0">
            <table class="table table-borderless table-data3">
                <thead>
                    <br>
                    <tr>
                        <th>Competition Name</th>
                        <th>From</th>
                        <th>To</th>
                        <th>Status</th>
                        <th>Action</th>
                        <th>View Students</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($competition as $list)
                    <tr>
                        <td>{{$list->competitionname}}</td>
                        <td>{{$list->fromdate}}</td>
                        <td>{{$list->todate}}</td>
                        <td>
                            @if($list->status==1)
                               <a href="{{url('groupmanager/competition/status/0')}}/{{$list->id}}"><button type="button" class="btn btn-primary">Active</button>
                               </a>
                            @elseif($list->status==0)
                                <a href="{{url('groupmanager/competition/status/1')}}/{{$list->id}}"><button type="button" class="btn btn-warning">Deactive</button>
                                </a>
                            @endif
                        </td>
                        <td>
                            <a href="{{url('groupmanager/competition/addcompetition')}}/{{$list->id}}"><button type="button" class="btn btn-success">Edit</button>
                            </a>
                            <a href="{{url('groupmanager/competition/delete')}}/{{$list->id}}"><button type="button" class="btn btn-danger">Delete</button>
                            </a>
                        </td>
                        <td>
                            <a href="{{url('groupmanager/competition/view/students')}}/{{$list->id}}"><button type="button" class="btn btn-info">Check</button>
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