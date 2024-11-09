@extends('corporateadmin/layout')
@section('title','Hightlights')
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
                  Slideshow Details
                </h5>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
               <form action="{{url('corporateadmin/slideshow/save')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="mb-5">
                        <select class="div-toggle" data-target=".my_course" style="width:175px; float:right;">
                            <option selected>Select Slideshow</option>
                            <option value="1" data-show=".one">Slideshow 1</option>
                            <option value="2" data-show=".two">Slideshow 2</option>
                            <option value="3" data-show=".three">Slideshow 3</option>
                            <option value="4" data-show=".four">Slideshow 4</option>
                            <option value="5" data-show=".five">Slideshow 5</option>
                            <option value="6" data-show=".six">Slideshow 6</option>
                            <option value="7" data-show=".seven">Slideshow 7</option>
                            <option value="8" data-show=".eight">Slideshow 8</option>
                            <option value="9" data-show=".nine">Slideshow 9</option>
                            <option value="10" data-show=".ten">Slideshow 10</option>
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
                        <textarea name="description1" required rows="2" column="15" placeholder="Enter Details" class="form-control">{{ $data[0]->description1 }}</textarea>
                    </div>
                      <div class="col-12 col-sm-6 mt-4 mt-sm-2">
                          <label for="TypeOfEduId">Image 1</label>
                          <input type="file" name="image1" class="form-control">

                      </div>

                    </div>

                    <div class="two hide form-row col-12">
                        <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                            <label for="TypeOfEduId">Title 2</label>
                            <textarea name="title2" required rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $data[0]->title2 }}</textarea>
                        </div>
                        <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                          <label for="TypeOfEduId">Description 2</label>
                          <textarea name="description2" required rows="2" column="15" placeholder="Enter Details" class="form-control">{{ $data[0]->description2 }}</textarea>
                      </div>
                        <div class="col-12 col-sm-6 mt-4 mt-sm-2">
                            <label for="TypeOfEduId">Image 2</label>
                            <input type="file" name="image2" class="form-control">

                        </div>

                      </div>

                      <div class="three hide form-row col-12">
                        <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                            <label for="TypeOfEduId">Title 3</label>
                            <textarea name="title3" required rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $data[0]->title3 }}</textarea>
                        </div>
                        <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                          <label for="TypeOfEduId">Description 3</label>
                          <textarea name="description3" required rows="2" column="15" placeholder="Enter Details" class="form-control">{{ $data[0]->description3 }}</textarea>
                      </div>
                        <div class="col-12 col-sm-6 mt-4 mt-sm-2">
                            <label for="TypeOfEduId">Image 3</label>
                            <input type="file" name="image3" class="form-control">

                        </div>

                      </div>

                      <div class="four hide form-row col-12">
                        <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                            <label for="TypeOfEduId">Title 4</label>
                            <textarea name="title4" required rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $data[0]->title4 }}</textarea>
                        </div>
                        <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                          <label for="TypeOfEduId">Description 4</label>
                          <textarea name="description4" required rows="2" column="15" placeholder="Enter Details" class="form-control">{{ $data[0]->description4 }}</textarea>
                      </div>
                        <div class="col-12 col-sm-6 mt-4 mt-sm-2">
                            <label for="TypeOfEduId">Image 4</label>
                            <input type="file" name="image4" class="form-control">

                        </div>

                      </div>

                      <div class="five hide form-row col-12">
                        <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                            <label for="TypeOfEduId">Title 5</label>
                            <textarea name="title5" required rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $data[0]->title5 }}</textarea>
                        </div>
                        <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                          <label for="TypeOfEduId">Description 5</label>
                          <textarea name="description5" required rows="2" column="15" placeholder="Enter Details" class="form-control">{{ $data[0]->description5 }}</textarea>
                      </div>
                        <div class="col-12 col-sm-6 mt-4 mt-sm-2">
                            <label for="TypeOfEduId">Image 5</label>
                            <input type="file" name="image5" class="form-control">

                        </div>

                      </div>

                      <div class="six hide form-row col-12">
                        <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                            <label for="TypeOfEduId">Title 6</label>
                            <textarea name="title6" required rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $data[0]->title6 }}</textarea>
                        </div>
                        <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                          <label for="TypeOfEduId">Description 6</label>
                          <textarea name="description6" required rows="2" column="15" placeholder="Enter Details" class="form-control">{{ $data[0]->description6 }}</textarea>
                      </div>
                        <div class="col-12 col-sm-6 mt-4 mt-sm-2">
                            <label for="TypeOfEduId">Image 6</label>
                            <input type="file" name="image6" class="form-control">

                        </div>

                      </div>

                      <div class="seven hide form-row col-12">
                        <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                            <label for="TypeOfEduId">Title 7</label>
                            <textarea name="title7" required rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $data[0]->title7 }}</textarea>
                        </div>
                        <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                          <label for="TypeOfEduId">Description 7</label>
                          <textarea name="description7" required rows="2" column="15" placeholder="Enter Details" class="form-control">{{ $data[0]->description7 }}</textarea>
                      </div>
                        <div class="col-12 col-sm-6 mt-4 mt-sm-2">
                            <label for="TypeOfEduId">Image 7</label>
                            <input type="file" name="image7" class="form-control">

                        </div>

                      </div>

                      <div class="eight hide form-row col-12">
                        <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                            <label for="TypeOfEduId">Title 8</label>
                            <textarea name="title8" required rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $data[0]->title8 }}</textarea>
                        </div>
                        <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                          <label for="TypeOfEduId">Description 8</label>
                          <textarea name="description8" required rows="2" column="15" placeholder="Enter Details" class="form-control">{{ $data[0]->description8 }}</textarea>
                      </div>
                        <div class="col-12 col-sm-6 mt-4 mt-sm-2">
                            <label for="TypeOfEduId">Image 8</label>
                            <input type="file" name="image8" class="form-control">

                        </div>

                      </div>

                      <div class="nine hide form-row col-12">
                        <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                            <label for="TypeOfEduId">Title 9</label>
                            <textarea name="title9" required rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $data[0]->title9 }}</textarea>
                        </div>
                        <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                          <label for="TypeOfEduId">Description 9</label>
                          <textarea name="description9" required rows="2" column="15" placeholder="Enter Details" class="form-control">{{ $data[0]->description9 }}</textarea>
                      </div>
                        <div class="col-12 col-sm-6 mt-4 mt-sm-2">
                            <label for="TypeOfEduId">Image 9</label>
                            <input type="file" name="image9" class="form-control">

                        </div>

                      </div>

                      <div class="ten hide form-row col-12">
                        <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                            <label for="TypeOfEduId">Title 10</label>
                            <textarea name="title10" required rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $data[0]->title10 }}</textarea>
                        </div>
                        <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                          <label for="TypeOfEduId">Description 10</label>
                          <textarea name="description10" required rows="2" column="15" placeholder="Enter Details" class="form-control">{{ $data[0]->description10 }}</textarea>
                      </div>
                        <div class="col-12 col-sm-6 mt-4 mt-sm-2">
                            <label for="TypeOfEduId">Image 10</label>
                            <input type="file" name="image10" class="form-control">

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