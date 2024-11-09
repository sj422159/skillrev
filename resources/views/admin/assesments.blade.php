@extends('admin/layout')
@section('title','Assesments')
@section('Dashboard_select','active')
@section('container')
<div class="container-fluid">
    <div class="row" >
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex p-0">
                    <h3 class="card-title p-3"><a href="{{url('admin/assesment/createassesment')}}" class="btn btn-primary">Create</a></h3>
                    <ul class="nav nav-pills ml-auto p-2">
                        <!-- <li class="nav-item"><a class="nav-link active" href="#tab_1" data-toggle="tab">Fresher</a></li>
                            <li class="nav-item"><a class="nav-link" href="#tab_2" data-toggle="tab">Lateral</a></li> -->
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="table-responsive table--no-card m-b-30">
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Assesment Name</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <tbody>
                                                @foreach($data as $list)
                                                <tr>
                                                    <td>{{$list->assesmentname}}</td>
                                                    <td>
                                                        <a href="{{url('admin/assesment/edit')}}/{{$list->id}}"><button type="button" class="btn btn-success">Edit</button>
                                                        </a>
                                                        <a href="{{url('admin/assesment/delete')}}/{{$list->id}}"><button type="button" class="btn btn-danger">Delete</button>
                                                        </a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection