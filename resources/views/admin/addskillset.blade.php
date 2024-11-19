@extends('controller/layout')
@section('title','Add Module')
@section('Dashboard_select','active')
@section('container')
<div class="row">
    <div class="col-6">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title" style="color:#fff !important;">Create</h3>
            </div>
            <form action="{{url('admin/skillset/saveskillset')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <!-- Group Selection -->
                    <div class="form-row">
                        <div class="col-12 col-sm-4 mt-2">
                            <label for="jobskill">Group</label>
                            <select name="groupid" id="mainbranch" class="form-control" aria-required="true" required>
                                <option value="">Select</option>
                                @foreach($groups as $group)
                                    <option value="{{ $group->id }}" {{ $skillset->groupid == $group->id ? 'selected' : '' }}>
                                        {{ $group->group }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
            
                        <!-- Category (Standard) Selection -->
                        <div class="col-12 col-sm-4 mt-2">
                            <label for="jobskill">Group</label>
                            <select name="groupid" id="mainbranch" class="form-control" aria-required="true" required>
                                <option value="">Select</option>
                                @foreach($groups as $group)
                                    <option value="{{ $group->id }}" {{ $skillset->groupid == $group->id ? 'selected' : '' }}>
                                        {{ $group->group }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
            
                        <!-- Domain (Subject) Selection -->
                        <div class="col-12 col-sm-4 mt-2">
                            <label for="branchname">Subject</label>
                            <select name="domain" id="childbranch" class="form-control" required>
                                <option value="">Select Subject</option>
                                @foreach($domain as $domains)
                                    <option value="{{ $domains->id }}" {{ $skillset->domain == $domains->id ? 'selected' : '' }}>
                                        {{ $domains->domain }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        </div>
            
                    <!-- Module Name -->
                    <div class="form-row mt-2">
                        <div class="col-12 mt-2">
                            <label for="jobrole">Module</label>
                            <input type="text" name="skillset" class="form-control" id="jobrole" placeholder="Enter Module Name"
                                   value="{{ old('skillset', $skillset->skillset) }}" required>
                        </div>
                        <input type="hidden" name="id" value="{{ $skillset->id }}">

                    </div>
                </div>
            
                <!-- Submit Button -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
            
    </div>
</div>
</div>



<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

   
@endsection