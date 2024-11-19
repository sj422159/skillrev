@extends('controller/elayout')
@section('title', 'Assessment Section')
@section('Dashboard_select', 'active')
@section('container')

<div class="row">
    <div class="col-12">
        <div class="card" style="padding:10px !important;">

            <!-- Form1: For updating section order -->
            <form id="Form1" action="{{url('admin/saveassesments')}}" method="post">
                @csrf
                <div class="card-body" style="padding:10px !important; overflow: hidden;">
                    <div class="form-row">
                        <div class="col-12 col-sm-1 mt-4 mt-sm-0">
                            <button type="submit" class="btn btn-success" style="margin-bottom: 20px !important;margin-left: 10px !important;">
                                Submit
                            </button>
                        </div>
                    </div>
                </div>
            </form>

            <!-- Form2: For adding a new section -->
            <form id="Form2" action="{{url('admin/saveassesments')}}" method="post">
                @csrf
                <div class="card-body" style="padding:10px !important; overflow: hidden;">
                    <div class="form-row">
                        <div class="col-12 col-sm-1 mt-4 mt-sm-0">
                            <button type="submit" class="btn btn-primary">Add Section</button>
                        </div>
                    </div>

                    <!-- Section Name Field -->
                    <div class="form-row mt-4">
                        <div class="col-12 col-sm-2 mt-4 mt-sm-0">
                            <label for="branchname">Section Name :</label>
                            <input type="text" class="form-control" placeholder="Enter" name="sectionname" form="Form2" required>
                        </div>

                        <!-- Standard Dropdown -->
                        <div class="col-12 col-sm-2 mt-4 mt-sm-0">
                            <label>Standard :</label>
                            <select class="form-control" name="skillgroup" form="Form2" required>
                                @foreach($categories as $list)
                                    <option value="{{$list->id}}">{{$list->categories}}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Subject Dropdown -->
                        <div class="col-12 col-sm-2 mt-4 mt-sm-0">
                            <label>Subject :</label>
                            <select class="form-control" name="skillset[]" form="Form2" required>
                                @foreach($dname as $list)
                                    <option value="{{$list->id}}">{{$list->domain}}</option>
                                @endforeach
                            </select>
                        </div>

                        @if($trainingtype == "1")
                            <!-- Module Dropdown for Training Type 1 -->
                            <div class="col-12 col-sm-2 mt-4 mt-sm-0">
                                <label>Module :</label>
                                <select class="form-control" name="section[]" form="Form2" required>
                                    @foreach($skillsets as $list)
                                        <option value="{{$list->id}}">{{$list->skillset}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Chapter Dropdown -->
                            <div class="col-12 col-sm-2 mt-4 mt-sm-0">
                                <label>Chapter :</label>
                                <select class="form-control" name="chapter" form="Form2" required>
                                    @foreach($skillattributes as $list)
                                        <option value="{{$list->id}}">{{$list->skillattribute}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <input type="hidden" name="trainingtype" value="1" form="Form2">
                        @else
                            <!-- Multiple Module Dropdown for Training Type 2 -->
                            <div class="col-12 col-sm-2 mt-4 mt-sm-0">
                                <label>Module :</label>
                                <select class="form-control" name="section[]" form="Form2" multiple required>
                                    @foreach($skillsets as $list)
                                        <option value="{{$list->id}}">{{$list->skillset}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <input type="hidden" name="trainingtype" value="2" form="Form2">
                        @endif
                    </div>
                </div>
            </form>

            <!-- Table for Existing Sections -->
            <table id="simpleTable1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Section Name</th>
                        <th>Questions</th>
                        <th>Pass Percentage</th>
                        <th>Duration</th>
                        <th>Order</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sections as $list)
                        <tr>
                            <td>{{$list->sectionname}}</td>
                            <td>{{$list->totalquestions}}</td>
                            <td>{{$list->sectionpass}}</td>
                            <td>{{$list->sectionduration}}</td>
                            <td>
                                <input type="number" name="order[]" value="{{$list->ordering}}" form="Form1">
                                <input type="hidden" name="sectionid[]" value="{{$list->id}}" form="Form1">
                            </td>
                            <td>
                                <a href="{{url('admin/createsection')}}/{{$list->id}}">
                                    <button type="button" class="btn btn-success">Edit</button>
                                </a>
                                <a href="{{url('admin/assesment/section/delete')}}/{{$list->id}}">
                                    <button type="button" class="btn btn-danger">Delete</button>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
</div>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
// Your JavaScript logic (if any) can be placed here.
</script>

@endsection
