@extends('admin/layout')
@section('title','Add Category')
@section('Dashboard_select','active')
@section('container')
<div class="row">
    <div class="col-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title" style="color:#fff !important;">Regular Fees Schedule</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{url('admin/fees/saveschedule')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                <div class="form-row">
                  
                    <div class="col-12 col-sm-3">
                        <label for="jobrole">Category</label>

                        <select class="form-control" name="category" id="category" required="true" onchange="check(this)">
                            <option value="">Select</option>
                             @foreach($categories as $list)
                             @if($shcategory==$list->id)
                             <option value="{{$list->id}}**{{$list->fctype}}" selected>{{$list->fcategory}}</option>
                             @else
                             @if($id>0)
                               <!-- <option value="{{$list->id}}**{{$list->fctype}}">{{$list->fcategory}}</option> -->
                             @else
                               <option value="{{$list->id}}**{{$list->fctype}}">{{$list->fcategory}}</option>
                             @endif
                             @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-sm-3">
                        <label for="jobrole">Class</label>
                          <select class="form-control" name="type" id="by" >
                           <option value="">Select</option>
                        </select>

                        <select class="form-control" name="type1" id="cls"  style="display:none">
                           <option value="">Select</option>
                           @foreach($class as $list)
                           @if($shtype==$list->categories)
                            <option value="{{$list->id}}**{{$list->categories}}" selected>{{$list->categories}}</option>
                           @else
                            <option value="{{$list->id}}**{{$list->categories}}">{{$list->categories}}</option>
                            @endif
                           @endforeach
                        </select>
                        <select class="form-control" name="type2"  id="dis" style="display:none">
                           <option value="">Select</option>
                           @foreach($distance as $list)
                            @if($shtype==($list->distance)." Km")
                            <option value="{{$list->id}}**{{$list->distance}} Km" selected>{{$list->location}}</option>
                            @else
                            <option value="{{$list->id}}**{{$list->distance}} Km">{{$list->location}}</option>
                            @endif
                           @endforeach
                        </select>
                    </div>

                     <div class="col-12 col-sm-3">
                        <label for="jobrole">Annual</label>
                       <input type="number" name="annual" placeholder="Enter Fees" class="form-control" required value="{{$shannual}}">
                    </div>

                     <div class="col-12 col-sm-3">
                        <label for="jobrole">Half Yearly</label>
                       <input type="number" name="half" placeholder="Enter Fees" class="form-control" required value="{{$shhalf}}">
                    </div>
                    
                </div>
                 <div class="form-row mt-4">
                      <div class="col-12 col-sm-3">
                        <label for="jobrole">Quarterly</label>
                       <input type="number" name="quater" placeholder="Enter Fees" class="form-control" required value="{{$shquater}}">
                    </div>
                      <div class="col-12 col-sm-3">
                        <label for="jobrole">Monthly</label>
                       <input type="number" name="month" placeholder="Enter Fees" class="form-control" required value="{{$shmonthly}}">
                    </div>
                 </div>
                 <input type="hidden" name="id" value="{{$id}}">
                
                <div class="card-footer mt-4">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
        </div>
        </form>
    </div>
</div>
</div>
<script type="text/javascript">
    function check(that){
        var val=that.value.split("**");
        if(val[1]==1){
            document.getElementById('cls').style="display:block";
            document.getElementById('dis').style="display:none";  
            document.getElementById('by').style="display:none";  

        }else{
          document.getElementById('dis').style="display:block";  
          document.getElementById('cls').style="display:none";
           document.getElementById('by').style="display:none";  

        }
    }

    var test=document.getElementById('category').value;

    if(test!=""){
       
         var check=test.split("**");
         if(check[1]==1){
            document.getElementById('cls').style="display:block";
            document.getElementById('dis').style="display:none";  
            document.getElementById('by').style="display:none";  

        }else{
          document.getElementById('dis').style="display:block";  
          document.getElementById('cls').style="display:none";
           document.getElementById('by').style="display:none";  

        }
    }

</script>
@endsection