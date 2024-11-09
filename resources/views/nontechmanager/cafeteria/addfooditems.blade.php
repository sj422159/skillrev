@extends('nontechmanager/cafeteria/layout')
@section('title','Food Items Create')
@section('Dashboard_select','active')
@section('container')
<div class="row">
    <div class="col-6">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title" style="color:#fff !important;">Create Food Items</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{url('nontech/manager/food/saveitems')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                      <div class="form-group">
                         <label>Food Category</label>
                          <select class="form-control" aria-required="true" aria-invalid="false" name="category" id="category">
                           <option value="">Select</option>
                           @foreach($categories as $list)
                           @if($foodcategory==$list->id)
                            <option value="{{$list->id}}" selected>{{$list->foodcategory}}</option>
                           @else
                                <option value="{{$list->id}}">{{$list->foodcategory}}</option>
                                @endif
                           @endforeach 
                       </select>
                    </div>
                    <div class="form-group">
                        <label for="jobhostel">Item Name</label>
                        <input type="text" class="form-control" id="jobhostel" required="true" placeholder="Enter Category Name" name="items" value="{{$fooditem}}">
                    </div>
                     <div class="form-group">
                         <label>Price Type</label>
                          <select class="form-control" aria-required="true" aria-invalid="false" name="ptype" id="category">
                           <option value="">Select</option>
                           @foreach($ptypes as $list)
                            @if($ptype==$list->id)
                                <option value="{{$list->id}}" selected>{{$list->ptype}}</option>
                                @else
                                 <option value="{{$list->id}}" >{{$list->ptype}}</option>
                                @endif
                           @endforeach 
                       </select>
                    </div>
                      <div class="form-group">
                        <label for="jobhostel">Price</label>
                        <input type="number" class="form-control" id="jobhostel" required="true" placeholder="Enter Price" name="price" value="{{$price}}">
                    </div>

                    <input type="hidden" name="id" value="{{$id}}">
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
        </div>
        </form>
    </div>
</div>
</div>
@endsection