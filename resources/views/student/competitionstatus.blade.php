@extends('student/layout')
@section('title','Competition Status')
@section('Dashboard_select','active')
@section('container')

<div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body" style="text-align:center;">
                    <div style="display:flex;justify-content: center;">
                    <h4 class="card-title" ><b>COMPETITION STATUS </b></h4>
                    </div>                    
                    <table class="table">
                      <thead>
                        <tr>
                          <th>COMPETITION NAME</th>
                          <th>APPLY DATE</th>
                          <th>CURRENT STATUS</th>
                          <th>ACTION</th>
                        </tr>
                      </thead>
                      <tbody>
                      @foreach($bookedcompetitions as $list)
                        <tr>
                        <td>{{$list->competitionname}}</td> 
                        <td>{{$list->applydate}}</td>
                        @if($list->competitionstatus==1)
                          <td><label class="badge badge-info">Applied</label></td>
                          <td><a href="#" class="btn btn-primary btn-sm disabled">View Certificate</a></td>
                        @elseif($list->competitionstatus==2)
                          <td><label class="badge badge-danger">Not Shortlisted</label></td>
                          <td><a href="#" class="btn btn-primary btn-sm disabled">View Certificate</a></td>
                        @elseif($list->competitionstatus==3)
                          <td><label class="badge badge-primary">Selected</label></td>
                          <td><a href="#" class="btn btn-primary btn-sm disabled">View Certificate</a></td>
                        @elseif($list->competitionstatus==4)
                          <td><label class="badge badge-success">Completed</label></td>
                          @if($list->certificatepdf!=0 && $list->certificatepdf!=1)
                          <td><a href="{{url('pdf/competition')}}/{{$list->certificatepdf}}" target="_blank" class="btn btn-primary btn-sm">View Certificate</a></td>
                          @else
                          <td><a href="#" class="btn btn-primary btn-sm disabled">Certificate</a></td>
                          @endif
                        @endif
                        </tr>
                      @endforeach  
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
@endsection