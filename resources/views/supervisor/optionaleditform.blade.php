@extends('supervisor/layout')
@section('title','Subject Utilization')
@section('d','active')
@section('container')

<style type="text/css">
    h6{
        text-align: center !important;
    }
</style>
<div class="row">
    <div class="col-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title" style="color:#fff !important;">GROUP MANAGER SCHEDULE CLASS</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{url('groupmanager/optional/schedule/day/update')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                <div class="form-row">
                     <div class="col-12 col-sm-4 mt-4 mt-sm-0" id="class">
                <label for="GenderId" class="form-control-label">Type Class</label>
                <select class="multisteps-form__select form-control" name="type"  id="type" required="true" disabled >
                <option value="">Select Type</option>
                          @foreach($classtypes as $list)
                          @if($type==$list->id)
                            <option selected value="{{$list->id}}">{{$list->classtype}}</option>
                          @else
                             <option  value="{{$list->id}}">{{$list->classtype}}</option>
                          @endif
                          @endforeach
                </select>
                </div>
                 <div class="col-12 col-sm-4 mt-4 mt-sm-0" id="a">
                    <label for="role">Subject Name</label>
                    <input type="text" class="form-control" id="subject" required="true"  name="name" value="{{$name}}" readonly>
                </div>

                   <div class="col-12 col-sm-4 mt-4 mt-sm-0" id="a">
                    <label for="role">Module Name</label>
                    <input type="text" class="form-control" id="subject" required="true"  name="name" value="{{$module}}" readonly>
                </div>
               
                
          </div>
              <div class="form-row mt-4"> 
                  <div class="col-12 col-sm-4 mt-4 mt-sm-0" id="class">
                <label for="GenderId" class="form-control-label">Class</label>
                <select class="multisteps-form__select form-control" name="class"  id="clasy" required="true" required  readonly>
                <option value="">Select Class</option>
                 @foreach($class as $list)
                 @if($cl==$list->id)
                 <option value="{{$list->id}}" selected>{{$list->categories}}</option>
                 @else
                 <option value="{{$list->id}}">{{$list->categories}}</option>
                 @endif
                 @endforeach
               
                </select>
                </div>
                 <div class="col-12 col-sm-4 mt-4 mt-sm-0">
                    <label for="jobrole">Day</label>
                     <select name="day" class="form-control" id="day" required="true" data-val="" disabled>
                     <option value="" >Select Day</option>
                     @foreach($days as $list)
                     @if($day==$list)
                       <option  value="{{$list}}" selected>{{$list}}</option>
                     @else
                      <option  value="{{$list}}">{{$list}}</option>
                      @endif
                     @endforeach
                </select>
              
               
             
                
              </div>
                <div class="col-12 col-sm-4 mt-4 mt-sm-0">
                    <label for="jobrole">Period</label>
                    <input type="text" name="" value="{{$period}}" disabled class="form-control">
                  </div>
                 
                  </div>
                 
             
               
                <div class="form-row mt-4">
                	 
                	  <div class="col-12 col-sm-3 mt-4 mt-sm-0" id="class">
                <label for="GenderId" class="form-control-label">Previous Faculty</label>
                  <input type="text" class="form-control" id="students" required="true"  name="faculties" value="{{$fac}}" readonly>
                </div>
                 <div class="col-12 col-sm-3 mt-4 mt-sm-0" id="class">
                <label for="GenderId" class="form-control-label">Previous Room</label>
                  <input type="text" class="form-control" id="students" required="true"  name="faculties" value="{{$room}}" readonly>
                </div>

                  <div class="col-12 col-sm-3 mt-4 mt-sm-0">
                    <label for="jobrole">Availble Faculty</label>
                     <select name="facs" class="form-control" id="day" required="true" data-val="" >
                     <option value="" >Select Faculty</option>
                     
                       @foreach($faculties as $list)
                       @if(in_array($list->id,$faval))
                       @else
                       <option value="FACULTY**{{$list->id}}">{{$list->fname}}</option>
                       @endif
                      @endforeach
                      @foreach($managers as $list)
                       @if(in_array($list->id,$maval))
                       @else
                       <option value="MANAGER**{{$list->id}}">{{$list->mname}}</option>  
                       @endif
                      @endforeach
                      @foreach($supervisors as $list)
                       <option value="GROUPMANAGER**{{$list->id}}">{{$list->supname}}</option>  
                      @endforeach
                    
                </select>
              </div>

                  <div class="col-12 col-sm-3 mt-4 mt-sm-0" id="class">
                <label for="GenderId" class="form-control-label">Available Rooms</label>
                <select class="form-control" name="rooms"  id="rooms" required="true" >
                     <option value="" >Select </option>
                  @foreach($rooms as $list)
                         @if(in_array($list->id,$roomsocc))
                       @else
                       <option value="ROOM**{{$list->id}}">{{$list->roomname}}</option>  
                       @endif 
                      @endforeach
                
                         
                </select>
                
                </div>
                 </div>
                 
                

                  
              
               
            
                  
                  
                    <input type="hidden" name="id" value="{{$id}}">
                   
                </div>
                <div class="card-footer" align="center">
                    <button type="submit" class="btn btn-primary" id="ass">Update</button>
                </div>
        </div>
        </form>
    </div>
</div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

</script>
@endsection