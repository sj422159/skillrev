@extends('corporateadmin/layout')
@section('title','View Content')
@section('home','active')
@section('container')

<div class="row">
    <div class="col-12">
        <div class="card card-primary">
            <div class="card-header">
                <h4 style="text-align:center !important;color: #fff;text-transform:uppercase;">{{$skill[0]->skillattribute}}</h4>
            </div>
              <div class="card-body" style="padding:30px">

                <div class="form-row mt-4">
                    <div class="col-12 col-sm-10 mt-4 mt-sm-0">
                        <label for="jobskill">Content Type</label>
                        <select id="contenttype1" name="contenttype1" type="text" class="form-control" aria-required="true" aria-invalid="false" required="true">
                            <option value="">Select</option>
                            @foreach($contenttypes1 as $list)
                            @if($type1==$list->id)
                            <option selected value="{{$list->id}}">{{$list->contenttype}}</option>
                            @else
                            <option value="{{$list->id}}">{{$list->contenttype}}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                   
                    @if($id>0 && $type1=="1")
                    <div class="col-12 col-sm-2 mt-4 mt-sm-0">
                        <label for="jobskill">File</label><br>
                        <a href="{{url('content/type1')}}/{{$content1}}" target="_blank" class="btn btn-primary">View</a>
                    </div>
                    @else
                    <div class="col-12 col-sm-2 mt-4 mt-sm-0">
                        <label for="jobskill">Action</label><br>
                        <a href="#" target="_blank" class="btn btn-primary disabled">View</a>
                    </div>
                    @endif
                </div>

                <div class="form-row mt-4">
                    <div class="col-12 col-sm-10 mt-4 mt-sm-0">
                        <label for="jobskill">Content Type</label>
                        <select id="contenttype2" name="contenttype2" type="text" class="form-control" aria-required="true" aria-invalid="false">
                            <option value="">Select</option>
                            @foreach($contenttypes2 as $list)
                            @if($type2==$list->id)
                            <option selected value="{{$list->id}}">{{$list->contenttype}}</option>
                            @else
                            <option value="{{$list->id}}">{{$list->contenttype}}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                    
                    @if($id>0 && $type2=="2")
                    <div class="col-12 col-sm-2 mt-4 mt-sm-0">
                        <label for="jobskill">File</label><br>
                        <a href="{{url('content/type2')}}/{{$content2}}" target="_blank" class="btn btn-primary">View</a>
                    </div>
                    @else
                    <div class="col-12 col-sm-2 mt-4 mt-sm-0">
                        <label for="jobskill">Action</label><br>
                        <a href="#" target="_blank" class="btn btn-primary disabled">View</a>
                    </div>
                    @endif
                </div>

                <div class="form-row mt-4">
                    <div class="col-12 col-sm-10 mt-4 mt-sm-0">
                        <label for="jobskill">Content Type</label>
                        <select id="contenttype3" name="contenttype3" type="text" class="form-control" aria-required="true" aria-invalid="false">
                            <option value="">Select</option>
                            @foreach($contenttypes3 as $list)
                            @if($type3==$list->id)
                            <option selected value="{{$list->id}}">{{$list->contenttype}}</option>
                            @else
                            <option value="{{$list->id}}">{{$list->contenttype}}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                   
                    @if($id>0 && $type3=="3")
                    <div class="col-12 col-sm-2 mt-4 mt-sm-0">
                        <label for="jobskill">Video</label><br>
                        <a href="{{$content3}}" target="_blank" class="btn btn-primary">View</a>
                    </div>
                    @else
                    <div class="col-12 col-sm-2 mt-4 mt-sm-0">
                        <label for="jobskill">Action</label><br>
                        <a href="#" target="_blank" class="btn btn-primary disabled">View</a>
                    </div>
                    @endif
                </div>

                <div class="form-row mt-4">
                    <div class="col-12 col-sm-10 mt-4 mt-sm-0">
                        <label for="jobskill">Content Type</label>
                        <select id="contenttype4" name="contenttype4" type="text" class="form-control" aria-required="true" aria-invalid="false">
                            <option value="">Select</option>
                            @foreach($contenttypes4 as $list)
                            @if($type4==$list->id)
                            <option selected value="{{$list->id}}">{{$list->contenttype}}</option>
                            @else
                            <option value="{{$list->id}}">{{$list->contenttype}}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                   
                    @if($id>0 && $type4=="4")
                    <div class="col-12 col-sm-2 mt-4 mt-sm-0">
                        <label for="jobskill">Video</label><br>
                        <a href="{{$content4}}" target="_blank" class="btn btn-primary">View</a>
                    </div>
                    @else
                    <div class="col-12 col-sm-2 mt-4 mt-sm-0">
                        <label for="jobskill">Action</label><br>
                        <a href="#" target="_blank" class="btn btn-primary disabled">View</a>
                    </div>
                    @endif
                </div>
                
               
        </div>
    
    </div>
</div>
</div>




<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script type="text/javascript">
    
     
    </script>

@endsection