@extends('manager/layout')
@section('title','Competition')
@section('Sector_select','active')
@section('container')
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
                            <a href="{{url('manager/competition/view/students')}}/{{$list->id}}"><button type="button" class="btn btn-info">Check</button>
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