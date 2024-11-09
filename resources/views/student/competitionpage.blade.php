@extends('student/layout')
@section('title','Competition Page')
@section('Dashboard_select','active')
@section('container')
    <div class="wrapper">
    @foreach($competitions as $list)
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                
                <div class="col-md-12">
                <a href="{{url('student/dashboard')}}" class="btn btn-danger btn-sm text-sm" style="margin-bottom: 10px !important;">
                   Back
                </a>
                    <div class="card">
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="active tab-pane" id="activity">
                                    <!-- Post -->
                                    <div class="post">
                                        <div class="user-block">
                                            <img class="img-circle img-bordered-sm" src="{{asset('competitionimages')}}/{{$list->image}}" style="border-radius: 0px;" alt="user image">
                                            <span class="description">Competition Name :
                                            <a href="#">{{$list->competitionname}}</a>
                                            </span>
                                            <span class="description" style="margin-top:3px;">Subtitle :
                                            <a href="#">{{$list->subtitle}}</a>
                                            </span>
                                            <span class="description" style="margin-top:3px;">Description :
                                            <a href="#">{{$list->description}}</a>
                                            </span>
                                            <span class="description" style="margin-top:3px;">Training From :
                                            <a href="#">{{$list->fromdate}} to {{$list->todate}}</a>
                                            </span>
                                        </div>
                                        <p style="text-align: justify;"></p>
                                        <p style="margin-top:10px !important;">
                        
                        <span class="float-right">
                           @if(count($competitionbooking)==0)
                          <a href="{{url('student/competition/apply')}}/{{$competitions[0]->id}}" class="btn btn-primary btn-sm text-sm">
                            Apply
                          </a>
                          @else
                          <a href="#" class="btn btn-success btn-sm text-sm">
                            Applied
                          </a>
                          @endif
                        </span>
                      </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
    @endforeach  
    </div>
    @endsection