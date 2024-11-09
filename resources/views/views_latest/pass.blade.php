<!DOCTYPE html5>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Forgot Password</title>
    <link rel="shortcut icon" href="{{ asset('assets/img/favicon.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://unpkg.com/tailwindcss@2.0.2/dist/tailwind.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
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
        <form method="post" onsubmit="return setAction(this)">
            @csrf

            @if (session()->has('error'))
            <script>
                var msg = "<?php echo session('error'); ?>"
                swal({
                    title: msg,
                    icon: "warning",
                });
            </script>
            @endif
            <h1>Password Reset</h1>
            <div class="input_box">
                <select class="drop_down" name="drop_down" id="drop_down" required>
                    <option class="opt" value="{{ url('select/forgotpassword') }}">Role</option>
                    <option class="opt" value="{{ url('admin/forgotpassword/check') }} ">School Admin</option>
                    <option class="opt" value="{{ url('supervisor/forgotpassword/check') }} ">School Group Manager</option>
                    <option class="opt" value="{{ url('manager/forgotpassword/check') }} ">School Manager</option>
                    <option class="opt" value="{{ url('classteacher/forgotpassword/check') }}">School Classteacher</option>
                    <option class="opt" value="{{ url('faculty/forgotpassword/check') }}">School Faculty</option>
                    <option class="opt" value="{{ url('student/forgotpassword/check') }}">School Student</option>
                    <option class="opt" value="{{ url('nontech/groupmanager/forgotpassword/check') }}">School Nontech Group Manager</option>
                    <option class="opt" value="{{ url('nontech/manager/forgotpassword/check') }}">School Nontech Manager</option>
                    <option class="opt" value="{{ url('nontech/staff/forgotpassword/check') }}">School Nontech Staff</option>
                    <option class="opt" value="{{ url('vendor/caterer/forgotpassword/check') }}">School Vendor</option>
                </select>
            </div>
            <div class="input_box">
                <input type="email" name="email" placeholder="Enter a Valid Email Address" required>
                <i class='bx bxs-envelope'></i>
            </div>
            <!-- <div class="input_box">
                <input type="text" placeholder="Username" required>
                <i class='bx bxs-user'></i>
            </div>
            <div class="input_box">
                <input type="password" placeholder="Password" required>
                <i class='bx bxs-lock-alt' ></i>
            </div> -->
            <button type="submit" class="btn">Reset</button>

            <div class="register">
                <p>Don't have an account? <a href="{{ url('/register') }}">Register</a> | <a href="{{ url('/login') }}">Sign-In</a></p>

            </div>


        </form>

        <script>
            function setAction(form) {
                if (document.getElementById("drop_down").value === "{{ url('select/forgotpassword') }}") {
                    form.action = document.getElementById("drop_down").value;
                    var msg = "<?php echo "Select a Role"; ?>"
                        swal({
                            title: msg,
                            icon: "warning",
                        });

                }

                else {
                    form.action = document.getElementById("drop_down").value;
                }

            }

        </script>


    </div>
</body>
</html>