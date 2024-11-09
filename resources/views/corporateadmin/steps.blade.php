@extends('corporateadmin/layout')
@section('title','Hightlights')
@section('home','active')
@section('container')

<div class="row">
<div class="col-11" style="margin:20px !important">
 <div class="card card-primary">
              <div class="card-header">
                <h5 style="text-align:center !important;text-transform: uppercase;color: #fff!important;">
                  Steps Details
                </h5>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
               <form action="{{url('corporateadmin/steps/save')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                  <div class="form-row mt-2">

                    <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                        <label for="TypeOfEduId">Step 1</label>
                        <textarea name="step1" required rows="2" column="15" placeholder="Enter Details" class="form-control">{{$data[0]->step1}}</textarea>
                    </div>
                    <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                        <label for="TypeOfEduId">Step 2</label>
                        <textarea name="step2" required rows="2" column="15" placeholder="Enter Details" class="form-control">{{$data[0]->step2}}</textarea>
                    </div>
                    <div class="col-12 col-sm-6 mt-4 mt-sm-2">
                        <label for="TypeOfEduId">Step 3</label>
                        <textarea name="step3" required rows="2" column="15" placeholder="Enter Details" class="form-control">{{$data[0]->step3}}</textarea>
                    </div>
                    <div class="col-12 col-sm-6 mt-4 mt-sm-2">
                        <label for="TypeOfEduId">Step 4</label>
                        <textarea name="step4" required rows="2" column="15" placeholder="Enter Details" class="form-control">{{$data[0]->step4}}</textarea>
                    </div>
                    <div class="col-12 col-sm-6 mt-4 mt-sm-2">
                        <label for="TypeOfEduId">Step 5 (Optional)</label>
                        <textarea name="step5" rows="2" column="15" placeholder="Enter Details" class="form-control">{{$data[0]->step5}}</textarea>
                    </div>

                    <div class="col-12 col-sm-6 mt-4 mt-sm-2">
                        <label for="TypeOfEduId">Image 1</label>
                        <input type="file" name="image1" class="form-control">
                    </div>
                    <div class="col-12 col-sm-6 mt-4 mt-sm-2">
                        <label for="TypeOfEduId">Image 2</label>
                        <input type="file" name="image2" class="form-control">
                    </div>
                    <div class="col-12 col-sm-6 mt-4 mt-sm-2">
                        <label for="TypeOfEduId">Image 3</label>
                        <input type="file" name="image3" class="form-control">
                    </div>
                    <div class="col-12 col-sm-6 mt-4 mt-sm-2">
                        <label for="TypeOfEduId">Image 4</label>
                        <input type="file" name="image4" class="form-control">
                    </div>
                    <div class="col-12 col-sm-6 mt-4 mt-sm-2">
                        <label for="TypeOfEduId">Image 5 (Optional)</label>
                        <input type="file" name="image5" class="form-control">
                    </div>

                </div>
                <input type="hidden" name="id" value="{{$data[0]->id}}">
                </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                </div>
              </form>
            </div>
        </div>
    </div>
@endsection