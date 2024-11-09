@extends('corporateadmin/layout')
@section('title', 'Courses')
@section('home', 'active')
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
                        Courses Details
                    </h5>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ url('corporateadmin/courses/save') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="mb-5">
                            <select class="div-toggle" data-target=".my_course" style="width:155px; float:right;">
                                <option selected>Select Course</option>
                                <option value="1" data-show=".one">Course 1</option>
                                <option value="2" data-show=".two">Course 2</option>
                                <option value="3" data-show=".three">Course 3</option>
                                <option value="4" data-show=".four">Course 4</option>
                                <option value="5" data-show=".five">Course 5</option>
                                <option value="6" data-show=".six">Course 6</option>
                            </select>

                        </div>

                        <div class="my_course form-row mt-2">

                        <div class="one hide form-row col-12">
                          <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                              <label for="TypeOfEduId">Title 1</label>
                              <textarea name="title1" required rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $data[0]->title1 }}</textarea>
                          </div>
                          <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                              <label for="TypeOfEduId">Description 1</label>
                              <textarea name="description1" required rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $data[0]->description1 }}</textarea>
                          </div>
                          <div class="col-12 col-sm-6 mt-4 mt-sm-2">
                              <label for="TypeOfEduId">Image 1</label>
                              <input type="file" name="image1" class="form-control">

                          </div>
                          <div class="col-12 col-sm-6 mt-4 mt-sm-2">
                            <label for="TypeOfEduId">Duration of Course</label>
                            <textarea name="time1" required rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $data[0]->time1 }}</textarea>
                          </div>
                          <div class="col-12 col-sm-6 mt-4 mt-sm-2">
                            <label for="TypeOfEduId">Difficulty Level</label>
                            <textarea name="difficulty1" required rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $data[0]->difficulty1 }}</textarea>
                          </div>
                          <div class="col-12 col-sm-6 mt-4 mt-sm-2">
                            <label for="TypeOfEduId">URL</label>
                            <textarea name="url1" required rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $data[0]->url1 }}</textarea>
                          </div>

                        </div>

                        <div class="two hide form-row col-12">
                          <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                              <label for="TypeOfEduId">Title 2</label>
                              <textarea name="title2" required rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $data[0]->title2 }}</textarea>
                          </div>
                          <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                              <label for="TypeOfEduId">Description 2</label>
                              <textarea name="description2" required rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $data[0]->description2 }}</textarea>
                          </div>
                          <div class="col-12 col-sm-6 mt-4 mt-sm-2">
                              <label for="TypeOfEduId">Image 2</label>
                              <input type="file" name="image2" class="form-control">

                          </div>
                          <div class="col-12 col-sm-6 mt-4 mt-sm-2">
                            <label for="TypeOfEduId">Duration of Course</label>
                            <textarea name="time2" required rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $data[0]->time2 }}</textarea>
                          </div>
                          <div class="col-12 col-sm-6 mt-4 mt-sm-2">
                            <label for="TypeOfEduId">Difficulty Level</label>
                            <textarea name="difficulty2" required rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $data[0]->difficulty2 }}</textarea>
                          </div>
                          <div class="col-12 col-sm-6 mt-4 mt-sm-2">
                            <label for="TypeOfEduId">URL</label>
                            <textarea name="url2" required rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $data[0]->url2 }}</textarea>
                          </div>
                        </div>


                        <div class="three hide form-row col-12">
                          <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                              <label for="TypeOfEduId">Title 3</label>
                              <textarea name="title3" required rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $data[0]->title3 }}</textarea>
                          </div>
                          <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                              <label for="TypeOfEduId">Description 3</label>
                              <textarea name="description3" required rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $data[0]->description3 }}</textarea>
                          </div>
                          <div class="col-12 col-sm-6 mt-4 mt-sm-2">
                              <label for="TypeOfEduId">Image 3</label>
                              <input type="file" name="image3" class="form-control">
                          </div>
                          <div class="col-12 col-sm-6 mt-4 mt-sm-2">
                            <label for="TypeOfEduId">Duration of Course</label>
                            <textarea name="time3" required rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $data[0]->time3 }}</textarea>
                          </div>
                          <div class="col-12 col-sm-6 mt-4 mt-sm-2">
                            <label for="TypeOfEduId">Difficulty Level</label>
                            <textarea name="difficulty3" required rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $data[0]->difficulty3 }}</textarea>
                          </div>
                          <div class="col-12 col-sm-6 mt-4 mt-sm-2">
                            <label for="TypeOfEduId">URL</label>
                            <textarea name="url3" required rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $data[0]->url3 }}</textarea>
                          </div>
                        </div>


                        <div class="four hide form-row col-12">
                          <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                              <label for="TypeOfEduId">Title 4</label>
                              <textarea name="title4" required rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $data[0]->title4 }}</textarea>
                          </div>
                          <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                              <label for="TypeOfEduId">Description 4</label>
                              <textarea name="description4" required rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $data[0]->description4 }}</textarea>
                          </div>
                          <div class="col-12 col-sm-6 mt-4 mt-sm-2">
                              <label for="TypeOfEduId">Image 4</label>
                              <input type="file" name="image4" class="form-control">
                          </div>
                          <div class="col-12 col-sm-6 mt-4 mt-sm-2">
                            <label for="TypeOfEduId">Duration of Course</label>
                            <textarea name="time4" required rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $data[0]->time4 }}</textarea>
                          </div>
                          <div class="col-12 col-sm-6 mt-4 mt-sm-2">
                            <label for="TypeOfEduId">Difficulty Level</label>
                            <textarea name="difficulty4" required rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $data[0]->difficulty4 }}</textarea>
                          </div>
                          <div class="col-12 col-sm-6 mt-4 mt-sm-2">
                            <label for="TypeOfEduId">URL</label>
                            <textarea name="url4" required rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $data[0]->url4 }}</textarea>
                          </div>
                        </div>


                        <div class="five hide form-row col-12">
                          <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                              <label for="TypeOfEduId">Title 5</label>
                              <textarea name="title5" required rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $data[0]->title5 }}</textarea>
                          </div>
                          <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                              <label for="TypeOfEduId">Description 5</label>
                              <textarea name="description5" required rows="1" column="15" placeholder="Enter Details"
                                  class="form-control">{{ $data[0]->description5 }}</textarea>
                          </div>
                          <div class="col-12 col-sm-6 mt-4 mt-sm-2">
                              <label for="TypeOfEduId">Image 5</label>
                              <input type="file" name="image5" class="form-control">
                          </div>
                          <div class="col-12 col-sm-6 mt-4 mt-sm-2">
                            <label for="TypeOfEduId">Duration of Course</label>
                            <textarea name="time5" required rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $data[0]->time5 }}</textarea>
                          </div>
                          <div class="col-12 col-sm-6 mt-4 mt-sm-2">
                            <label for="TypeOfEduId">Difficulty Level</label>
                            <textarea name="difficulty5" required rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $data[0]->difficulty5 }}</textarea>
                          </div>
                          <div class="col-12 col-sm-6 mt-4 mt-sm-2">
                            <label for="TypeOfEduId">URL</label>
                            <textarea name="url5" required rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $data[0]->url5 }}</textarea>
                          </div>
                        </div>


                        <div class="six hide form-row col-12">
                          <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                              <label for="TypeOfEduId">Title 6</label>
                              <textarea name="title6" required rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $data[0]->title6 }}</textarea>
                          </div>
                          <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                              <label for="TypeOfEduId">Description 6</label>
                              <textarea name="description6" required rows="1" column="15" placeholder="Enter Details"
                                  class="form-control">{{ $data[0]->description6 }}</textarea>
                          </div>
                          <div class="col-12 col-sm-6 mt-4 mt-sm-2">
                              <label for="TypeOfEduId">Image 6</label>
                              <input type="file" name="image6" class="form-control">
                          </div>
                          <div class="col-12 col-sm-6 mt-4 mt-sm-2">
                            <label for="TypeOfEduId">Duration of Course</label>
                            <textarea name="time6" required rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $data[0]->time6 }}</textarea>
                          </div>
                          <div class="col-12 col-sm-6 mt-4 mt-sm-2">
                            <label for="TypeOfEduId">Difficulty Level</label>
                            <textarea name="difficulty6" required rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $data[0]->difficulty6 }}</textarea>
                          </div>
                          <div class="col-12 col-sm-6 mt-4 mt-sm-2">
                            <label for="TypeOfEduId">URL</label>
                            <textarea name="url6" required rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $data[0]->url6 }}</textarea>
                          </div>
                        </div>

                        </div>

                        <input type="hidden" name="id" value="{{ $data[0]->id }}">
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