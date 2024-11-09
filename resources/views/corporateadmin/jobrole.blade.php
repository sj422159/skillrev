@extends('corporateadmin/layout')
@section('title','Job-Role')
@section('home','active')
@section('container')

<style>
  .hide {
          display: none;
        }
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-1.11.3.js"></script>

<div class="row">
<div class="col-11" style="margin:20px !important">
 <div class="card card-primary">
              <div class="card-header">
                <h5 style="text-align:center !important;text-transform: uppercase;color: #fff!important;">
                  Job-Roles Details
                </h5>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
               <form action="{{url('corporateadmin/jobrole/save')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                  <div class="mb-5">
                    <select class="div-toggle" data-target=".my_course" style="width:155px; float:right;">
                        <option selected>Select JobRole</option>
                        <option value="1" data-show=".one">JobRole 1</option>
                        <option value="2" data-show=".two">JobRole 2</option>
                        <option value="3" data-show=".three">JobRole 3</option>
                        <option value="4" data-show=".four">JobRole 4</option>
                        <option value="5" data-show=".five">JobRole 5</option>
                        <option value="6" data-show=".six">JobRole 6</option>
                    </select>

                </div>

                  <div class="my_course form-row mt-2">

                   <div class="one hide form-row col-12">
                      <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                        <label for="TypeOfEduId">Title 1</label>
                        <textarea name="title1" required rows="2" column="15" placeholder="Enter Details" class="form-control">{{$data[0]->title1}}</textarea>
                      </div>
                      <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                        <label for="TypeOfEduId">Description 1</label>
                        <textarea name="description1" required rows="2" column="15" placeholder="Enter Details" class="form-control">{{$data[0]->description1}}</textarea>
                      </div>
                      <div class="col-12 col-sm-6 mt-4 mt-sm-2">
                        <label for="TypeOfEduId">Image 1</label>
                        <input type="file" name="image1" class="form-control">
                      </div>
                      <div class="col-12 col-sm-6 mt-4 mt-sm-2">
                        <label for="TypeOfEduId">URL</label>
                        <textarea name="url1" required rows="2" column="15" placeholder="Enter Details" class="form-control">{{$data[0]->url1}}</textarea>
                      </div>

                      <div class="col-12 col-sm-6 mt-4 mt-sm-2">
                        <label for="TypeOfEduId">Skillset 1</label>
                        <textarea name="skillset00" required rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $data[0]->skillset1 }}</textarea>
                      </div>
                      <div class="col-12 col-sm-6 mt-4 mt-sm-2">
                        <label for="TypeOfEduId">Skillset 2</label>
                        <textarea name="skillset01" required rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $s2[0]->skillset1 }}</textarea>
                      </div>
                      <div class="col-12 col-sm-6 mt-4 mt-sm-2">
                        <label for="TypeOfEduId">Skillset 3</label>
                        <textarea name="skillset02" rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $s3[0]->skillset1 }}</textarea>
                      </div>
                      <div class="col-12 col-sm-6 mt-4 mt-sm-2">
                        <label for="TypeOfEduId">Skillset 4</label>
                        <textarea name="skillset03" rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $s4[0]->skillset1 }}</textarea>
                      </div>
                      <div class="col-12 col-sm-6 mt-4 mt-sm-2">
                        <label for="TypeOfEduId">Skillset 5</label>
                        <textarea name="skillset04" rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $s5[0]->skillset1 }}</textarea>
                      </div>

                   </div>

                   <div class="two hide form-row col-12">
                    <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                      <label for="TypeOfEduId">Title 2</label>
                      <textarea name="title2" required rows="2" column="15" placeholder="Enter Details" class="form-control">{{$data[0]->title2}}</textarea>
                    </div>
                    <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                      <label for="TypeOfEduId">Description 2</label>
                      <textarea name="description2" required rows="2" column="15" placeholder="Enter Details" class="form-control">{{$data[0]->description2}}</textarea>
                    </div>
                    <div class="col-12 col-sm-6 mt-4 mt-sm-2">
                      <label for="TypeOfEduId">Image 2</label>
                      <input type="file" name="image2" class="form-control">
                    </div>
                    <div class="col-12 col-sm-6 mt-4 mt-sm-2">
                      <label for="TypeOfEduId">URL</label>
                      <textarea name="url2" required rows="2" column="15" placeholder="Enter Details" class="form-control">{{$data[0]->url2}}</textarea>
                    </div>

                    <div class="col-12 col-sm-6 mt-4 mt-sm-2">
                      <label for="TypeOfEduId">Skillset 1</label>
                      <textarea name="skillset10" required rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $data[0]->skillset2 }}</textarea>
                    </div>
                    <div class="col-12 col-sm-6 mt-4 mt-sm-2">
                      <label for="TypeOfEduId">Skillset 2</label>
                      <textarea name="skillset11" required rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $s2[0]->skillset2 }}</textarea>
                    </div>
                    <div class="col-12 col-sm-6 mt-4 mt-sm-2">
                      <label for="TypeOfEduId">Skillset 3</label>
                      <textarea name="skillset12" rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $s3[0]->skillset2 }}</textarea>
                    </div>
                    <div class="col-12 col-sm-6 mt-4 mt-sm-2">
                      <label for="TypeOfEduId">Skillset 4</label>
                      <textarea name="skillset13" rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $s4[0]->skillset2 }}</textarea>
                    </div>
                    <div class="col-12 col-sm-6 mt-4 mt-sm-2">
                      <label for="TypeOfEduId">Skillset 5</label>
                      <textarea name="skillset14" rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $s5[0]->skillset2 }}</textarea>
                    </div>
                   </div>

                   <div class="three hide form-row col-12">
                    <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                      <label for="TypeOfEduId">Title 3</label>
                      <textarea name="title3" required rows="2" column="15" placeholder="Enter Details" class="form-control">{{$data[0]->title3}}</textarea>
                    </div>
                    <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                      <label for="TypeOfEduId">Description 3</label>
                      <textarea name="description3" required rows="2" column="15" placeholder="Enter Details" class="form-control">{{$data[0]->description3}}</textarea>
                    </div>
                    <div class="col-12 col-sm-6 mt-4 mt-sm-2">
                      <label for="TypeOfEduId">Image 3</label>
                      <input type="file" name="image3" class="form-control">
                    </div>
                    <div class="col-12 col-sm-6 mt-4 mt-sm-2">
                      <label for="TypeOfEduId">URL</label>
                      <textarea name="url3" required rows="2" column="15" placeholder="Enter Details" class="form-control">{{$data[0]->url3}}</textarea>
                    </div>

                    <div class="col-12 col-sm-6 mt-4 mt-sm-2">
                      <label for="TypeOfEduId">Skillset 1</label>
                      <textarea name="skillset20" required rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $data[0]->skillset3 }}</textarea>
                    </div>
                    <div class="col-12 col-sm-6 mt-4 mt-sm-2">
                      <label for="TypeOfEduId">Skillset 2</label>
                      <textarea name="skillset21" required rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $s2[0]->skillset3 }}</textarea>
                    </div>
                    <div class="col-12 col-sm-6 mt-4 mt-sm-2">
                      <label for="TypeOfEduId">Skillset 3</label>
                      <textarea name="skillset22" rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $s3[0]->skillset3 }}</textarea>
                    </div>
                    <div class="col-12 col-sm-6 mt-4 mt-sm-2">
                      <label for="TypeOfEduId">Skillset 4</label>
                      <textarea name="skillset23" rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $s4[0]->skillset3 }}</textarea>
                    </div>
                    <div class="col-12 col-sm-6 mt-4 mt-sm-2">
                      <label for="TypeOfEduId">Skillset 5</label>
                      <textarea name="skillset24" rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $s5[0]->skillset3 }}</textarea>
                    </div>
                   </div>

                   <div class="four hide form-row col-12">
                    <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                      <label for="TypeOfEduId">Title 4</label>
                      <textarea name="title4" required rows="2" column="15" placeholder="Enter Details" class="form-control">{{$data[0]->title4}}</textarea>
                    </div>
                    <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                      <label for="TypeOfEduId">Description 4</label>
                      <textarea name="description4" required rows="2" column="15" placeholder="Enter Details" class="form-control">{{$data[0]->description4}}</textarea>
                    </div>
                    <div class="col-12 col-sm-6 mt-4 mt-sm-2">
                      <label for="TypeOfEduId">Image 4</label>
                      <input type="file" name="image4" class="form-control">
                    </div>
                    <div class="col-12 col-sm-6 mt-4 mt-sm-2">
                      <label for="TypeOfEduId">URL</label>
                      <textarea name="url4" required rows="2" column="15" placeholder="Enter Details" class="form-control">{{$data[0]->url4}}</textarea>
                    </div>

                    <div class="col-12 col-sm-6 mt-4 mt-sm-2">
                      <label for="TypeOfEduId">Skillset 1</label>
                      <textarea name="skillset30" required rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $data[0]->skillset4 }}</textarea>
                    </div>
                    <div class="col-12 col-sm-6 mt-4 mt-sm-2">
                      <label for="TypeOfEduId">Skillset 2</label>
                      <textarea name="skillset31" required rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $s2[0]->skillset4 }}</textarea>
                    </div>
                    <div class="col-12 col-sm-6 mt-4 mt-sm-2">
                      <label for="TypeOfEduId">Skillset 3</label>
                      <textarea name="skillset32" rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $s3[0]->skillset4 }}</textarea>
                    </div>
                    <div class="col-12 col-sm-6 mt-4 mt-sm-2">
                      <label for="TypeOfEduId">Skillset 4</label>
                      <textarea name="skillset33" rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $s4[0]->skillset4 }}</textarea>
                    </div>
                    <div class="col-12 col-sm-6 mt-4 mt-sm-2">
                      <label for="TypeOfEduId">Skillset 5</label>
                      <textarea name="skillset34" rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $s5[0]->skillset4 }}</textarea>
                    </div>
                   </div>

                   <div class="five hide form-row col-12">
                    <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                        <label for="TypeOfEduId">Title 5</label>
                        <textarea name="title5" required rows="2" column="15" placeholder="Enter Details" class="form-control">{{$data[0]->title5}}</textarea>
                      </div>
                      <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                        <label for="TypeOfEduId">Description 5</label>
                        <textarea name="description5" required rows="2" column="15" placeholder="Enter Details" class="form-control">{{$data[0]->description5}}</textarea>
                    </div>
                    <div class="col-12 col-sm-6 mt-4 mt-sm-2">
                      <label for="TypeOfEduId">Image 5</label>
                      <input type="file" name="image5" class="form-control">
                    </div>
                    <div class="col-12 col-sm-6 mt-4 mt-sm-2">
                      <label for="TypeOfEduId">URL</label>
                      <textarea name="url5" required rows="2" column="15" placeholder="Enter Details" class="form-control">{{$data[0]->url5}}</textarea>
                    </div>

                    <div class="col-12 col-sm-6 mt-4 mt-sm-2">
                      <label for="TypeOfEduId">Skillset 1</label>
                      <textarea name="skillset40" required rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $data[0]->skillset5 }}</textarea>
                    </div>
                    <div class="col-12 col-sm-6 mt-4 mt-sm-2">
                      <label for="TypeOfEduId">Skillset 2</label>
                      <textarea name="skillset41" required rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $s2[0]->skillset5 }}</textarea>
                    </div>
                    <div class="col-12 col-sm-6 mt-4 mt-sm-2">
                      <label for="TypeOfEduId">Skillset 3</label>
                      <textarea name="skillset42" rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $s3[0]->skillset5 }}</textarea>
                    </div>
                    <div class="col-12 col-sm-6 mt-4 mt-sm-2">
                      <label for="TypeOfEduId">Skillset 4</label>
                      <textarea name="skillset43" rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $s4[0]->skillset5 }}</textarea>
                    </div>
                    <div class="col-12 col-sm-6 mt-4 mt-sm-2">
                      <label for="TypeOfEduId">Skillset 5</label>
                      <textarea name="skillset44" rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $s5[0]->skillset5 }}</textarea>
                    </div>
                   </div>

                   <div class="six hide form-row col-12">
                    <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                        <label for="TypeOfEduId">Title 6</label>
                        <textarea name="title6" required rows="2" column="15" placeholder="Enter Details" class="form-control">{{$data[0]->title6}}</textarea>
                      </div>
                      <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                        <label for="TypeOfEduId">Description 6</label>
                        <textarea name="description6" required rows="2" column="15" placeholder="Enter Details" class="form-control">{{$data[0]->description6}}</textarea>
                    </div>
                    <div class="col-12 col-sm-6 mt-4 mt-sm-2">
                      <label for="TypeOfEduId">Image 6</label>
                      <input type="file" name="image6" class="form-control">
                    </div>
                    <div class="col-12 col-sm-6 mt-4 mt-sm-2">
                      <label for="TypeOfEduId">URL</label>
                      <textarea name="url6" required rows="2" column="15" placeholder="Enter Details" class="form-control">{{$data[0]->url6}}</textarea>
                    </div>

                    <div class="col-12 col-sm-6 mt-4 mt-sm-2">
                      <label for="TypeOfEduId">Skillset 1</label>
                      <textarea name="skillset50" required rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $data[0]->skillset6 }}</textarea>
                    </div>
                    <div class="col-12 col-sm-6 mt-4 mt-sm-2">
                      <label for="TypeOfEduId">Skillset 2</label>
                      <textarea name="skillset51" required rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $s2[0]->skillset6 }}</textarea>
                    </div>
                    <div class="col-12 col-sm-6 mt-4 mt-sm-2">
                      <label for="TypeOfEduId">Skillset 3</label>
                      <textarea name="skillset52" rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $s3[0]->skillset6 }}</textarea>
                    </div>
                    <div class="col-12 col-sm-6 mt-4 mt-sm-2">
                      <label for="TypeOfEduId">Skillset 4</label>
                      <textarea name="skillset53" rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $s4[0]->skillset6 }}</textarea>
                    </div>
                    <div class="col-12 col-sm-6 mt-4 mt-sm-2">
                      <label for="TypeOfEduId">Skillset 5</label>
                      <textarea name="skillset54" rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $s5[0]->skillset6 }}</textarea>
                    </div>
                   </div>


                </div>
                <input type="hidden" name="id1" value="{{$data[0]->id}}">
                <input type="hidden" name="id2" value="{{$s2[0]->id}}">
                <input type="hidden" name="id3" value="{{$s3[0]->id}}">
                <input type="hidden" name="id4" value="{{$s4[0]->id}}">
                <input type="hidden" name="id5" value="{{$s5[0]->id}}">
                </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                </div>
              </form>
            </div>
        </div>
    </div>

  <script>
    $(document).on('change', '.div-toggle', function() {
    var target = $(this).data('target');
    var show = $("option:selected", this).data('show');
    $(target).children().addClass('hide');
    $(show).removeClass('hide');
  });
  $(document).ready(function(){
      $('.div-toggle').trigger('change');
  });
  </script>

@endsection