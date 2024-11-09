@extends('corporateadmin/layout')
@section('title','Home-Page Events')
@section('home','active')
@section('container')

<div class="row">
<div class="col-11" style="margin:20px !important">
 <div class="card card-primary">
              <div class="card-header">
                <h5 style="text-align:center !important;text-transform: uppercase;color: #fff!important;">Event Details</h5>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
               <form action="{{url('corporateadmin/events/save')}}" method="post">
                @csrf
                <div class="card-body">
                  <div class="form-row mt-2">
                    <div class="col-12 col-sm-4 mt-4 mt-sm-0">
                      <label for="TypeOfEduId">School Events :</label>
                      <textarea name="school" required rows="5" column="15" placeholder="Enter Details" class="form-control">{{$data[0]->content}}</textarea>
                    </div>
                    <div class="col-12 col-sm-4 mt-4 mt-sm-0">
                      <label for="TypeOfEduId">Special Events :</label>
                      <textarea name="special" required rows="5" column="15" placeholder="Enter Details" class="form-control">{{$data[0]->content2}}</textarea>
                    </div>
                    <div class="col-12 col-sm-4 mt-4 mt-sm-0">
                      <label for="TypeOfEduId">SkillRevelation Events :</label>
                      <textarea name="skill" required rows="5" column="15" placeholder="Enter Details" class="form-control">{{$data[0]->content3}}</textarea>
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