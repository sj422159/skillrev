@extends('corporateadmin/layout')
@section('title','Dashboard')
@section('dashboard_select','active')
@section('container')
<style type="text/css">
  .inner h3,p{
    color: #fff;
  }
</style>
    @if(session()->has('success'))
  <div class="sufee-alert alert with-close alert-success alert-dismissible fade show">
                      <span class="badge badge-pill badge-success"></span>
                      {{session('success')}}
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                      </button>
  </div>
    @endif
    <!-- Main content -->
    <section class="content" style="margin-top:10px;">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box"style="background-image: linear-gradient(to right,darkblue,blue);">
              <div class="inner">
                <h3> {{count($schools)}} </h3>
                <p>User Details</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="{{url('corporateadmin/school/list')}}" class="small-box-footer">More Info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box"style="background-image: linear-gradient(to right,darkblue,blue);">
              <div class="inner">
                <h3>0</h3>
                <p>Content</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="{{url('corporateadmin/content/data')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box"style="background-image: linear-gradient(to right,darkblue,blue);">
              <div class="inner">
                <h3>0</h3>
                <p>Question Bank</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="{{url('corporateadmin/questions/data')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box" style="background-image: linear-gradient(to right,darkblue,blue);">
              <div class="inner">
                <h3>0</h3>
                <p>Assignment</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="{{url('corporateadmin/assignment/data')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->
        
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box"style="background-image: linear-gradient(to right,darkgreen,green);">
              <div class="inner">
                <h3>{{$totalmarketing}}</h3>

                <p>Marketing Team</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="{{url('corporateadmin/marketing/details')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box"style="background-image: linear-gradient(to right,darkgreen,green);">
              <div class="inner">
                <h3>0</h3>
                <p>Support Team</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box"style="background-image: linear-gradient(to right,darkgreen,green);">
              <div class="inner">
                <h3>0</h3>
                <p>SME Team</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box"style="background-image: linear-gradient(to right,darkgreen,green);">
              <div class="inner">
                <h3>0</h3>
                <p>Content Team</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row-->


        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box"style="background-image:linear-gradient(to right,#283048,#859398);">
              <div class="inner">
                <h3>0</h3>
                <p>TBD</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box"style="background-image:linear-gradient(to right,#283048,#859398);">
              <div class="inner">
                <h3>0</h3>
                <p>TBD</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box"style="background-image:linear-gradient(to right,#283048,#859398);">
              <div class="inner">
                <h3>0</h3>
                <p>TBD</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
         
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box"style="background-image:linear-gradient(to right,#283048,#859398);">
              <div class="inner">
                <h3>0</h3>
                <p>TBD</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
         <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box"style="background-image:linear-gradient(to right,red,orange);">
              <div class="inner">
                <h3>0</h3>
                <p>TBD</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box"style="background-image:linear-gradient(to right,red,orange);">
              <div class="inner">
                <h3>0</h3>
                <p>TBD</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box"style="background-image:linear-gradient(to right,red,orange);">
              <div class="inner">
                <h3>0</h3>
                <p>TBD</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box"style="background-image:linear-gradient(to right,red,orange);">
              <div class="inner">
                <h3>0</h3>
                <p>TBD</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row-->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection