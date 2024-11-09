@extends('corporateadmin/layout')
@section('title','Cold Call List') 
@section('dashboard_select','active extra') 
@section('container') 
<div class="container-fluid">
   <div class="row">
      <div class="col-12">
         <div class="card" style="margin-top:20px">
            <div class="card-header d-flex p-0">
               <h3 class="card-title p-3">Cold Call List</h3>
               <ul class="nav nav-pills ml-auto p-2">
                  <li class="nav-item">
                     <a class="nav-link active" href="#tab_1" data-toggle="tab">Initiated</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" href="#tab_2" data-toggle="tab">Inprogress</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" href="#tab_3" data-toggle="tab">Completed</a>
                  </li>
               </ul>
            </div>
            <div class="card-body">
               <div class="tab-content">
                  <div class="tab-pane active" id="tab_1">
                     <div class="row">
                        <div class="col-lg-12">
                           <div class="table-responsive table--no-card m-b-30">
                              <table class="table table-borderless table-data3">
                                 <thead style="background-color:#000;color:#fff;">
                                    <th>Type</th>
                                    <th>Name</th>
                                    <th>Location</th>
                                    <th>Address</th>
                                    <th>POC</th>
                                    <th>Designation</th>
                                    <th>Email</th>
                                    <th>Number</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                 </thead>
                                 <tbody>
         @foreach($needhelp as $list)
            <tr>  
                <td>{{$list->type}}</td>
                <td>{{$list->name}}</td>
                <td>{{$list->location}}</td>
                <td>{{$list->address}}</td>
                <td>{{$list->poc}}</td>
                <td>{{$list->designation}}</td>
                <td>{{$list->email}}</td>
                <td>{{$list->number}}</td>
                <td><span class="right badge badge-primary">Asked Help</span></td>
                <td><span class="right badge badge-info">Not Applicable</span></td>   
            </tr>
         @endforeach
        
         @foreach($rejected as $list)
            <tr>
                <td>{{$list->type}}</td>
                <td>{{$list->name}}</td>
                <td>{{$list->location}}</td>
                <td>{{$list->address}}</td>
                <td>{{$list->poc}}</td>
                <td>{{$list->designation}}</td>
                <td>{{$list->email}}</td>
                <td>{{$list->number}}</td>
                <td><span class="right badge badge-danger">Rejected</span></td>
                <td>
                  <a href="{{url('corporateadmin/marketingofficer/view/coldcalls/rejected')}}/{{$list->id}}"><span class="right badge badge-primary">View Reason</span></a>
                </td>   
            </tr>
        @endforeach
       
                                 </tbody>
                              </table>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="tab-pane" id="tab_2">
                     <div class="row">
                        <div class="col-lg-12">
                           <div class="table-responsive table--no-card m-b-30">
                              <table class="table table-borderless table-data3">
                                 <thead style="background-color:#000;color:#fff;">
                                    <tr>
                                       <th>Type</th>
                                       <th>Name</th>
                                       <th>Location</th>
                                       <th>Address</th>
                                       <th>POC</th>
                                       <th>Designation</th>
                                       <th>Email</th>
                                       <th>Number</th>
                                       <th>Status</th>
                                       <th>Action</th>
                                    </tr>
                                 </thead>
                                 <tbody>
         @foreach($inprogress as $list)
            <tr>  
               <td>{{$list->type}}</td>
               <td>{{$list->name}}</td>
               <td>{{$list->location}}</td>
               <td>{{$list->address}}</td>
               <td>{{$list->poc}}</td>
               <td>{{$list->designation}}</td>
               <td>{{$list->email}}</td>
               <td>{{$list->number}}</td>
               <td>
                  @if($list->status==3 && $list->mmreject==0)
                    <span class="right badge badge-primary">InProgress</span>
                    @elseif($list->status==3 && $list->mmreject==1)
                    <span class="right badge badge-danger">Rejected</span>
                  @endif
                </td> 
               <td>
                  @if($list->status==3 && $list->mmreject==0)
                  <span class="right badge badge-info">Not Applicable</span>
                  @elseif($list->status==3 && $list->mmreject==1)
                  <a href="{{url('corporateadmin/marketingofficer/view/coldcalls/rejected')}}/{{$list->id}}"><span class="right badge badge-primary">View Reason</span></a>
                  @endif
               </td>   
            </tr>
         @endforeach
                                 </tbody>
                              </table>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="tab-pane" id="tab_3">
                     <div class="row">
                        <div class="col-lg-12">
                           <div class="table-responsive table--no-card m-b-30">
                              <table class="table table-borderless table-data3">
                                 <thead style="background-color:#000;color:#fff;">
                                    <tr>
                                       <th>Type</th>
                                       <th>Name</th>
                                       <th>Location</th>
                                       <th>Address</th>
                                       <th>POC</th>
                                       <th>Designation</th>
                                       <th>Email</th>
                                       <th>Number</th>
                                       <th>Status</th>
                                       <th>Action</th>
                                    </tr>
                                 </thead>
                                 <tbody>
      @foreach($completed as $list)
            <tr>  
               <td>{{$list->type}}</td>
               <td>{{$list->name}}</td>
               <td>{{$list->location}}</td>
               <td>{{$list->address}}</td>
               <td>{{$list->poc}}</td>
               <td>{{$list->designation}}</td>
               <td>{{$list->email}}</td>
               <td>{{$list->number}}</td>
               <td>
                  <span class="right badge badge-primary">Completed</span>
               </td> 
               <td>
                  <span class="right badge badge-info">Not Applicable</span>
               </td>   
            </tr>
         @endforeach
                                 </tbody>
                              </table>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script> 
@endsection