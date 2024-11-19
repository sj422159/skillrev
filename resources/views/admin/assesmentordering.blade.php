@extends('controller/elayout')
@section('title','Assesment Ordering')
@section('Dashboard_select','active')
@section('container')
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <style>
    #sortable { list-style-type: none; margin: 0; padding: 0; width: 60%; }
    #sortable li { margin: 0 3px 3px 3px; padding: 0.4em; padding-left: 1.5em; font-size: 1.4em; height: 18px; }
    #sortable li span { position: absolute; margin-left: -1.3em; }
    input { background-color: #00000020; padding: 6px; }
  </style>

  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
    $(function() {
      $("#sortable").sortable();
      $("#sortable").disableSelection();
    });
  </script>

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body table-responsive p-0 col-11" style="margin-left:30px !important">
          <form method="POST" action="{{url('admin/createsection')}}">
            @csrf
            <input type="hidden" name="ass_id" value="{{$id}}">
            <table id="simpleTable1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Module</th>
                  <th>Chapter</th>
                  <th>No Of Questions</th>
                  <th>Difficulty Level</th>
                  <th>Timing (In Minutes)</th>
                </tr>
              </thead>
              <tbody id="sortable">
                @foreach($skill_arr as $key)
                  <tr>
                    <td>{{$subs[$count]}}</td>
                    <td>{{$key}}<input type="hidden" name="skr[]" value="{{$skillid[$count]}}"></td>
                    <td><input type="number" name="noquestions[]" required class="form-control"></td>
                    <td>
                      <select required class="form-control" name="level[]">
                        <option value="">Select</option>
                        @foreach($levels as $list)
                          <option value="{{$list->level}}" @if($level3[$count] == $list->level) selected @endif>{{$list->level}}</option>
                        @endforeach
                      </select>
                    </td>
                    <td><input type="number" name="time[]" required class="form-control" value="{{$time3[$count]}}" oninput="totaltime(this)"></td>
                  </tr>
                  @php $count++; @endphp
                @endforeach

                <tr>
                  <td>Total</td>
                  <td></td>
                  <td><input type="number" name="totalquestion" value="{{$totalquestions}}" required class="form-control"></td>
                  <td></td>
                  <td><input type="number" name="sectionduration" id="time" value="{{$sectionduration}}" required class="form-control"></td>
                </tr>
              </tbody>
            </table>

            <div class="col-12 col-sm-3 mt-4">
              <label for="TypeOfEduId">Pass Percentage :</label>
              <input type="number" max="100" class="form-control" value="{{$pass}}" name="pass">
            </div>

            <input type="hidden" name="sectionid" value="{{$sectionid}}">
            <input type="hidden" name="sectionname" value="{{$sectionname}}">
            <input type="hidden" name="skillset" value="{{$skillset}}">
            <input type="hidden" name="subskillset" value="{{$subskillset}}">
            <input type="hidden" name="skillgroup" value="{{$skillgroup}}">

            <button type="submit" class="btn btn-primary mt-4">Submit</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script type="text/javascript">
    function totaltime(that) {
      var x = that.value;
      var y = document.getElementById("time").value;
      var z = parseInt(x) + parseInt(y);
      document.getElementById("time").value = z;
    }
  </script>

@endsection
