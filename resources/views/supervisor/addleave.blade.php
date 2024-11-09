@extends('supervisor/layout')
@section('title','Apply Leave')
@section('manager_select','active')
@section('container')
<div class="row">
    <div class="col-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title" style="color:#fff !important;">Apply Leave</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{url('supervisor/apply/leave/saveapplyleave')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <?php $date= date('Y-m-d', strtotime('+1 days')); ?>
            <div class="form-row">
                  <div class="col-12 col-sm-4 mt-4 mt-sm-0">
                    <label for="jobrole">From Date</label>
                    <input type="date" class="form-control" id="from" required="true" name="fromdate" value="{{$fromdate}}" min={{$date}} oninput="getInputValue();">
                  </div>
                  <div class="col-12 col-sm-4 mt-4 mt-sm-0">
                    <label for="jobrole">To Date</label>
                    <input type="date" class="form-control" id="to" required="true" name="todate" value="{{$todate}}" disabled="true">
                  </div>

                   <div class="col-12 col-sm-4 mt-4 mt-sm-0">
                    <label for="jobrole">Reason</label>
                    <input type="text" class="form-control" id="jobrole" required="true" placeholder="Enter Reason" name="reason" value="{{$reason}}">
                  </div>

                  

                  </div>
                    <input type="hidden" name="id" value="{{$id}}">
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                </div>
        </div>
        </form>
    </div>
</div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="{{asset('assets/js/multiselect-dropdown.js')}}"></script>


 <script type="text/javascript">
function getInputValue(){
            var from = document.getElementById("from").value;
            var to = document.getElementById("to");
            to.min = from;
            to.disabled=false;
            
        }
       
    </script>
@endsection