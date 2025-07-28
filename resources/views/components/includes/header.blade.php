<div class="header">
    <div class="row">
        <div class="container">
            <div class="col-md-12">
                <div class="logo">
                    <h2>Logo</h2>
                </div>
                <input class="menu-btn" type="checkbox" id="menu-btn" />
                <label class="menu-icon" for="menu-btn"><span class="navicon"></span></label>
                <ul class="menu">
                    <li class="active">
                        <a href="#home" onclick="scrollToSection(event, 'home')">Home</a>
                    </li>
                    <li>
                        <a href="#about-us" onclick="scrollToSection(event, 'about-us')">About Us</a>
                    </li>
                    <li>
                        <a href="#services" onclick="scrollToSection(event, 'services')">Services</a>
                    </li>
                    <li>
                        <a href="#testimonials" onclick="scrollToSection(event, 'testimonials')">Testimonials</a>
                    </li>
                    <li>
                        <a href="#partners" onclick="scrollToSection(event, 'partners')">Partners</a>
                    </li>
                    <div class="rightmenu">
                        <li class="apply"><a href="{{ route('application') }}">Apply Now</a></li>
                        <li class="track"><a href="{{ route('track.application') }}">Track Application</a></li>
                    </div>
                </ul>

                <script>
                function scrollToSection(event, sectionId) {
                    event.preventDefault();
                    const section = document.getElementById(sectionId);
                    if (section) {
                        section.scrollIntoView({ behavior: 'smooth' });
                    }
                }
                </script>

            </div>
        </div>
    </div>
</div>











{{-- home nav links --}}

{{-- <div class="header">
    <div class="row">
        <div class="container">
            <div class="col-md-12">
                <div class="logo">
                    <h2>Logo</h2>
                </div>
                <input class="menu-btn" type="checkbox" id="menu-btn" />
                <label class="menu-icon" for="menu-btn"><span class="navicon"></span></label>
                <ul class="menu">
                    <li class="active">
                        <a href="{{ route('landing') }}">Home</a>
                    </li>
                    <li>
                        <a href="/about">About Us</a>
                    </li>
                    <li>
                        <a href="/service">Services</a>
                    </li>
                    <li>
                        <a href="/testimonials">Testimonials</a>
                    </li>
                    <li>
                        <a href="/patners">Partners</a>
                    </li>
                    <div class="rightmenu">
                        <li class="apply"><a href="{{ route('application') }}">Apply Now</a></li>
                        <li class="track"><a href="{{ route('track.application') }}">Track Application</a></li>
                    </div>
                </ul>


            </div>
        </div>
    </div>
</div> --}}
