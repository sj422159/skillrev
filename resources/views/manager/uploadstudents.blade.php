@extends('manager/layout')
@section('title','Upload Students')
@section('dashboard_select','active extra')
@section('container')
<div class="row">
 
          <!-- left column -->
          <div class="col-md-12">
             @if(session()->has('success'))
  <div class="sufee-alert alert with-close alert-success alert-dismissible fade show">
                      <span class="badge badge-pill badge-success"></span>
                      {{session('success')}}
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                      </button>
  </div>
  @endif
            <!-- general form elements -->
            <div class="card " style="padding:20px">
              <div class="card-header" style="display:flex;justify-content:center;background-color:#e6e6e6;color:#000">
                <h3 class="card-title">Upload Student Details</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
               <div class="col-md-12" style="display:flex;flex-direction: row !important;margin-top: 20px;">
              <a href="{{url('studentdetails/studentdetails.xlsx')}}" class="btn btn-primary btn-sm">Download Template</a>
              </div>
              <div class="col-md-12" style="display:flex;flex-direction: row !important;margin-top: 30px;">
                  
          <div class="col-md-6">
            <img src="{{asset('home/stupld.svg')}}" style="height:230px !important;">
          </div>
             <div class="col-md-6">
              <form action="{{url('manager/upload/student/save')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                    <label for="exampleInputFile">Section</label>
                    <div class="input-group">
                         <select class="form-control" required="true" name="sec">
                           <option value="">Select</option>
                           @foreach($sections as $list)
                           <option value="{{$list->id}}">{{$list->section}}</option>
                           @endforeach
                         </select>
                    </div>
                  </div>
                 
                  <div class="form-group">
                    <label for="exampleInputFile">File input</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" required="true" name="file" id="exampleInputFile">
                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                      </div>
                      <div class="input-group-append">
                        <!--span class="input-group-text">Upload</span-->
                      </div>
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->

                
                  <button type="submit" class="btn-sm btn btn-primary">Submit</button>
                 <a href="{{url('manager/dashboard')}}"> <button type="button" class="btn-sm btn btn-danger">Cancel</button></a>
                
              </form>
              </div>
            </div>
            <!-- /.card -->

              </div>
              <!-- /.card-body -->
            </div>
           

@endsection