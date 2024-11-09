@extends('corporateadmin/layout')
@section('title','Hightlights')
@section('home','active')
@section('container')

<div class="row">
<div class="col-11" style="margin:20px !important">
 <div class="card card-primary">
              <div class="card-header">
                <h5 style="text-align:center !important;text-transform: uppercase;color: #fff!important;">
                  Highlights Details
                </h5>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
               <form action="{{url('corporateadmin/highlights/save')}}" method="post">
                @csrf
                <div class="card-body">
                  <div class="form-row mt-2">
                    <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                      <label for="TypeOfEduId">Main Heading</label>
                      <textarea name="mainhead" required rows="3" column="15" placeholder="Enter Details" class="form-control">{{$data[0]->mainhead}}</textarea>
                    </div>
                    <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                      <label for="TypeOfEduId">Description</label>
                      <textarea name="desc" required rows="3" column="15" placeholder="Enter Details" class="form-control">{{$data[0]->descrip}}</textarea>
                    </div>


                    <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                      <label for="TypeOfEduId">Title 1</label>
                      <textarea name="title1" required rows="3" column="15" placeholder="Enter Details" class="form-control">{{$data[0]->title1}}</textarea>
                    </div>
                    <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                      <label for="TypeOfEduId">Description 1</label>
                      <textarea name="description1" required rows="3" column="15" placeholder="Enter Details" class="form-control">{{$data[0]->description1}}</textarea>
                    </div>

                    <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                      <label for="TypeOfEduId">Title 2</label>
                      <textarea name="title2" required rows="3" column="15" placeholder="Enter Details" class="form-control">{{$data[0]->title2}}</textarea>
                    </div>
                    <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                      <label for="TypeOfEduId">Description 2</label>
                      <textarea name="description2" required rows="3" column="15" placeholder="Enter Details" class="form-control">{{$data[0]->description2}}</textarea>
                    </div>

                    <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                      <label for="TypeOfEduId">Title 3</label>
                      <textarea name="title3" required rows="3" column="15" placeholder="Enter Details" class="form-control">{{$data[0]->title3}}</textarea>
                    </div>
                    <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                      <label for="TypeOfEduId">Description 3</label>
                      <textarea name="description3" required rows="3" column="15" placeholder="Enter Details" class="form-control">{{$data[0]->description3}}</textarea>
                    </div>

                    <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                      <label for="TypeOfEduId">Title 4</label>
                      <textarea name="title4" required rows="3" column="15" placeholder="Enter Details" class="form-control">{{$data[0]->title4}}</textarea>
                    </div>
                    <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                      <label for="TypeOfEduId">Description 4</label>
                      <textarea name="description4" required rows="3" column="15" placeholder="Enter Details" class="form-control">{{$data[0]->description4}}</textarea>
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