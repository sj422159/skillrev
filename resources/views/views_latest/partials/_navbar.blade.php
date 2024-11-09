   <header class="main-header">
        <div class="navbar px-2 py-2 mx-auto w-full md:px-24 lg:px-8">
            <h2 class="brand font-bold tracking-tight text-white font-size:48px">
                <a>
                    <i class="fa-solid fa-graduation-cap" style="color: orange; font-size:100%"></i>
                    SkillRevelation-SMS
                </a>
            </h2>

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