<!DOCTYPE html5>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login Page</title>
    <link rel="shortcut icon" href="{{ asset('assets/img/favicon.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://unpkg.com/tailwindcss@2.0.2/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    {{-- sweetAlert CDN --}}
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>

<body>

    <div class="navbar px-4 md:px-24 lg:px-8 top-0">
        <h2 class="font-bold tracking-tight text-white font-size:48px">
            <a class="logo" href="/" >
                <i class="fa-solid fa-graduation-cap logo_brand" style="color: orange"></i>
                SkillRevelation-SMS
            </a>
        </h2>
    </div>
    <div class="login">
        <form method="post" onsubmit="return setAction(this)">
            @csrf
            <h1>Sign-In As</h1>
            @if (session()->has('error'))
                <script>
                    var msg = "<?php echo session('error'); ?>"
                    swal({
                        title: msg,
                        icon: "warning",
                    });
                </script>
            @endif
            <div class="input_box" id="external_user">

                <select class="drop_down" name="external" id="external" required>
                    <option class="opt" value="{{ url('select/login/save') }}">Role</option>
                    <option class="opt" value="{{ url('admin/login/save') }} ">School Admin</option>
                    <option class="opt" value="{{ url('Accontrol/login/save') }} ">School Controller</option>
                    <option class="opt" value="{{ url('supervisor/login/save') }} ">School Group Manager</option>
                    <option class="opt" value="{{ url('manager/login/save') }} ">School Manager</option>
                    <option class="opt" value="{{ url('classteacher/login/save') }}">School Classteacher</option>
                    <option class="opt" value="{{ url('faculty/login/save') }}">School Faculty</option>
                    <option class="opt" value="{{ url('student/login/save') }}">School Student</option>
                    <option class="opt" value="{{ url('nontech/groupmanager/login/save') }}">School Nontech Group Manager</option>
                    <option class="opt" value="{{ url('nontech/manager/login/save') }}">School Nontech Manager</option>
                    <option class="opt" value="{{ url('nontech/staff/login/save') }}">School Nontech Staff</option>
                    <option class="opt" value="{{ url('vendor/caterer/login/save') }}">School Vendor</option>
                </select>
            </div>

            <div class="input_box" id="internal_user" style="display: none">

                <select class="drop_down" name="internal" id="internal" required>
                    <option class="opt" value="{{ url('select/login/save') }}">Role</option>
                    <option class="opt" value="{{ url('corporateadmin/login/save') }}">Corporate Admin</option>
                    <option class="opt" value="{{ url('employee/marketingmanager/login/save') }} ">Marketing Manager</option>
                    <option class="opt" value="{{ url('employee/marketingofficer/login/save') }} ">Marketing Officer</option>
                </select>
            </div>

            <div class="input_box">
                <input type="text" placeholder="Email Address" id="email" name="email" required>
                <i class='bx bxs-user'></i>
            </div>
            <div class="input_box">
                <input type="password" id="password" placeholder="Password" name="password" required>
                <i class='fas fa-lock' id="show_pass" onclick="show()"></i>
            </div>

            <input type="hidden" name="switchState" id="switchState" value="" />

            <label class="switch switch-light">
                <input id="mySwitch" class="switch-input" type="checkbox" onchange="handleSwitchChange()"/>
                <span class="switch-label" data-on="Internal" data-off="External"></span>
                <span class="switch-handle"></span>
            </label>

            <button type="submit" id="submit" class="btn">Sign-In</button>

            <div class="register">
                <p>Don't have an account? <a href="{{ url('/register') }}">Register</a> | <a href="{{ url('/pass') }}">Forgot Password</a></p>
            </div>
        </form>
    </div>

    <script>
        function handleSwitchChange() {

            const switchElement = document.getElementById('mySwitch');
            const internal = document.getElementById('internal_user');
            const external = document.getElementById('external_user');

            if (switchElement.checked)
            {
                external.style.display = 'none';
                external.style.height = "0px";
                external.style.width="0px";

                internal.style.display = 'block';

            }
            else
            {
                internal.style.display = 'none';

                external.style.display = 'block';
                external.style.height = "50px";
                external.style.width="100%";
                external.style.margin = "30px 0px 30px 0px";
                external.style.position = "relative";

            }
            document.getElementById('switchState').value = document.getElementById('mySwitch').checked;
        }
    </script>

    <script>
        function setAction(form)
        {
            const switchState = document.getElementById('switchState').value;
            const externalOption = document.getElementById("external");
            const internalOption = document.getElementById("internal");

            if (switchState === 'false' || switchState === '')
            {
                const selectedExternalValue = externalOption.value;
                if (selectedExternalValue === "{{ url('select/login/save') }}")
                {
                    form.action = selectedExternalValue;
                    var msg = "<?php echo "Select a Role"; ?>"
                    swal({
                        title: msg,
                        icon: "warning",
                    });
                }
                else
                {
                    form.action = selectedExternalValue;
                }
            }
            else
            {
                const selectedInternalValue = internalOption.value;
                if (selectedInternalValue === "{{ url('select/login/save') }}")
                {
                    form.action = selectedInternalValue;
                    var msg = "<?php echo "Select a Role"; ?>"
                    swal({
                        title: msg,
                        icon: "warning",
                    });
                }
                else
                {
                    form.action = selectedInternalValue;
                }
            }

        }

    </script>
    <script>
        function show() {
            var pass = document.getElementById('password');
            var icon = document.querySelector('.fas');
            if (pass.type === "password") {
                pass.type = "text";
                icon.className = "fas fa-lock-open"

            } else {
                pass.type = "password";
                icon.className = "fas fa-lock"
            }
        }
    </script>
</body>

</html>
