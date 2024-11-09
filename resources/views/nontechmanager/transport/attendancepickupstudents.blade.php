@extends('nontechmanager/transport/layout') 
@section('title','Pickup Student') 
@section('Dashboard_select','active extra') 
@section('container') 
<style type="text/css"></style>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css">
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card" style="margin-top:20px">
                <div class="card-header d-flex p-0">
                    <h3 class="card-title p-3">Students</h3>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <form action="{{url('nontech/manager/attendence/pickup/save')}}" method="post">
                        @csrf
                        <div class="row">
                        <div class="col-12 col-sm-3 mt-2 mt-sm-0" style="display: flex;flex-direction: column;">
                        <label>Pickup-Departure</label>
                        <input type="time" class="form-control" required="true" name="pickupdeparturetime">  
                        </div>
                        <div class="col-12 col-sm-3 mt-2 mt-sm-0" style="display: flex;flex-direction: column;">
                        <label>Pickup-Arrival</label>
                        <input type="time" class="form-control" required="true" name="pickuparrivaltime">  
                        </div>
                        <div class="col-12 col-sm-3 mt-2 mt-sm-0" style="display: flex;flex-direction: column;">
                        <label>Pickup-Departure Delay</label>
                        <input type="text" class="form-control" value="No Delay" name="pickupdeparturereason">
                        </div>
                        <div class="col-12 col-sm-3 mt-2 mt-sm-0" style="display: flex;flex-direction: column;">
                        <label>Pickup-Arrival Delay</label>
                        <input type="text" class="form-control" value="No Delay" name="pickuparrivalreason">  
                        </div>
                        </div>
                        <input type="hidden" name="busroute" value="{{$busroute}}">
                        <div class="tab-pane active" id="tab_1">
                            <div class="table-responsive table" style="padding:20px">
                                <table id="example1" class="display nowrap" style="width:100%   ">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody> @php $count=1; @endphp @foreach($students as $list) 
                                        <tr class="tr-shadow">
                                            <td>{{$count}}</td>
                                            <td>{{$list->sname}} {{$list->slname}}</td>
                                            <input type="hidden" name="studentid[]" value="{{$list->id}}">
                                            <td>
                                            <div class="col-5 mt-4 mt-sm-0">
                                            <select id="sectors" name="attendance[]" type="text" class="form-control" aria-required="true" aria-invalid="false" required="true">
                                            <option Selected value="Present">Present</option>
                                            <option value="Absent">Absent</option>
                                            </select>    
                                            </div>
                                            </td>
                                        </tr> @php $count+=1 @endphp @endforeach 
                                    </tbody>
                                </table>
                                <div class="button-row d-flex mt-2" style="display:flex;align-items: center;justify-content: center;">
                                    @if(count($students)>0)
                                    <input type="submit" class="btn btn-sm btn-primary" value="Save"></input>
                                    @else
                                    <a href="{{url('nontech/manager/attendance')}}">
                                        <button type="button" class="btn btn-danger btn-sm">Back</button>
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                 </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src=" https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js" defer></script>
<script type="text/javascript" src=" https://cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.24/build/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.24/build/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.1/js/buttons.print.min.js"></script>
<script type="text/javascript">
    // $(document).ready(function() {
    //     $('#example1').DataTable({
    //         dom: 'Bfrtip',
    //         buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
    //     });
    // });
</script> 
@endsection