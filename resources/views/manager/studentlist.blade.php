@extends('manager/layout')
@section('title','Student List')
@section('Dashboard_select','active')
@section('container')
<div class="row">
    <div class="col-12" style="margin:10px;background-color: #fff;padding:5px;margin-top:0px;padding-top: 10px;">
  
<form action="{{url('manager/studentdetails/bysection')}}" method="post">
    @csrf
    <div class="form-row">
          <div class="col-12 col-sm-3 mt-2 mt-sm-0" style="display: flex;justify-content: center;flex-direction: column;align-items: center;">
            <label>CLASS</label>
            <select  class="form-control disabled" required  name="class" id="clas" required readonly>
                @foreach($classes as $list)
                <option selected value="{{$list->id}}">{{$list->categories}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-12 col-sm-3 mt-2 mt-sm-0" style="display: flex;justify-content: center;flex-direction: column;align-items: center;" >
            <label>SECTION</label>
            <select  class="form-control" required  name="section" id="section" required > 
                <option value="">Select</option>
              @foreach($sections as $list)
                @if($section==$list->id)
                <option selected value="{{$list->id}}">{{$list->section}}</option>
                @else
                <option value="{{$list->id}}">{{$list->section}}</option>
                @endif
              @endforeach
            </select>
        </div>
         
        <div class="col-12 col-sm-3 mt-2 mt-sm-0" style="display: flex;justify-content: center;flex-direction: column;align-items: center;" >
             <label>Action</label>
            <button type="submit" class="btn btn-success form-control">Fetch</button>
          </div>
        <div class="col-12 col-sm-3 mt-2 mt-sm-0" style="display: flex;justify-content: center;flex-direction: column;align-items: center;" >
            <label>Download</label>
            @if(count($details)>0)
                <a href="{{url('manager/studentdetails/export')}}/{{$section}}"><button type="button" class="btn btn-primary">Export</button>
                </a>
            @else
                <button type="button" class="btn btn-primary disabled">Export</button>
            @endif
        </div>
        </div>
</form>          
</div>
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
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($details as $list)
                    <tr>
                        <td>{{$list->sname}}</td>
                        <td>{{$list->semail}}</td>
                        <td>{{$list->snumber}}</td>
                        <td>
                            <a href="{{url('manager/studentdetails/view')}}/{{$list->id}}"><button type="button" class="btn btn-sm btn-success">view</button>
                            </a>
                        </td>
                        <td>
                            @if($list->status==1)
                                  <a href="{{url('manager/student/status/0')}}/{{$list->id}}"><button type="button" class="btn btn-sm btn-primary">Active</button>
                                  </a> 
                               @elseif($list->status==0)
                                 <a href="{{url('manager/student/status/1')}}/{{$list->id}}"><button type="button" class="btn btn-sm btn-warning">Deactive</button>
                                  </a>
                               @endif
                        </td>
                        <td> 
                            <a href="{{url('manager/student/delete')}}/{{$list->id}}"><button type="button" class="btn btn-sm btn-danger">Delete</button>
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