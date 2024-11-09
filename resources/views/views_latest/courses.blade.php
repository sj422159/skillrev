<!DOCTYPE html5>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://unpkg.com/tailwindcss@2.0.2/dist/tailwind.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('assets/img/favicon.png') }}" type="image/x-icon">
    <title>School LMS</title>

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link href="https://fonts.googleapis.com/css?family=Montserrat:100,200,300,400,500,600,700,800,900"
        rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <!-- Bootstrap core CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">

    <link href="{{ asset('webpages/college/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="{{ asset('webpages/college/assets/css/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('webpages/college/assets/css/templatemo-grad-school.css') }}">
    <link rel="stylesheet" href="{{ asset('webpages/college/assets/css/owl.css') }}">
    <link rel="stylesheet" href="{{ asset('webpages/college/assets/css/lightbox.css') }}">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

</head>

<style>
    .my_theme {
        background-color: rgb(2 6 23);
    }
</style>

<body><!----> <!---->

    @include('views_latest.partials._navbar')

    <div class="container">
        <div class="shop-default shop-cards shop-tech">
            <div class="courses_list row">
                <div class="courses_block col-md-6">
                    <div class="block product no-border z-depth-2-top z-depth-2--hover">
                        <div class="block-image">
                            <a href="#">
                                <img src="{{ asset('storage/' . $data[0]->image1 ) }}" class="img-center">
                            </a>
                            <span class="product-ribbon product-ribbon-right product-ribbon--style-1 bg-blue text-uppercase">New</span>
                        </div>
                        <div class="block-body text-center">
                            <h3 class="heading heading-5 strong-600 text-capitalize">
                                <p class="label_text">
                                    {{$data[0]->title1}}
                                </p>
                            </h3>
                            <p class="product-description">
                                {{$data[0]->description1}}
                            </p>
                            <div class="product-colors mt-2">
                                <div class="color-switch float-wrapper" >
                                    <a style="background-color: rgb(0, 174, 255); padding: 4px; border-radius: 5px; color: white">{{ $data[0]->time1 }}</a>
                                    <a style="background-color: rgb(250, 43, 43); padding: 4px; border-radius: 5px; color: white" >{{ $data[0]->difficulty1 }}</a>
                                    <a href="{{ $data[0]->url1 }}" style="background-color: rgb(162, 0, 255); padding: 4px; border-radius: 5px; color: white">More Details</a>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

                <div class="col-md-6">
                    <div class="block product no-border z-depth-2-top z-depth-2--hover">
                        <div class="block-image">
                            <a href="#">
                                <img src="{{ asset('storage/' . $data[0]->image2 ) }}" class="img-center">
                            </a>
                            <span class="product-ribbon product-ribbon-right product-ribbon--style-1 bg-blue text-uppercase">New</span>
                        </div>

                        <div class="block-body text-center">
                            <h3 class="heading heading-5 strong-600 text-capitalize">
                                <p class="label_text">
                                    {{$data[0]->title2}}
                                </p>
                            </h3>
                             <p class="product-description">
                                {{$data[0]->description2}}
                            </p>
                            <div class="product-colors mt-2">
                                <div class="color-switch float-wrapper">
                                    <a style="background-color: rgb(0, 174, 255); padding: 4px; border-radius: 5px; color: white">{{ $data[0]->time2 }}</a>
                                    <a style="background-color: rgb(255, 166, 0); padding: 4px; border-radius: 5px; color: white">{{ $data[0]->difficulty2 }}</a>
                                    <a href="{{ $data[0]->url2 }}" style="background-color: rgb(162, 0, 255); padding: 4px; border-radius: 5px; color: white">More Details</a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>



                <div class="col-md-6">
                    <div class="block product no-border z-depth-2-top z-depth-2--hover">
                        <div class="block-image">
                            <a href="#">
                                <img src="{{ asset('storage/' . $data[0]->image3 ) }}" class="img-center">
                            </a>
                            <span class="product-ribbon product-ribbon-right product-ribbon--style-1 bg-blue text-uppercase">New</span>
                        </div>

                        <div class="block-body text-center">
                            <h3 class="heading heading-5 strong-600 text-capitalize">
                                <p class="label_text">
                                    {{$data[0]->title3}}
                                </p>
                            </h3>
                             <p class="product-description">
                                {{$data[0]->description3}}
                            </p>
                            <div class="product-colors mt-2">
                                <div class="color-switch float-wrapper">
                                    <a style="background-color: rgb(0, 174, 255); padding: 4px; border-radius: 5px; color: white">{{ $data[0]->time3 }}</a>
                                    <a style="background-color: rgb(14, 185, 36); padding: 4px; border-radius: 5px; color: white">{{ $data[0]->difficulty3 }}</a>
                                    <a href="{{ $data[0]->url3 }}" style="background-color: rgb(162, 0, 255); padding: 4px; border-radius: 5px; color: white">More Details</a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>



                <div class="col-md-6">
                    <div class="block product no-border z-depth-2-top z-depth-2--hover">
                        <div class="block-image">
                            <a href="#">
                                <img src="{{ asset('storage/' . $data[0]->image4 ) }}" class="img-center">
                            </a>
                            <span class="product-ribbon product-ribbon-right product-ribbon--style-1 bg-blue text-uppercase">New</span>
                        </div>

                        <div class="block-body text-center">
                            <h3 class="heading heading-5 strong-600 text-capitalize">
                                <p class="label_text">
                                    {{$data[0]->title4}}
                                </p>
                            </h3>
                             <p class="product-description">
                                {{$data[0]->description4}}
                            </p>
                            <div class="product-colors mt-2">
                                <div class="color-switch float-wrapper">
                                    <a style="background-color: rgb(0, 174, 255); padding: 4px; border-radius: 5px; color: white">{{ $data[0]->time4 }}</a>
                                    <a style="background-color: rgb(14, 185, 36); padding: 4px; border-radius: 5px; color: white">{{ $data[0]->difficulty4 }}</a>
                                    <a href="{{ $data[0]->url4 }}" style="background-color: rgb(162, 0, 255); padding: 4px; border-radius: 5px; color: white">More Details</a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>



                <div class="col-md-6">
                    <div class="block product no-border z-depth-2-top z-depth-2--hover">
                        <div class="block-image">
                            <a href="#">
                                <img src="{{ asset('storage/' . $data[0]->image5 ) }}" class="img-center">
                            </a>
                            <span class="product-ribbon product-ribbon-right product-ribbon--style-1 bg-blue text-uppercase">New</span>
                        </div>

                        <div class="block-body text-center">
                            <h3 class="heading heading-5 strong-600 text-capitalize">
                                <p class="label_text">
                                    {{$data[0]->title5}}
                                </p>
                            </h3>
                             <p class="product-description">
                                {{$data[0]->description5}}
                            </p>
                            <div class="product-colors mt-2">
                                <div class="color-switch float-wrapper">
                                    <a style="background-color: rgb(0, 174, 255); padding: 4px; border-radius: 5px; color: white">{{ $data[0]->time5 }}</a>
                                    <a style="background-color: rgb(250, 43, 43); padding: 4px; border-radius: 5px; color: white">{{ $data[0]->difficulty5 }}</a>
                                    <a href="{{ $data[0]->url5 }}" style="background-color: rgb(162, 0, 255); padding: 4px; border-radius: 5px; color: white">More Details</a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>




                <div class="col-md-6">
                    <div class="block product no-border z-depth-2-top z-depth-2--hover">
                        <div class="block-image">
                            <a href="#">
                                <img src="{{ asset('storage/' . $data[0]->image6 ) }}" class="img-center">
                            </a>
                            <span class="product-ribbon product-ribbon-right product-ribbon--style-1 bg-blue text-uppercase">New</span>
                        </div>

                        <div class="block-body text-center">
                            <h3 class="heading heading-5 strong-600 text-capitalize">
                                <p class="label_text">
                                    {{$data[0]->title6}}
                                </p>
                            </h3>
                             <p class="product-description">
                                {{$data[0]->description6}}
                            </p>
                            <div class="product-colors mt-2">
                                <div class="color-switch float-wrapper">
                                    <a style="background-color: rgb(0, 174, 255); padding: 4px; border-radius: 5px; color: white">{{ $data[0]->time6 }}</a>
                                    <a style="background-color: rgb(255, 166, 0); padding: 4px; border-radius: 5px; color: white">{{ $data[0]->difficulty6 }}</a>
                                    <a href="{{ $data[0]->url6 }}" style="background-color: rgb(162, 0, 255); padding: 4px; border-radius: 5px; color: white">More Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('views_latest.partials._footer')

    @include('views_latest.partials._mobile_footer')

</body>
</html>