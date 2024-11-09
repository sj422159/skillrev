@extends('corporateadmin/layout')
@section('title', 'Highlights')
@section('home', 'active')
@section('container')

    <div class="row">
        <div class="col-11" style="margin:20px !important">
            <div class="card card-primary">
                <div class="card-header">
                    <h5 style="text-align:center !important;text-transform: uppercase;color: #fff!important;">
                        Stats Details
                    </h5>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ url('corporateadmin/stats/save') }}" method="post">
                    @csrf
                    <div class="card-body">
                        <div class="form-row mt-2">
                            <div class="col-12 col-sm-12 mt-4 mt-sm-0">
                                <label for="TypeOfEduId">Title</label>
                                <textarea name="title" required rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $data[0]->title }}</textarea>
                            </div>
                            <div class="col-12 col-sm-6 mt-4 mt-sm-3">
                                <label for="TypeOfEduId">Label 1</label>
                                <textarea name="label1" required rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $data[0]->{"label-1"} }}</textarea>
                            </div>
                            <div class="col-12 col-sm-6 mt-4 mt-sm-3">
                                <label for="TypeOfEduId">Numbers-1</label>
                                <textarea name="no1" required rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $data[0]->{"No-1"} }}</textarea>
                            </div>

                            <div class="col-12 col-sm-6 mt-4 mt-sm-3">
                                <label for="TypeOfEduId">Label 2</label>
                                <textarea name="label2" required rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $data[0]->{"label-2"} }}</textarea>
                            </div>
                            <div class="col-12 col-sm-6 mt-4 mt-sm-3">
                                <label for="TypeOfEduId">Numbers-2</label>
                                <textarea name="no2" required rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $data[0]->{"No-2"} }}</textarea>
                            </div>

                            <div class="col-12 col-sm-6 mt-4 mt-sm-3">
                                <label for="TypeOfEduId">Label 3</label>
                                <textarea name="label3" required rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $data[0]->{"label-3"} }}</textarea>
                            </div>
                            <div class="col-12 col-sm-6 mt-4 mt-sm-3">
                                <label for="TypeOfEduId">Numbers-3</label>
                                <textarea name="no3" required rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $data[0]->{"No-3"} }}</textarea>
                            </div>

                            <div class="col-12 col-sm-6 mt-4 mt-sm-3">
                                <label for="TypeOfEduId">Label 4</label>
                                <textarea name="label4" required rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $data[0]->{"label-4"} }}</textarea>
                            </div>
                            <div class="col-12 col-sm-6 mt-4 mt-sm-3">
                                <label for="TypeOfEduId">Numbers-4</label>
                                <textarea name="no4" required rows="1" column="15" placeholder="Enter Details" class="form-control">{{ $data[0]->{"No-4"} }}</textarea>
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
@endsection