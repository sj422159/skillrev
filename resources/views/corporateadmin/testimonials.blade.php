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
                  Testimonials Details
                </h5>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
               <form action="{{url('corporateadmin/testimonials/save')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="mb-5">
                        <select class="div-toggle" data-target=".my_course" style="width:175px; float:right;">
                            <option selected>Select Testimonial</option>
                            <option value="1" data-show=".one">Testimonial 1</option>
                            <option value="2" data-show=".two">Testimonial 2</option>
                            <option value="3" data-show=".three">Testimonial 3</option>
                            <option value="4" data-show=".four">Testimonial 4</option>
                            <option value="5" data-show=".five">Testimonial 5</option>
                            <option value="6" data-show=".six">Testimonial 6</option>
                            <option value="7" data-show=".seven">Testimonial 7</option>
                            <option value="8" data-show=".eight">Testimonial 8</option>
                            <option value="9" data-show=".nine">Testimonial 9</option>
                            <option value="10" data-show=".ten">Testimonial 10</option>
                        </select>

                    </div>

                    <div class="my_course form-row mt-2">

                    <div class="one hide form-row col-12">
                      <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                          <label for="TypeOfEduId">Name 1</label>
                          <textarea name="name1" required rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $data[0]->name1 }}</textarea>
                      </div>
                      <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                          <label for="TypeOfEduId">Job-Role 1</label>
                          <textarea name="jobrole1" required rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $data[0]->jobrole1 }}</textarea>
                      </div>
                      <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                        <label for="TypeOfEduId">Description 1</label>
                        <textarea name="desc1" required rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $data[0]->desc1 }}</textarea>
                    </div>
                      <div class="col-12 col-sm-6 mt-4 mt-sm-2">
                          <label for="TypeOfEduId">Image 1</label>
                          <input type="file" name="image1" class="form-control">

                      </div>

                    </div>

                    <div class="two hide form-row col-12">
                        <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                            <label for="TypeOfEduId">Name 2</label>
                            <textarea name="name2" required rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $data[0]->name2 }}</textarea>
                        </div>
                        <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                            <label for="TypeOfEduId">Job-Role 2</label>
                            <textarea name="jobrole2" required rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $data[0]->jobrole2 }}</textarea>
                        </div>
                        <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                          <label for="TypeOfEduId">Description 2</label>
                          <textarea name="desc2" required rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $data[0]->desc2 }}</textarea>
                      </div>
                        <div class="col-12 col-sm-6 mt-4 mt-sm-2">
                            <label for="TypeOfEduId">Image 2</label>
                            <input type="file" name="image2" class="form-control">

                        </div>

                      </div>

                      <div class="three hide form-row col-12">
                        <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                            <label for="TypeOfEduId">Name 3</label>
                            <textarea name="name3" required rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $data[0]->name3 }}</textarea>
                        </div>
                        <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                            <label for="TypeOfEduId">Job-Role 3</label>
                            <textarea name="jobrole3" required rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $data[0]->jobrole3 }}</textarea>
                        </div>
                        <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                          <label for="TypeOfEduId">Description 3</label>
                          <textarea name="desc3" required rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $data[0]->desc3 }}</textarea>
                      </div>
                        <div class="col-12 col-sm-6 mt-4 mt-sm-2">
                            <label for="TypeOfEduId">Image 3</label>
                            <input type="file" name="image3" class="form-control">

                        </div>

                      </div>

                      <div class="four hide form-row col-12">
                        <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                            <label for="TypeOfEduId">Name 4</label>
                            <textarea name="name4" required rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $data[0]->name4 }}</textarea>
                        </div>
                        <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                            <label for="TypeOfEduId">Job-Role 4</label>
                            <textarea name="jobrole4" required rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $data[0]->jobrole4 }}</textarea>
                        </div>
                        <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                          <label for="TypeOfEduId">Description 4</label>
                          <textarea name="desc4" required rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $data[0]->desc4 }}</textarea>
                      </div>
                        <div class="col-12 col-sm-6 mt-4 mt-sm-2">
                            <label for="TypeOfEduId">Image 4</label>
                            <input type="file" name="image4" class="form-control">

                        </div>

                      </div>

                      <div class="five hide form-row col-12">
                        <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                            <label for="TypeOfEduId">Name 5</label>
                            <textarea name="name5" required rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $data[0]->name5 }}</textarea>
                        </div>
                        <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                            <label for="TypeOfEduId">Job-Role 5</label>
                            <textarea name="jobrole5" required rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $data[0]->jobrole5 }}</textarea>
                        </div>
                        <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                          <label for="TypeOfEduId">Description 5</label>
                          <textarea name="desc5" required rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $data[0]->desc5 }}</textarea>
                      </div>
                        <div class="col-12 col-sm-6 mt-4 mt-sm-2">
                            <label for="TypeOfEduId">Image 5</label>
                            <input type="file" name="image5" class="form-control">

                        </div>

                      </div>

                      <div class="six hide form-row col-12">
                        <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                            <label for="TypeOfEduId">Name 6</label>
                            <textarea name="name6" required rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $data[0]->name6 }}</textarea>
                        </div>
                        <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                            <label for="TypeOfEduId">Job-Role 6</label>
                            <textarea name="jobrole6" required rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $data[0]->jobrole6 }}</textarea>
                        </div>
                        <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                          <label for="TypeOfEduId">Description 6</label>
                          <textarea name="desc6" required rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $data[0]->desc6 }}</textarea>
                      </div>
                        <div class="col-12 col-sm-6 mt-4 mt-sm-2">
                            <label for="TypeOfEduId">Image 6</label>
                            <input type="file" name="image6" class="form-control">

                        </div>

                      </div>

                      <div class="seven hide form-row col-12">
                        <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                            <label for="TypeOfEduId">Name 7</label>
                            <textarea name="name7" required rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $data[0]->name7 }}</textarea>
                        </div>
                        <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                            <label for="TypeOfEduId">Job-Role 7</label>
                            <textarea name="jobrole7" required rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $data[0]->jobrole7 }}</textarea>
                        </div>
                        <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                          <label for="TypeOfEduId">Description 7</label>
                          <textarea name="desc7" required rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $data[0]->desc7 }}</textarea>
                      </div>
                        <div class="col-12 col-sm-6 mt-4 mt-sm-2">
                            <label for="TypeOfEduId">Image 7</label>
                            <input type="file" name="image7" class="form-control">

                        </div>

                      </div>

                      <div class="eight hide form-row col-12">
                        <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                            <label for="TypeOfEduId">Name 8</label>
                            <textarea name="name8" required rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $data[0]->name8 }}</textarea>
                        </div>
                        <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                            <label for="TypeOfEduId">Job-Role 8</label>
                            <textarea name="jobrole8" required rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $data[0]->jobrole8 }}</textarea>
                        </div>
                        <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                          <label for="TypeOfEduId">Description 8</label>
                          <textarea name="desc8" required rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $data[0]->desc8 }}</textarea>
                      </div>
                        <div class="col-12 col-sm-6 mt-4 mt-sm-2">
                            <label for="TypeOfEduId">Image 8</label>
                            <input type="file" name="image8" class="form-control">

                        </div>

                      </div>

                      <div class="nine hide form-row col-12">
                        <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                            <label for="TypeOfEduId">Name 9</label>
                            <textarea name="name9" required rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $data[0]->name9 }}</textarea>
                        </div>
                        <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                            <label for="TypeOfEduId">Job-Role 9</label>
                            <textarea name="jobrole9" required rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $data[0]->jobrole9 }}</textarea>
                        </div>
                        <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                          <label for="TypeOfEduId">Description 9</label>
                          <textarea name="desc9" required rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $data[0]->desc9 }}</textarea>
                      </div>
                        <div class="col-12 col-sm-6 mt-4 mt-sm-2">
                            <label for="TypeOfEduId">Image 9</label>
                            <input type="file" name="image9" class="form-control">

                        </div>

                      </div>

                      <div class="ten hide form-row col-12">
                        <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                            <label for="TypeOfEduId">Name 10</label>
                            <textarea name="name10" required rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $data[0]->name10 }}</textarea>
                        </div>
                        <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                            <label for="TypeOfEduId">Job-Role 10</label>
                            <textarea name="jobrole10" required rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $data[0]->jobrole10 }}</textarea>
                        </div>
                        <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                          <label for="TypeOfEduId">Description 10</label>
                          <textarea name="desc10" required rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $data[0]->desc10 }}</textarea>
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