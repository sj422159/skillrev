@extends('nontechmanager/infrastructure/layout')
@section('title','Add Hostel Items')
@section('Dashboard_select','active')
@section('container')

<div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <div class="form-row mt-4"> 
                <a href="{{url('infrastructure/items.xlsx')}}">
                <button type="button" class="btn btn-success">
                 Download Sample Excel Sheet
                </button> 
               </a>
               <br>
                @if(session()->has('failure'))
        <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
            <span class="badge badge-pill badge-danger"></span>
            {{session('failure')}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
            </button>
        </div>
    @endif
              
               
        <form action="{{url('nontech/manager/infrastructure/school/uploaditems')}}" enctype="multipart/form-data" method="post" class="col-12"> @csrf
               
            <div class="form-row mt-4">
               <div class="col-12 col-sm-3 mt-2 mt-sm-0" style="display: flex;flex-direction: column;">
                       <label>CLASS :</label>
                        <select class="form-control" name="class" required id="topbranch">
                            <option value="">Select</option>
                            @foreach($class as $list)
                             <option value="{{$list->id}}">{{$list->categories}}</option>
                            @endforeach
                        </select>
                     </div>
                   
                    <div class="col-12 col-sm-3 mt-2 mt-sm-0" style="display: flex;flex-direction: column;">
                      <label>SECTION :</label>
                         <select class="form-control" name="section" required id="mainbranch" >
                           <option value="">Select</option>
                         </select>
                     </div>

        <div class="col-12 col-sm-3 mt-4 mt-sm-0">
            <label>Items</label>
            <select class="form-control" aria-required="true" aria-invalid="false" name="items" id="items" required>
                <option value="">Select</option>
                @foreach($items as $list)
                     <option value="{{$list->id}}">{{$list->infraitem}}</option>
                @endforeach 
            </select>
        </div>
      

             
       
       

        </div>


               


                    <div class="input-group col-md-8" style="margin-top:20px !important;">
                      <div class="custom-file">
                        <input type="file" name='excel' id="file" required="true">
                      </div>
                <button type="submit" class="btn btn-success" id="submit">
                 Upload Items
                </button>
                </div> 
        </form>
               
        </div>

              
               
              </div>
            </div>
          </div>
        </div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>


jQuery(document).ready(function(){
    jQuery('#topbranch').change(function (){
        let classid=document.getElementById("topbranch").value;
        jQuery.ajax({
            url:'{{url("nontech/manager/view/sections")}}',
            type:'get',
            data:{classid:classid},
            success:function(result){
            jQuery('#mainbranch').html(result)
            }
        });
    });

});


</script>


@endsection
