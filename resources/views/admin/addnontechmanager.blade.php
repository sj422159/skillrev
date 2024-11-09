@extends('admin/layout')
@section('title','Add Manager')
@section('manager_select','active')
@section('container')
<div class="row">
    <div class="col-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title" style="color:#fff !important;">Create Manager</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{url('admin/nontech/manager/savemanager')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
            <div class="form-row">
                <div class="col-12 col-sm-6 mt-4 mt-sm-0" id="class">
                <label for="GenderId" class="form-control-label">Group Manager Name</label>
                <select class="multisteps-form__select form-control" name="supid" id="mainbranch" required="true">
                <option value="">Select</option>
                @foreach($nontechsupervisors as $list)
                @if($supid==$list->id)
                <option selected value="{{$list->id}}">{{$list->supname}}</option>
                @else
                <option  value="{{$list->id}}">{{$list->supname}}</option>
                
                @endif
                @endforeach
                </select>
                </div>
                <div class="col-12 col-sm-6 mt-4 mt-sm-0" id="class">
                <label for="GenderId" class="form-control-label">Department</label>
                <select name="departmentid" class="form-control" required="true" data-val="{{$departmentid}}" id="subbranch">
                    <option value="">Select</option>
                @foreach($departments as $list)
                @if($departmentid==$list->id)
                <option selected value="{{$list->id}}">{{$list->department}}</option>
                @else
                <option  value="{{$list->id}}">{{$list->department}}</option>
                
                @endif
                @endforeach
                </select>
                </select>
                </div>
            </div>
            <div class="form-row mt-4">
                  <div class="col-12 col-sm-4 mt-4 mt-sm-0">
                    <label for="jobrole">Name</label>
                    <input type="text" class="form-control" id="jobrole" required="true" placeholder="Enter Name" name="name" value="{{$name}}">
                  </div>
                  <div class="col-12 col-sm-4 mt-4 mt-sm-0">
                    <label for="jobrole">Email</label>
                    <input type="email" class="form-control" id="jobrole" required="true" placeholder="Enter Email" name="email" value="{{$email}}">
                  </div>

                   <div class="col-12 col-sm-4 mt-4 mt-sm-0">
                    <label for="jobrole">Number</label>
                    <input type="text" class="form-control" id="jobrole" required="true" placeholder="Enter Number" name="number" value="{{$number}}">
                  </div>

                  

                  </div>
                    <input type="hidden" name="id" value="{{$id}}">
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
        </div>
        </form>
    </div>
</div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script type="text/javascript">
      
</script>
@endsection