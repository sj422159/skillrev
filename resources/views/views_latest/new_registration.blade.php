<!DOCTYPE html5>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registration</title>
    <link rel="shortcut icon" href="{{ asset('assets/img/favicon.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://unpkg.com/tailwindcss@2.0.2/dist/tailwind.min.css" rel="stylesheet">
    {{-- sweetAlert CDN --}}
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

</head>
<body>

    <div class="navbar px-4 py-5 md:px-24 lg:px-8 top-0">
        <h2 class="font-bold tracking-tight text-white font-size:48px">
            <a class="logo" href="/">
                <i class="fa-solid fa-graduation-cap logo_brand" style="color: orange;"></i>
                SkillRevelation-SMS
            </a>
        </h2>
    </div>


    <div class="login">
        <form action="{{url('admin/register/save')}}" method="post">
            @csrf
            <h2>Register as Admin</h2>
            <!-- <div class="input_box">

                <select class="drop_down">
                    <option value="">Select</option>
                    <option value="">Student</option>
                    <option value="">Admin</option>
                    <option value="">Manager</option>
                </select>
            </div> -->
            <div class="input_box">
                <input type="text" required="true" name="name" placeholder="School Name" required>
                <i class='bx bxs-user'></i>
            </div>
            <div class="input_box">
                <input type="text" required="true" name="email" placeholder="Email address" required>
                <i class='bx bxs-envelope'></i>
            </div>
            <div class="input_box">
                <input type="tel" name="number" required="true" placeholder="Mobile Number" required>
                <i class='bx bxs-phone'></i>
            </div>
            <button type="submit" class="btn">Register</button>

            <div class="register">
                <p>Have an account? <a href="{{ url('/login') }}">Sign-In</a> | <a href="{{ url('/pass') }}">Forgot Password</a></p>

            </div>


        </form>


    </div>
</body>
</html>