<!DOCTYPE html5>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://unpkg.com/tailwindcss@2.0.2/dist/tailwind.min.css" rel="stylesheet"></link>
    <link rel="shortcut icon" href="{{ asset('assets/img/favicon.png') }}" type="image/x-icon"></link>
    <title>School LMS</title>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" ></link>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" ></link>

    <link href="https://fonts.googleapis.com/css?family=Montserrat:100,200,300,400,500,600,700,800,900"
        rel="stylesheet"></link>

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('webpages/college/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet"></link>

    <!-- Mobile Image Slider CSS Files -->
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="{{ asset('webpages/college/assets/css/fontawesome.css') }}"></link>
    <link rel="stylesheet" href="{{ asset('webpages/college/assets/css/templatemo-grad-school.css') }}"></link>
    <link rel="stylesheet" href="{{ asset('webpages/college/assets/css/owl.css') }}"></link>
    <link rel="stylesheet" href="{{ asset('webpages/college/assets/css/lightbox.css') }}"></link>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet"></link>
    <link href="{{ asset('css/style.css') }}" rel="stylesheet"></link>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"></link>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

    {{-- Testimonials --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <link href="{{ asset('css/testimonial.css') }}" rel="stylesheet"></link>

    {{-- Steps --}}
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <style>
        .my_theme {
            background-color: rgb(2 6 23);
        }
    </style>

<style>
    .mySlides {display:none;}
</style>

</head>


<body><!----> <!---->

    <header class="main-header">
        <div class="navbar px-2 py-2 mx-auto w-full md:px-24 lg:px-8">
            <h2 class="brand font-bold tracking-tight text-white font-size:48px">
                <a>
                    <i class="fa-solid fa-graduation-cap" style="color: orange; font-size:100%"></i>
                    SkillRevelation-SMS
                </a>
            </h2>
            <nav id="menu" class="main-nav">
                <ul class="main-menu">
                  <li><a href="#section1">Features</a></li>
                  <li><a href="#section2">Steps</a></li>
                  <li><a href="#section3">Schools</a></li>
                  <li><a href="#section4">Tutorial</a></li>
                  <li><a href="#section5">Testimonial</a></li>
                  <li><a href="#section6">Contact</a></li>
                </ul>
            </nav>

            <div class="toggle_btn">
                {{-- <i class="fa-solid fa-bars"></i> --}}
                <span class="material-symbols-outlined">
                    apps
                    </span>
            </div>
        </div>

        <div class="dropdown_menu">
            <li><a href="/">Home</a></li>
            <li><a href="{{ url('/courses') }}">Courses</a></li>
            <li><a href="{{ url('/job-roles') }}">Activities</a></li>
            <li><a href="{{ url('/login') }}" class="action_btn">Sign In</a></li>
        </div>

    </header>

    <script>
        const toggleBtn = document.querySelector('.toggle_btn')
        const toggleBtnIcon = document.querySelector('.toggle_btn i')
        const dropDownMenu = document.querySelector('.dropdown_menu')

        toggleBtn.onclick = function() {

            dropDownMenu.classList.toggle('open')
            const isOpen = dropDownMenu.classList.contains('open')

            toggleBtnIcon.classList = isOpen

                ?
                'fa-solid fa-bars' :
                'fa-solid fa-bars'

        }

        document.addEventListener('click', function(event)
        {
            const isClickInside = dropDownMenu.contains(event.target) || toggleBtn.contains(event.target);
            if (!isClickInside && dropDownMenu.classList.contains('open'))
            {
                dropDownMenu.classList.remove('open');
                toggleBtnIcon.classList = 'fa-solid fa-bars';
            }
        });
    </script>

    <main>
        <ul class='sliders'>
            <li class="items" style="background-image: url({{ asset('storage/' . $slide[0]->image1) }})">
                <div class='contents'>
                    <h2 style="line-height: 105px">{{ $slide[0]->title1 }}</h2>
                    <p style="font-size:25px; line-height:25px"> {{ $slide[0]->description1 }} </p>

                </div>
            </li>
            <li class='items' style="background-image: url({{ asset('storage/' . $slide[0]->image2) }})">
                <div class='contents'>
                    <h2 style="line-height: 105px">{{ $slide[0]->title2 }}</h2>
                    <p style="font-size:25px; line-height:25px"> {{ $slide[0]->description2 }} </p>

                </div>
            </li>
            <li class='items' style="background-image: url({{ asset('storage/' . $slide[0]->image3) }})">
                <div class='contents'>
                    <h2 style="line-height: 105px">{{ $slide[0]->title3 }}</h2>
                    <p style="font-size:25px; line-height:25px"> {{ $slide[0]->description3 }} </p>

                </div>
            </li>
            <li class='items' style="background-image: url({{ asset('storage/' . $slide[0]->image4) }})">
                <div class='contents'>
                    <h2 style="line-height: 105px">{{ $slide[0]->title4 }}</h2>
                    <p style="font-size:25px; line-height:25px"> {{ $slide[0]->description4 }} </p>

                </div>
            </li>
            <li class='items' style="background-image: url({{ asset('storage/' . $slide[0]->image5) }})">
                <div class='contents'>
                    <h2 style="line-height: 105px">{{ $slide[0]->title5 }}</h2>
                    <p style="font-size:25px; line-height:25px"> {{ $slide[0]->description5 }} </p>

                </div>
            </li>
            <li class='items' style="background-image: url({{ asset('storage/' . $slide[0]->image6) }})">
                <div class='contents'>
                    <h2 style="line-height: 105px">{{ $slide[0]->title6 }}</h2>
                    <p style="font-size:25px; line-height:25px"> {{ $slide[0]->description6 }} </p>

                </div>
            </li>
            <li class='items' style="background-image: url({{ asset('storage/' . $slide[0]->image7) }})">
                <div class='contents'>
                    <h2 style="line-height: 105px">{{ $slide[0]->title7 }}</h2>
                    <p style="font-size:25px; line-height:25px"> {{ $slide[0]->description7 }} </p>

                </div>
            </li>
            <li class='items' style="background-image: url({{ asset('storage/' . $slide[0]->image8) }})">
                <div class='contents'>
                    <h2 style="line-height: 105px">{{ $slide[0]->title8 }}</h2>
                    <p style="font-size:25px; line-height:25px"> {{ $slide[0]->description8 }} </p>

                </div>
            </li>
            <li class='items' style="background-image: url({{ asset('storage/' . $slide[0]->image9) }})">
                <div class='contents'>
                    <h2 style="line-height: 105px">{{ $slide[0]->title9 }}</h2>
                    <p style="font-size:25px; line-height:25px"> {{ $slide[0]->description9 }} </p>

                </div>
            </li>
            <li class='items' style="background-image: url({{ asset('storage/' . $slide[0]->image10) }})">
                <div class='contents'>
                    <h2 style="line-height: 105px">{{ $slide[0]->title10 }}</h2>
                    <p style="font-size:25px; line-height:25px"> {{ $slide[0]->description10 }} </p>

                </div>
            </li>

        </ul>
        <nav class='nav'>
            <ion-icon class='btn prev' name="arrow-back-outline"></ion-icon>
            <ion-icon class='btn next' name="arrow-forward-outline"></ion-icon>
        </nav>
    </main>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script>
        const slider = document.querySelector('.sliders');
        let autoSlideInterval;

        function activate(e)
        {
            const items = document.querySelectorAll('.items');
            e.target.matches('.next') && slider.append(items[0])
            e.target.matches('.prev') && slider.prepend(items[items.length-1]);
        }

        function activateAutoSlide()
        {
            autoSlideInterval = setInterval(function()
            {
                const items = document.querySelectorAll('.items');
                slider.append(items[0]);
            }, 3000); // Change image every 3 seconds (3000 milliseconds)
        }

        // Call the activateAutoSlide function to start automatic sliding
        activateAutoSlide();

        // Stop automatic sliding when user interacts with the slider
        slider.addEventListener('mouseenter', function()
        {
            clearInterval(autoSlideInterval);
        });

        slider.addEventListener('mouseleave', function()
        {
            activateAutoSlide();
        });

        document.addEventListener('click', activate, false);
    </script>


{{--Responsive Image Sliders for width: 1318px and below --}}

@include('views_latest.partials._mobile_image_slider')

<section class="section features" data-section="section1">
    <div class="px-4 py-16 mx-auto w-full md:px-24 lg:px-8 lg:py-20">
        <div class="mainhead max-w-2xl mb-10 sm:text-center">
            <h2 class="max-w-2xl mx-auto mb-6 font-sans text-4xl font-bold leading-none tracking-tight text-white sm:text-5xl md:mx-auto">
            {{-- <h2 class="max-w-lg mb-6 font-sans text-3xl font-bold leading-none tracking-tight text-white sm:text-4xl md:mx-auto"> --}}
                {{ $event[0]->mainhead }}
            </h2>
            <p style="font-weight: 600 !important" class="text-base text-white md:text-lg">
                {{ $event[0]->descrip }}
            </p>
        </div>

        <div class="contentx">
            <!-- card -->
            <div class="cards">

                <div class="icon"><i class="material-icons md-36">person</i></div>
                <p class="title">{{ $event[0]->title1 }}</p>
                <p class="text">
                    {{ $event[0]->description1 }}
                </p>

            </div>
            <!-- end card -->
            <!-- card -->
            <div class="cards">

                <div class="icon"><i class="material-icons md-36">school</i></div>
                <p class="title">
                    {{ $event[0]->title2 }}
                </p>
                <p class="text">
                    {{ $event[0]->description2 }}
                </p>

            </div>
            <!-- end card -->
            <!-- card -->
            <div class="cards">

                <div class="icon">
                    <i class="material-icons md-36">sensor_occupied</i>
                </div>
                <p class="title">{{ $event[0]->title3 }}</p>
                <p class="text">
                    {{ $event[0]->description3 }}
                </p>

            </div>
            <!-- end card -->
            <div class="cards">

                <div class="icon"><i class="material-icons md-36">handshake</i></div>
                <p class="title">{{ $event[0]->title4 }}</p>
                <p class="text">
                    {{ $event[0]->description4 }}
                </p>

            </div>


        </div>
    </div>
</section>

    {{-- Steps --}}

    <section class = "section steps step_section" data-section="section2">
        <div class="steps">
        <div class="swiper">
            <div class="col-md-12">
                <div class="section-heading">
                    <h2>Steps</h2>
                </div>
            </div>
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <div class="swiper-slide-img">
                        <img src="{{ asset('storage/' . $data[0]->image1) }}" alt="">
                        <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120"
                            preserveAspectRatio="none">
                            <path
                                d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z"
                                opacity=".25" class="shape-fill"></path>
                            <path
                                d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z"
                                opacity=".5" class="shape-fill"></path>
                            <path
                                d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z"
                                class="shape-fill"></path>
                        </svg>
                    </div>
                    <div class="swiper-slide-content">
                        <div>
                            <h2>Step-1</h2>
                            <p>
                                {{ $data[0]->step1 }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="swiper-slide-img">
                        <img src="{{ asset('storage/' . $data[0]->image2) }}" alt="">
                        <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120"
                            preserveAspectRatio="none">
                            <path
                                d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z"
                                opacity=".25" class="shape-fill"></path>
                            <path
                                d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z"
                                opacity=".5" class="shape-fill"></path>
                            <path
                                d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z"
                                class="shape-fill"></path>
                        </svg>
                    </div>
                    <div class="swiper-slide-content">
                        <div>
                            <h2>Step-2</h2>
                            <p>
                                {{ $data[0]->step2 }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="swiper-slide-img">
                        <img src="{{ asset('storage/' . $data[0]->image3) }}" alt="">
                        <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120"
                            preserveAspectRatio="none">
                            <path
                                d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z"
                                opacity=".25" class="shape-fill"></path>
                            <path
                                d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z"
                                opacity=".5" class="shape-fill"></path>
                            <path
                                d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z"
                                class="shape-fill"></path>
                        </svg>
                    </div>
                    <div class="swiper-slide-content">
                        <div>
                            <h2>Step-3</h2>
                            <p>
                                {{ $data[0]->step3 }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="swiper-slide-img">
                        <img src="{{ asset('storage/' . $data[0]->image4) }}" alt="">
                        <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120"
                            preserveAspectRatio="none">
                            <path
                                d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z"
                                opacity=".25" class="shape-fill"></path>
                            <path
                                d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z"
                                opacity=".5" class="shape-fill"></path>
                            <path
                                d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z"
                                class="shape-fill"></path>
                        </svg>
                    </div>
                    <div class="swiper-slide-content">
                        <div>
                            <h2>Step-4</h2>
                            <p>
                                {{ $data[0]->step4 }}
                            </p>
                        </div>
                    </div>
                </div>
                @if ($data[0]->step5 != null)
                <div class="swiper-slide">
                    <div class="swiper-slide-img">
                        <img src="{{ asset('storage/' . $data[0]->image5) }}" alt="">
                        <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120"
                            preserveAspectRatio="none">
                            <path
                                d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z"
                                opacity=".25" class="shape-fill"></path>
                            <path
                                d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z"
                                opacity=".5" class="shape-fill"></path>
                            <path
                                d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z"
                                class="shape-fill"></path>
                        </svg>
                    </div>
                    <div class="swiper-slide-content">
                        <div>
                            <h2>Step-5</h2>
                            <p>
                                {{ $data[0]->step5 }}
                            </p>
                        </div>
                    </div>
                </div>
                @endif

            </div>
        </div>





        <script>
            var swiper = new Swiper(".swiper", {
                effect: "coverflow",
                grabCursor: true,
                centeredSlides: true,
                coverflowEffect: {
                    rotate: 0,
                    stretch: 0,
                    depth: 100,
                    modifier: 2.5
                },
                keyboard: {
                    enabled: true
                },
                mousewheel: {
                    thresholdDelta: 70
                },
                spaceBetween: 30,
                loop: true,
                breakpoints: {
                    640: {
                        slidesPerView: 2
                    },
                    1024: {
                        slidesPerView: 3
                    }
                },
                initialSlide: 0
            });

            // swiper.slideTo(1, false, false);
        </script>






    </div>
    </section>

    <!----> <!----> <!----> <!----> <!----><!----> <!----> <!---->
    <div class="section_stats px-4 py-16 mx-auto w-full md:px-24 lg:px-8 lg:py-20">
        <div style="max-width: 90% !important" class="max-w-xl mb-10 md:mx-auto sm:text-center lg:max-w-2xl md:mb-12">
            <h2 class="max-w-lg mb-6 font-sans text-3xl font-bold leading-none tracking-tight text-white sm:text-4xl md:mx-auto">
                {{ $stats[0]->title }}
            </h2>
        </div>
        <div class="stats_border max-w-6xl mx-auto grid grid-cols-1 row-gap-8 md:grid-cols-4">
            <div class="text-center md:border-r border-gray-800">
                <h6 class="text-4xl font-bold lg:text-5xl xl:text-6xl  text-white">
                    {{ $stats[0]->{'No-1'} }}
                </h6>
                <p class="text-sm font-medium tracking-widest text-white uppercase lg:text-base">
                    {{ $stats[0]->{'label-1'} }}
                </p>
            </div>
            <div class="text-center md:border-r border-gray-800">
                <h6 class="text-4xl font-bold lg:text-5xl xl:text-6xl  text-white">
                    {{ $stats[0]->{'No-2'} }}
                </h6>
                <p class="text-sm font-medium tracking-widest text-white uppercase lg:text-base">
                    {{ $stats[0]->{'label-2'} }}
                </p>
            </div>
            <div class="text-center md:border-r border-gray-800">
                <h6 class="text-4xl font-bold lg:text-5xl xl:text-6xl  text-white">
                    {{ $stats[0]->{'No-3'} }}
                </h6>
                <p class="text-sm font-medium tracking-widest text-white uppercase lg:text-base">
                    {{ $stats[0]->{'label-3'} }}
                </p>
            </div>
            <div class="text-center">
                <h6 class="text-4xl font-bold lg:text-5xl xl:text-6xl  text-white">
                    {{ $stats[0]->{'No-4'} }}
                </h6>
                <p class="text-sm font-medium tracking-widest text-white uppercase lg:text-base">
                    {{ $stats[0]->{'label-4'} }}
                </p>
            </div>
        </div>
    </div> <!----> <!----><!----> <!----> <!----> <!----> <!----> <!----> <!----> <!----> <!----> <!---->

    <section class="section courses" data-section="section3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-heading">
                        <h2>Schools</h2>
                    </div>
                </div>

                <div class="owl-carousel owl-theme; container">
                    @foreach ($schools as $list)
                        <div class="card">
                            <div class="face face1">
                                <div class="content">
                                    <img src="{{ asset('adminimages') }}/{{ $list->image }}"
                                        alt="University Images">
                                    <h3>{{ $list->aname }}</h3>
                                </div>
                            </div>
                            <div class="face face2">
                                <div class="content">
                                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quas cum cumque
                                        minus iste veritatis provident at.</p>
                                    <a href="{{ $list->awebsitelink }}">Read More</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>


    <section class="section video" data-section="section4" style="margin-top: 80px">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-heading">
                        <h2>Tutorial</h2>
                    </div>
                </div>
                <div class="col-md-6 align-self-center">
                    <div class="left-content">
                        <span>our presentation for you</span>
                        <h4>Watch the video to learn more about:<br> <em>SKILLREVELATION-SMS</em></h4>
                    </div>
                </div>
                <div class="col-md-6">
                    <article class="video-item">
                        <div class="video-caption">
                            <h6>SKILLREVELATION-SMS LIFECYCLE</h6>
                        </div>
                        <figure>
                            <a href="https://www.youtube.com/watch?v=jC4R1IlPG74" class="play"><img
                                    src="{{ asset('assets/img/courses/3.jpg') }}"></a>
                        </figure>
                    </article>
                </div>
            </div>
        </div>
    </section>


    <section class="section coming-soon testimonial text-center" data-section="section5">
        <div class="col-md-12" style="margin-top: 120px">
            <div class="section-heading">
                <h2>Testimonials</h2>
            </div>
        </div>
        <div class="container" style="margin-top: 100px">
            <div id="testimonial4"
                style="width: 73%;background: rgba(255, 255, 255, 0.75);border-radius: 20px;box-shadow: -6px 6px 6px rgba(0, 0, 0, 0.23);margin-left: 14%;"
                class="carousel slide testimonial4_indicators testimonial4_control_button thumb_scroll_x swipe_x"
                data-ride="carousel" data-pause="hover" data-interval="5000" data-duration="2000">

                <div class="carousel-inner" role="listbox">
                    <div class="carousel-item active">
                        <div class="testimonial4_slide">
                            <img src="{{ asset('storage/' . $test[0]->image1) }}" class="img-circle img-responsive" />
                            <h4>{{ $test[0]->name1 }}</h4>
                            <h3>{{ $test[0]->jobrole1 }}</h3>
                            <p>{{ $test[0]->desc1 }} </p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="testimonial4_slide">
                            <img src="{{ asset('storage/' . $test[0]->image2) }}" class="img-circle img-responsive" />
                            <h4>{{ $test[0]->name2 }}</h4>
                            <h3>{{ $test[0]->jobrole2 }}</h3>
                            <p>{{ $test[0]->desc1 }}  </p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="testimonial4_slide">
                            <img src="{{ asset('storage/' . $test[0]->image3) }}" class="img-circle img-responsive" />
                            <h4>{{ $test[0]->name3 }}</h4>
                            <h3>{{ $test[0]->jobrole3 }} </h3>
                            <p>
                                {{ $test[0]->desc3 }}
                            </p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="testimonial4_slide">
                            <img src="{{ asset('storage/' . $test[0]->image4) }}" class="img-circle img-responsive" />
                            <h4>{{ $test[0]->name4 }}</h4>
                            <h3>{{ $test[0]->jobrole4 }} </h3>
                            <p>
                                {{ $test[0]->desc4 }}
                            </p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="testimonial4_slide">
                            <img src="{{ asset('storage/' . $test[0]->image5) }}" class="img-circle img-responsive" />
                            <h4>{{ $test[0]->name5 }}</h4>
                            <h3>{{ $test[0]->jobrole5 }} </h3>
                            <p>
                                {{ $test[0]->desc5 }}
                            </p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="testimonial4_slide">
                            <img src="{{ asset('storage/' . $test[0]->image6) }}" class="img-circle img-responsive" />
                            <h4>{{ $test[0]->name6 }}</h4>
                            <h3>{{ $test[0]->jobrole6 }} </h3>
                            <p>
                                {{ $test[0]->desc6 }}
                            </p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="testimonial4_slide">
                            <img src="{{ asset('storage/' . $test[0]->image7) }}" class="img-circle img-responsive" />
                            <h4>{{ $test[0]->name7 }}</h4>
                            <h3>{{ $test[0]->jobrole7 }} </h3>
                            <p>
                                {{ $test[0]->desc7 }}
                            </p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="testimonial4_slide">
                            <img src="{{ asset('storage/' . $test[0]->image8) }}" class="img-circle img-responsive" />
                            <h4>{{ $test[0]->name8 }}</h4>
                            <h3>{{ $test[0]->jobrole8 }} </h3>
                            <p>
                                {{ $test[0]->desc8 }}
                            </p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="testimonial4_slide">
                            <img src="{{ asset('storage/' . $test[0]->image9) }}" class="img-circle img-responsive" />
                            <h4>{{ $test[0]->name9 }}</h4>
                            <h3>{{ $test[0]->jobrole9 }} </h3>
                            <p>
                                {{ $test[0]->desc9 }}
                            </p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="testimonial4_slide">
                            <img src="{{ asset('storage/' . $test[0]->image10) }}" class="img-circle img-responsive" />
                            <h4>{{ $test[0]->name10 }}</h4>
                            <h3>{{ $test[0]->jobrole10 }} </h3>
                            <p>
                                {{ $test[0]->desc10 }}
                            </p>
                        </div>
                    </div>
                </div>
                <a class="carousel-control-prev" href="#testimonial4" data-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </a>
                <a class="carousel-control-next" href="#testimonial4" data-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </a>
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

                    <form class="footer_form flex flex-col mt-4 md:flex-row" id="contact"
                        action="{{ url('contact') }}" method="post">
                        @csrf
                        <div class="row" style="position: relative">
                            <div class="col-md-6" style="margin-bottom: 15px">
                                <fieldset>
                                    <input name="name" type="text" class="form-control" id="name"
                                        placeholder="Your Name" required="">
                                </fieldset>
                            </div>
                            <div class="col-md-6" style="margin-bottom: 15px">
                                <fieldset>
                                    <input name="phone" type="text" class="form-control" id="name"
                                        placeholder="Your phone" required="">
                                </fieldset>
                            </div>
                            <div class="col-md-12" style="margin-bottom: 15px">
                                <fieldset>
                                    <input name="email" type="text" class="form-control" id="email"
                                        placeholder="Your Email" required="">
                                </fieldset>
                            </div>
                            <div class="col-md-12" style="margin-bottom: 15px">
                                <fieldset>
                                    <textarea name="message" rows="6" class="form-control" id="message" placeholder="Your message..."
                                        required=""></textarea>
                                </fieldset>
                            </div>
                            <div class="col-md-6" style="max-width: 46%">
                                <fieldset>
                                    <button
                                        class="inline-flex items-center justify-center h-12 px-6 font-medium tracking-wide text-white transition duration-200 rounded shadow-md bg-indigo-500 hover:bg-indigo-500 focus:shadow-outline focus:outline-none"
                                        type="submit" id="form-submit" class="button">Send Message
                                        Now</button>
                                </fieldset>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-6">
                    <div id="map">
                        <iframe style="margin-bottom: 20px;margin-top: 20px; border-radius: 10px"
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3744.0418480481894!2d85.7172992!3d20.215581999999998!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3a19a987bad663f7%3A0x1babd41fb0ae4fb1!2sSKILLREVELATION%20INDIA%20(OPC)%20PRIVATE%20LIMITED!5e0!3m2!1sen!2sin!4v1643641401818!5m2!1sen!2sin"
                            width="100%" height="400" style="border:0;" allowfullscreen=""
                            loading="lazy"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('views_latest.partials._footer')

    @include('views_latest.partials._mobile_footer')



    @if (session()->has('reg'))
        <script>
            swal({
                title: "Registered Successfully",
                text: "Thanks For Registering as College",
                icon: "success",
            });
        </script>
    @endif


    @if (session()->has('message'))
        <script>
            swal({
                title: "Message Sent Successfully",
                text: "Our Team Will Contact You Soon",
                icon: "success",
            });
        </script>
    @endif

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const menuButton = document.getElementById("menu-button");
            const dropdown = document.querySelector("[data-state='closed']");

            // Initially hide the dropdown
            dropdown.style.display = "none";
            dropdown.setAttribute("data-state", "closed");

            menuButton.addEventListener("click", function() {
                if (dropdown.getAttribute("data-state") === "closed") {
                    dropdown.style.display = "block";
                    dropdown.setAttribute("data-state", "open");
                } else {
                    dropdown.style.display = "none";
                    dropdown.setAttribute("data-state", "closed");
                }
            });

            // Close the dropdown if you click outside of it
            document.addEventListener("click", function(event) {
                if (!menuButton.contains(event.target) && !dropdown.contains(event.target)) {
                    dropdown.style.display = "none";
                    dropdown.setAttribute("data-state", "closed");
                }
            });
        });
    </script>
    <script src="{{ asset('webpages/college/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('webpages/college/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('webpages/college/assets/js/isotope.min.js') }}"></script>
    <script src="{{ asset('webpages/college/assets/js/owl-carousel.js') }}"></script>
    <script src="{{ asset('webpages/college/assets/js/lightbox.js') }}"></script>
    <script src="{{ asset('webpages/college/assets/js/tabs.js') }}"></script>
    <script src="{{ asset('webpages/college/assets/js/video.js') }}"></script>
    <script src="{{ asset('webpages/college/assets/js/slick-slider.js') }}"></script>
    <script src="{{ asset('webpages/college/assets/js/custom.js') }}"></script>

    {{-- Testimonials --}}


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
                        scrollTop: reqSectionPos
                    },
                    800);
            } else {
                $('body, html').scrollTop(reqSectionPos);
            }

        };

        var checkSection = function checkSection() {
            $('.section').each(function() {
                var
                    $this = $(this),
                    topEdge = $this.offset().top - 80,
                    bottomEdge = topEdge + $this.height(),
                    wScroll = $(window).scrollTop();
                if (topEdge < wScroll && bottomEdge > wScroll) {
                    var
                        currentId = $this.data('section'),
                        reqLink = $('a').filter('[href*=\\#' + currentId + ']');
                    lastActiveLink = reqLink;
                    reqLink.closest('li').addClass('active').
                    siblings().removeClass('active');
                }
            });
            if (lastActiveLink)
            {
              lastActiveLink.closest('li').removeClass('active');
            }
        };

        $('.main-menu, .scroll-to-section').on('click', 'a', function(e) {
            if ($(e.target).hasClass('external')) {
                return;
            }
            e.preventDefault();
            $('#menu').removeClass('active');
            showSection($(this).attr('href'), true);
        });

        $(window).scroll(function() {
            checkSection();
        });
    </script>
</body>

</html>
