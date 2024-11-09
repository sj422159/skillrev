@extends('nontechmanager/hostel/layout')
@section('title','Room Details')
@section('Dashboard_select','active')
@section('container')

<div class="row">
    <div class="col-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title" style="color:#fff !important;">Create Room</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{url('nontech/manager/hostel/rooms/saverooms')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-row mt-2">
                     <div class="col-12 col-sm-6 mt-4 mt-sm-0" id="a">
                        <label for="role">Hostel :</label>
                        <select id="group" type="text" class="form-control" name="hid" required>
                            <option value="">Select Hostel</option>
                            @foreach($hostels as $list)
                            @if($hid==$list->id)
                            <option selected value="{{$list->id}}">{{$list->hostel}}</option>
                            @else
                            <option  value="{{$list->id}}">{{$list->hostel}}</option>
                            @endif
                            @endforeach
                       </select>
                    </div>
                   
                    <div class="col-12 col-sm-6 mt-2 mt-sm-0">
                        <label for="jobgroup">Room Name</label>
                        <input type="text" class="form-control" id="jobgroup" required="true" placeholder="Enter Room Name" name="room" value="{{$room}}">
                    </div>
                     <div class="col-12 col-sm-6 mt-2 mt-sm-0">
                        <label for="jobgroup">Bed Capacity</label>
                        <input type="number" class="form-control" id="jobgroup" required="true" placeholder="Enter Room Name" name="bedcapacity" value="{{$bedcapacity}}">
                    </div>
                    <input type="hidden" name="id" value="{{$id}}">
                </div>
                <div class="card-footer mt-4">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
        </div>
        </form>
    </div>
</div>
</div>
@endsection