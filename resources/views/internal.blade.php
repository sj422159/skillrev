<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:100,200,300,400,500,600,700,800,900" rel="stylesheet">

    <title>SMS Portal</title>
    
    <!-- Bootstrap core CSS -->
    <link href="{{asset('webpages/college/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="{{asset('webpages/college/assets/css/fontawesome.css')}}">
    <link rel="stylesheet" href="{{asset('webpages/college/assets/css/templatemo-grad-school.css')}}">
    <link rel="stylesheet" href="{{asset('webpages/college/assets/css/owl.css')}}">
    <link rel="stylesheet" href="{{asset('webpages/college/assets/css/lightbox.css')}}">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

  </head>
  <style type="text/css">
     h2{
      font-size: 30px !important;
      font-weight: bold !important;
    }
  </style>

<body>

   
  <!--header-->
  <header class="main-header clearfix" role="header">
    <div class="logo">
      <a href="#"><em>SKILLREVELATION</em></a>
    </div>
    <a href="#menu" class="menu-link"><i class="fa fa-bars"></i></a>
    <nav id="menu" class="main-nav" role="navigation">
      <ul class="main-menu">
        <li><a href="#section4">School</a></li>
        <li><a href="#section15">Testimonial</a></li>
        <li><a href="#section5">Tutorial</a></li>
        <li><a href="#section6">Contact</a></li>
       
      </ul>
    </nav>
  </header>

  <!-- ***** Main Banner Area Start ***** -->
  <section class="section main-banner" id="top" data-section="section1">
      <video autoplay muted loop id="bg-video">
        <source src="assets/images/course-video.mp4" type="video/mp4" />
      </video>

      <div class="video-overlay header-text">
          <div class="caption">
              <h2><em>SKILLREVELATION</em> SMS</h2>
              <div class="main-button">
                  <div class="">
                  <a href="{{url('classteacher/login')}}">CLASS TEACHER LOGIN</a>
                  <a href="{{url('faculty/login')}}">FACULTY LOGIN</a>    
                  <a href="{{url('student/login')}}">STUDENT LOGIN</a>
                  </div>
              </div>
          </div>
      </div>
  </section>
  <!-- ***** Main Banner Area End ***** -->


  <section class="features">
    <div class="container">
      <div class="row">
        <div class="col-lg-4 col-12">
          <div class="features-post">
            <div class="features-content">
              <div class="content-show">
                <h4><i class="fa fa-pencil"></i>School Events</h4>
              </div>
              <div class="content-hide">
                <p>{{$event[0]->content}}</p>
               
            </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-12">
          <div class="features-post second-features">
            <div class="features-content">
              <div class="content-show">
                <h4><i class="fa fa-graduation-cap"></i>Special Events</h4>
              </div>
              <div class="content-hide">
                <p>{{$event[0]->content2}}</p>
              
            </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-12">
          <div class="features-post third-features">
            <div class="features-content">
              <div class="content-show">
                <h4><i class="fa fa-book"></i>Skillrevelation Events</h4>
              </div>
              <div class="content-hide">
                 <p>{{$event[0]->content3}}</p>
                
            </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="section why-us" data-section="section2">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="section-heading">
            <h2>WHY CHOOSE SKILLREVELATION-SMS ?</h2>
          </div>
        </div>
        <div class="col-md-12">
          <div id='tabs'>
            <ul>
              <li><a href='#tabs-1'>Eminent Performance Management Initiatives</a></li>
              <li><a href='#tabs-2'>Accomplishing The Student Learning Goals</a></li>
              <li><a href='#tabs-3'>Superlative School Management System</a></li>
             
            </ul>
             <section class='tabs-content'>
              <article id='tabs-1'>
                <div class="row">
                  <div class="col-md-4">
                    <img src="{{asset('adminimages/1633582750.png')}}" alt="" style="margin-top:70px">
                  </div>
                  <div class="col-md-8">
                    <h4>Eminent Performance Management Initiatives</h4>
                    <p>. Multi level Course Design Services to ensure the learning is adequate.</p>
                    <p>. Embolden Collaboration with parents through Student login portals.</p>
                    <p>. Automated Several routine tasks,such as fees due-date reminders etc.</p>
                    <p>. Empower the progress and completion of all Training,Assignment and Assesment.</p>
                    <p>. Smart Grading and Performance Enhancement through tracking at various levels.</p>
                    <p>. Insightful reports and analytics at various levels.</p>
                  </div>
                </div>
              </article>
              <article id='tabs-2'>
                <div class="row">
                  <div class="col-md-4">
                     <img src="{{asset('adminimages/1633580740.jpg')}}" alt="" style="margin-top:70px">
                  </div>
                  <div class="col-md-8">
                    <h4>Accomplishing The Student Learning Goals</h4>  
                    <p>. Multi level Login Portals for Administartor,Teacher and Students.</p>
                    <p>. Optimized Staff Scheduling and Class Scheduling For Students.</p>
                    <p>. Effective Leave Management for Staff and Operative Class Re-scheduling for Students.</p>
                    <p>. Centralised Curiculum and Content Management Services.</p>
                    <p>. Making Quizzes For Assesment and innovative Assignment Management for students.</p>
                    <p>. Well Organized Transport and Logistics Management for Staff and Students.</p>
                  </div>
                </div>
              </article>
              <article id='tabs-3'>
                <div class="row">
                  <div class="col-md-4">
                    <img src="{{asset('adminimages/1633583837.jpg')}}" alt="" style="margin-top:70px">
                  </div>
                  <div class="col-md-8">
                    <h4>Superlative School Management System</h4>
                    <p>. Automated Student's access to the Training Content and Curriculum.</p>
                    <p>. Online Assesment with detailed Performance Report and Grading System.</p>
                    <p>. Integration of virtual classroom and expert solutions.</p>
                    <p>. Extra-Class Service For Academic Weaker Students.</p>
                    <p>. Stake-Ranking of Students and Certification. </p>
                    <p>. Student self-enrollment for various Optional Training programs.</p>        
                  </div>
                </div>
              </article>
            </section>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="section coming-soon" data-section="section15">
    <div class="container">
      <div class="row">
        <div class="col-md-12 col-xs-12">
          <div class="continer centerIt">
            <div>
               <h4>Looking for a Complete School Management System<br>  
                <em>Become a part of our SKILLREVELATION-SMS</em></h4>
              <div class="counter">

                <div class="days">
                  <div class="va">228</div>
                  <span>STUDENTS</span>
                </div>

                <div class="hours">
                  <div class="val">56</div>
                  <span>TECH STAFF</span>
                </div>

                <div class="minutes">
                  <div class="val">38</div>
                  <span>ADMIN STAFF</span>
                </div>

                <div class="seconds">
                  <div class="val">2</div>
                  <span>SCHOOLS</span>
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="section courses" data-section="section4">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="section-heading">
            <h2>SCHOOLS</h2>
          </div>
        </div>
        <div class="owl-carousel owl-theme">
          @foreach($schools as $list)
          <div class="item">
            <img src="{{asset('adminimages')}}/{{$list->image}}" style="height:100px !important;" alt="University Images">
            <div class="down-content">
              <h4>{{$list->aname}}</h4>
              <a href="{{$list->awebsitelink}}" target="_blank" class="btn btn-primary btn-sm">Know More</a>   
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </section>

  <section class="section video" data-section="section5">
    <div class="container">
      <div class="row">
        <div class="col-md-6 align-self-center">
          <div class="left-content">
            <span>our presentation is for you</span>
            <h4>Watch the video to learn more about:<br>  <em>SKILLREVELATION-SMS..</em></h4>
           
          
            
        </div>
      </div>
        <div class="col-md-6">
          <article class="video-item">
            <div class="video-caption">
              <h6>SKILLREVELATION-SMS LIFECYCLE</h6>
            </div>
            <figure>
              <a href="https://www.youtube.com/watch?v=jC4R1IlPG74" class="play"><img src="{{asset('assets/img/courses/3.jpg')}}"></a>
            </figure>
          </article>
        </div>
      </div>
    </div>
  </section>

  <section class="section contact" data-section="section6">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="section-heading">
            <h2>Let’s Keep In Touch</h2>
          </div>
        </div>
        <div class="col-md-6">
        
        <!-- Do you need a working HTML contact-form script?
                  
                    Please visit https://templatemo.com/contact page -->
                    
          <form id="contact" action="{{url('internal/contact')}}" method="post">
            @csrf
            <div class="row">
              <div class="col-md-6">
                  <fieldset>
                    <input name="name" type="text" class="form-control" id="name" placeholder="Your Name" required="">
                  </fieldset>
                </div>
                <div class="col-md-6">
                  <fieldset>
                    <input name="phone" type="text" class="form-control" id="name" placeholder="Your phone" required="">
                  </fieldset>
                </div>
                <div class="col-md-12">
                  <fieldset>
                    <input name="email" type="text" class="form-control" id="email" placeholder="Your Email" required="">
                  </fieldset>
                </div>
              <div class="col-md-12">
                <fieldset>
                  <textarea name="message" rows="6" class="form-control" id="message" placeholder="Your message..." required=""></textarea>
                </fieldset>
              </div>
              <div class="col-md-12">
                <fieldset>
                  <button type="submit" id="form-submit" class="button">Send Message Now</button>
                </fieldset>
              </div>
            </div>
          </form>
        </div>
        <div class="col-md-6">
          <div id="map">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3744.0418480481894!2d85.7172992!3d20.215581999999998!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3a19a987bad663f7%3A0x1babd41fb0ae4fb1!2sSKILLREVELATION%20INDIA%20(OPC)%20PRIVATE%20LIMITED!5e0!3m2!1sen!2sin!4v1643641401818!5m2!1sen!2sin" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
          </div>
        </div>
      </div>
    </div>
  </section>

  <footer>
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <p><i class="fa fa-copyright"></i> Copyright 2022 by Skillrevelation India 
        </div>
      </div>
    </div>
  </footer>
  @if(session()->has('reg'))
        <script>
           swal({
           title:"Registered Successfully",
           text: "Thanks For Registering as College",
           icon: "success",
           });
        </script>
        @endif


          @if(session()->has('message'))
        <script>
           swal({
           title:"Message Sent Successfully",
           text: "Our Team Will Contact You Soon",
           icon: "success",
           });
        </script>
        @endif

  <!-- Scripts -->
  <!-- Bootstrap core JavaScript -->
    <script src="{{asset('webpages/college/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('webpages/college/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

    <script src="{{asset('webpages/college/assets/js/isotope.min.js')}}"></script>
    <script src="{{asset('webpages/college/assets/js/owl-carousel.js')}}"></script>
    <script src="{{asset('webpages/college/assets/js/lightbox.js')}}"></script>
    <script src="{{asset('webpages/college/assets/js/tabs.js')}}"></script>
    <script src="{{asset('webpages/college/assets/js/video.js')}}"></script>
    <script src="{{asset('webpages/college/assets/js/slick-slider.js')}}"></script>
    <script src="{{asset('webpages/college/assets/js/custom.js')}}"></script>
    <script>
        //according to loftblog tut
        $('.nav li:first').addClass('active');

        var showSection = function showSection(section, isAnimate) {
          var
          direction = section.replace(/#/, ''),
          reqSection = $('.section').filter('[data-section="' + direction + '"]'),
          reqSectionPos = reqSection.offset().top - 0;

          if (isAnimate) {
            $('body, html').animate({
              scrollTop: reqSectionPos },
            800);
          } else {
            $('body, html').scrollTop(reqSectionPos);
          }

        };

        var checkSection = function checkSection() {
          $('.section').each(function () {
            var
            $this = $(this),
            topEdge = $this.offset().top - 80,
            bottomEdge = topEdge + $this.height(),
            wScroll = $(window).scrollTop();
            if (topEdge < wScroll && bottomEdge > wScroll) {
              var
              currentId = $this.data('section'),
              reqLink = $('a').filter('[href*=\\#' + currentId + ']');
              reqLink.closest('li').addClass('active').
              siblings().removeClass('active');
            }
          });
        };

        $('.main-menu, .scroll-to-section').on('click', 'a', function (e) {
          if($(e.target).hasClass('external')) {
            return;
          }
          e.preventDefault();
          $('#menu').removeClass('active');
          showSection($(this).attr('href'), true);
        });

        $(window).scroll(function () {
          checkSection();
        });
    </script>
     
</body>
</html>