<!DOCTYPE html5>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
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

{{-- <style type="text/css">
    h2 {
        font-size: 30px !important;
        font-weight: bold !important;
    }
</style> --}}

<style>
    .my_theme {
        background-color: rgb(2 6 23);
    }
</style>

<body>

    @include('views_latest.partials._navbar')

    <div class="container">
        <div class="shop-default shop-cards shop-tech">
            <div class="jobrole_list row">
                <div class="jobrole_block col-md-6">
                    <div class="block product no-border z-depth-2-top z-depth-2--hover">
                        <div class="block-image">
                            <a href="#">
                                <img src="{{ asset('storage/' . $data[0]->image1 ) }}" class="img-center">
                            </a>
                            {{-- <span class="product-ribbon product-ribbon-right product-ribbon--style-1 bg-blue text-uppercase">New</span> --}}
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
                                <div class="color-switch float-wrapper">
                                    @if ($data[0]->skillset1 != NULL)
                                        <a style="background-color: rgb(255, 0, 76); padding: 4px; border-radius: 5px; color: white; font-weight: bold">{{ $data[0]->skillset1 }}</a>
                                    @endif

                                    @if ($s2[0]->skillset1 != NULL)
                                        <a style="background-color: rgb(255, 0, 76); padding: 4px; border-radius: 5px; color: white; font-weight: bold">{{ $s2[0]->skillset1 }}</a>
                                    @endif

                                    @if ($s3[0]->skillset1 != NULL)
                                         <a style="background-color: rgb(255, 0, 76); padding: 4px; border-radius: 5px; color: white; font-weight: bold">{{ $s3[0]->skillset1 }}</a>
                                    @endif

                                    @if ($s4[0]->skillset1 != NULL)
                                         <a style="background-color: rgb(255, 0, 76); padding: 4px; border-radius: 5px; color: white; font-weight: bold">{{ $s4[0]->skillset1 }}</a>
                                    @endif

                                    @if ($s5[0]->skillset1 != NULL)
                                         <a style="background-color: rgb(255, 0, 76); padding: 4px; border-radius: 5px; color: white; font-weight: bold">{{ $s5[0]->skillset1 }}</a>
                                    @endif

                                    <a href="{{ $data[0]->url1 }}" style="background-color: rgb(162, 0, 255); padding: 4px; margin:1% ;border-radius: 5px; color: white; font-weight: bold">More Details</a>
                                    {{-- <a href="#" class="bg-blue"></a> --}}
                                </div>
                            </div>
                            {{-- <div class="product-buttons mt-4">
                                <div class="row align-items-center">
                                    <div class="col-2">
                                        <button type="button" class="btn-icon" data-toggle="tooltip" data-placement="top" title="" data-original-title="Favorite">
                                            <i class="fa fa-heart"></i>
                                        </button>
                                    </div>
                                    <div class="col-2">
                                        <button type="button" class="btn-icon" data-toggle="tooltip" data-placement="top" title="" data-original-title="Compare">
                                            <i class="fa fa-share"></i>
                                        </button>
                                    </div>
                                    <div class="col-8">
                                        <button type="button" class="btn btn-block btn-primary btn-circle btn-icon-left">
                                            <i class="fa fa-shopping-cart"></i>Add to cart
                                        </button>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>

                </div>

                <div class="col-md-6">
                    <div class="block product no-border z-depth-2-top z-depth-2--hover">
                        <div class="block-image">
                            <a href="#">
                                <img src="{{ asset('storage/' . $data[0]->image2 ) }}" class="img-center">
                            </a>
                            {{-- <span class="product-ribbon product-ribbon-right product-ribbon--style-1 bg-blue text-uppercase">New</span> --}}
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
                                    @if ($data[0]->skillset2 != NULL)
                                        <a style="background-color: rgb(255, 0, 76); padding: 4px; border-radius: 5px; color: white; font-weight: bold">{{ $data[0]->skillset2 }}</a>
                                    @endif

                                    @if ($s2[0]->skillset2 != NULL)
                                        <a style="background-color: rgb(255, 0, 76); padding: 4px; border-radius: 5px; color: white; font-weight: bold">{{ $s2[0]->skillset2 }}</a>
                                    @endif

                                    @if ($s3[0]->skillset2 != NULL)
                                         <a style="background-color: rgb(255, 0, 76); padding: 4px; border-radius: 5px; color: white; font-weight: bold">{{ $s3[0]->skillset2 }}</a>
                                    @endif

                                    @if ($s4[0]->skillset2 != NULL)
                                         <a style="background-color: rgb(255, 0, 76); padding: 4px; border-radius: 5px; color: white; font-weight: bold">{{ $s4[0]->skillset2 }}</a>
                                    @endif

                                    @if ($s5[0]->skillset2 != NULL)
                                         <a style="background-color: rgb(255, 0, 76); padding: 4px; border-radius: 5px; color: white; font-weight: bold">{{ $s5[0]->skillset2 }}</a>
                                    @endif

                                    <a href="{{ $data[0]->url2 }}" style="background-color: rgb(162, 0, 255); padding: 4px; margin:1% ; border-radius: 5px; color: white; font-weight: bold">More Details</a>
                                    {{-- <a href="#" class="bg-blue"></a> --}}
                                </div>
                            </div>
                            {{--
                            <div class="product-buttons mt-4">
                                <div class="row align-items-center">
                                    <div class="col-2">
                                        <button type="button" class="btn-icon" data-toggle="tooltip" data-placement="top" title="" data-original-title="Favorite">
                                            <i class="fa fa-heart"></i>
                                        </button>
                                    </div>
                                    <div class="col-2">
                                        <button type="button" class="btn-icon" data-toggle="tooltip" data-placement="top" title="" data-original-title="Compare">
                                            <i class="fa fa-share"></i>
                                        </button>
                                    </div>
                                    <div class="col-8">
                                        <button type="button" class="btn btn-block btn-primary btn-circle btn-icon-left">
                                            <i class="fa fa-shopping-cart"></i>Add to cart
                                        </button>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>



                <div class="col-md-6">
                    <div class="block product no-border z-depth-2-top z-depth-2--hover">
                        <div class="block-image">
                            <a href="#">
                                <img src="{{ asset('storage/' . $data[0]->image3 ) }}" class="img-center">
                            </a>
                            {{-- <span class="product-ribbon product-ribbon-right product-ribbon--style-1 bg-blue text-uppercase">New</span> --}}
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
                                    @if ($data[0]->skillset3 != NULL)
                                        <a style="background-color: rgb(255, 0, 76); padding: 4px; border-radius: 5px; color: white; font-weight: bold">{{ $data[0]->skillset3 }}</a>
                                    @endif

                                    @if ($s2[0]->skillset3 != NULL)
                                        <a style="background-color: rgb(255, 0, 76); padding: 4px; border-radius: 5px; color: white; font-weight: bold">{{ $s2[0]->skillset3 }}</a>
                                    @endif

                                    @if ($s3[0]->skillset3 != NULL)
                                         <a style="background-color: rgb(255, 0, 76); padding: 4px; border-radius: 5px; color: white; font-weight: bold">{{ $s3[0]->skillset3 }}</a>
                                    @endif

                                    @if ($s4[0]->skillset3 != NULL)
                                         <a style="background-color: rgb(255, 0, 76); padding: 4px; border-radius: 5px; color: white; font-weight: bold">{{ $s4[0]->skillset3 }}</a>
                                    @endif

                                    @if ($s5[0]->skillset3 != NULL)
                                         <a style="background-color: rgb(255, 0, 76); padding: 4px; border-radius: 5px; color: white; font-weight: bold">{{ $s5[0]->skillset3 }}</a>
                                    @endif

                                    <a href="{{ $data[0]->url3 }}" style="background-color: rgb(162, 0, 255); padding: 4px; margin:1% ; border-radius: 5px; color: white; font-weight: bold">More Details</a>
                                    {{-- <a href="#" class="bg-blue"></a> --}}
                                </div>
                            </div>
                            {{--
                            <div class="product-buttons mt-4">
                                <div class="row align-items-center">
                                    <div class="col-2">
                                        <button type="button" class="btn-icon" data-toggle="tooltip" data-placement="top" title="" data-original-title="Favorite">
                                            <i class="fa fa-heart"></i>
                                        </button>
                                    </div>
                                    <div class="col-2">
                                        <button type="button" class="btn-icon" data-toggle="tooltip" data-placement="top" title="" data-original-title="Compare">
                                            <i class="fa fa-share"></i>
                                        </button>
                                    </div>
                                    <div class="col-8">
                                        <button type="button" class="btn btn-block btn-primary btn-circle btn-icon-left">
                                            <i class="fa fa-shopping-cart"></i>Add to cart
                                        </button>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>



                <div class="col-md-6">
                    <div class="block product no-border z-depth-2-top z-depth-2--hover">
                        <div class="block-image">
                            <a href="#">
                                <img src="{{ asset('storage/' . $data[0]->image4 ) }}" class="img-center">
                            </a>
                            {{-- <span class="product-ribbon product-ribbon-right product-ribbon--style-1 bg-blue text-uppercase">New</span> --}}
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
                                    @if ($data[0]->skillset4 != NULL)
                                        <a style="background-color: rgb(255, 0, 76); padding: 4px; border-radius: 5px; color: white; font-weight: bold">{{ $data[0]->skillset4 }}</a>
                                    @endif

                                    @if ($s2[0]->skillset4 != NULL)
                                        <a style="background-color: rgb(255, 0, 76); padding: 4px; border-radius: 5px; color: white; font-weight: bold">{{ $s2[0]->skillset4 }}</a>
                                    @endif

                                    @if ($s3[0]->skillset4 != NULL)
                                         <a style="background-color: rgb(255, 0, 76); padding: 4px; border-radius: 5px; color: white; font-weight: bold">{{ $s3[0]->skillset4 }}</a>
                                    @endif

                                    @if ($s4[0]->skillset4 != NULL)
                                         <a style="background-color: rgb(255, 0, 76); padding: 4px; border-radius: 5px; color: white; font-weight: bold">{{ $s4[0]->skillset4 }}</a>
                                    @endif

                                    @if ($s5[0]->skillset4 != NULL)
                                         <a style="background-color: rgb(255, 0, 76); padding: 4px; border-radius: 5px; color: white; font-weight: bold">{{ $s5[0]->skillset4 }}</a>
                                    @endif

                                    <a href="{{ $data[0]->url4 }}" style="background-color: rgb(162, 0, 255); padding: 4px; margin:1% ; border-radius: 5px; color: white; font-weight: bold">More Details</a>
                                    {{-- <a href="#" class="bg-blue"></a> --}}
                                </div>
                            </div>
                            {{--
                            <div class="product-buttons mt-4">
                                <div class="row align-items-center">
                                    <div class="col-2">
                                        <button type="button" class="btn-icon" data-toggle="tooltip" data-placement="top" title="" data-original-title="Favorite">
                                            <i class="fa fa-heart"></i>
                                        </button>
                                    </div>
                                    <div class="col-2">
                                        <button type="button" class="btn-icon" data-toggle="tooltip" data-placement="top" title="" data-original-title="Compare">
                                            <i class="fa fa-share"></i>
                                        </button>
                                    </div>
                                    <div class="col-8">
                                        <button type="button" class="btn btn-block btn-primary btn-circle btn-icon-left">
                                            <i class="fa fa-shopping-cart"></i>Add to cart
                                        </button>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>



                <div class="col-md-6">
                    <div class="block product no-border z-depth-2-top z-depth-2--hover">
                        <div class="block-image">
                            <a href="#">
                                <img src="{{ asset('storage/' . $data[0]->image5 ) }}" class="img-center">
                            </a>
                            {{-- <span class="product-ribbon product-ribbon-right product-ribbon--style-1 bg-blue text-uppercase">New</span> --}}
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
                                    @if ($data[0]->skillset5 != NULL)
                                        <a style="background-color: rgb(255, 0, 76); padding: 4px; border-radius: 5px; color: white; font-weight: bold">{{ $data[0]->skillset5 }}</a>
                                    @endif

                                    @if ($s2[0]->skillset5 != NULL)
                                        <a style="background-color: rgb(255, 0, 76); padding: 4px; border-radius: 5px; color: white; font-weight: bold">{{ $s2[0]->skillset5 }}</a>
                                    @endif

                                    @if ($s3[0]->skillset5 != NULL)
                                         <a style="background-color: rgb(255, 0, 76); padding: 4px; border-radius: 5px; color: white; font-weight: bold">{{ $s3[0]->skillset5 }}</a>
                                    @endif

                                    @if ($s4[0]->skillset5 != NULL)
                                         <a style="background-color: rgb(255, 0, 76); padding: 4px; border-radius: 5px; color: white; font-weight: bold">{{ $s4[0]->skillset5 }}</a>
                                    @endif

                                    @if ($s5[0]->skillset5 != NULL)
                                         <a style="background-color: rgb(255, 0, 76); padding: 4px; border-radius: 5px; color: white; font-weight: bold">{{ $s5[0]->skillset5 }}</a>
                                    @endif

                                    <a href="{{ $data[0]->url5 }}" style="background-color: rgb(162, 0, 255); padding: 4px; margin:1% ; border-radius: 5px; color: white; font-weight: bold">More Details</a>
                                    {{-- <a href="#" class="bg-blue"></a> --}}
                                </div>
                            </div>
                            {{--
                            <div class="product-buttons mt-4">
                                <div class="row align-items-center">
                                    <div class="col-2">
                                        <button type="button" class="btn-icon" data-toggle="tooltip" data-placement="top" title="" data-original-title="Favorite">
                                            <i class="fa fa-heart"></i>
                                        </button>
                                    </div>
                                    <div class="col-2">
                                        <button type="button" class="btn-icon" data-toggle="tooltip" data-placement="top" title="" data-original-title="Compare">
                                            <i class="fa fa-share"></i>
                                        </button>
                                    </div>
                                    <div class="col-8">
                                        <button type="button" class="btn btn-block btn-primary btn-circle btn-icon-left">
                                            <i class="fa fa-shopping-cart"></i>Add to cart
                                        </button>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>




                <div class="col-md-6">
                    <div class="block product no-border z-depth-2-top z-depth-2--hover">
                        <div class="block-image">
                            <a href="#">
                                <img src="{{ asset('storage/' . $data[0]->image6 ) }}" class="img-center">
                            </a>
                            {{-- <span class="product-ribbon product-ribbon-right product-ribbon--style-1 bg-blue text-uppercase">New</span> --}}
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
                                    @if ($data[0]->skillset6 != NULL)
                                        <a style="background-color: rgb(255, 0, 76); padding: 4px; border-radius: 5px; color: white; font-weight: bold">{{ $data[0]->skillset6 }}</a>
                                    @endif

                                    @if ($s2[0]->skillset6 != NULL)
                                        <a style="background-color: rgb(255, 0, 76); padding: 4px; border-radius: 5px; color: white; font-weight: bold">{{ $s2[0]->skillset6 }}</a>
                                    @endif

                                    @if ($s3[0]->skillset6 != NULL)
                                         <a style="background-color: rgb(255, 0, 76); padding: 4px; border-radius: 5px; color: white; font-weight: bold">{{ $s3[0]->skillset6 }}</a>
                                    @endif

                                    @if ($s4[0]->skillset6 != NULL)
                                         <a style="background-color: rgb(255, 0, 76); padding: 4px; border-radius: 5px; color: white; font-weight: bold">{{ $s4[0]->skillset6 }}</a>
                                    @endif

                                    @if ($s5[0]->skillset6 != NULL)
                                         <a style="background-color: rgb(255, 0, 76); padding: 4px; border-radius: 5px; color: white; font-weight: bold">{{ $s5[0]->skillset6 }}</a>
                                    @endif

                                    <a href="{{ $data[0]->url6 }}" style="background-color: rgb(162, 0, 255); padding: 4px; margin:1% ; border-radius: 5px; color: white; font-weight: bold">More Details</a>
                                    {{-- <a href="#" class="bg-blue"></a> --}}
                                </div>
                            </div>

                            {{-- <div class="product-buttons mt-4">
                                <div class="row align-items-center">
                                    <div class="col-2">
                                        <button type="button" class="btn-icon" data-toggle="tooltip" data-placement="top" title="" data-original-title="Favorite">
                                            <i class="fa fa-heart"></i>
                                        </button>
                                    </div>
                                    <div class="col-2">
                                        <button type="button" class="btn-icon" data-toggle="tooltip" data-placement="top" title="" data-original-title="Compare">
                                            <i class="fa fa-share"></i>
                                        </button>
                                    </div>
                                    <div class="col-8">
                                        <button type="button" class="btn btn-block btn-primary btn-circle btn-icon-left">
                                            <i class="fa fa-shopping-cart"></i>Add to cart
                                        </button>
                                    </div>
                                </div>
                            </div> --}}
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