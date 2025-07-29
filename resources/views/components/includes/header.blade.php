<div class="header">
    <div class="row">
        <div class="container">
            <div class="col-md-12">
                <div class="logo">
                    <a href="{{ route('landing') }}#home">  
                    {{-- <h2>Logo</h2> --}}
<img src="{{ asset('images/TALENTBRIDGE LOGO.png') }}" alt="TalentBridge Logo" height="50">                
</div>
                <input class="menu-btn" type="checkbox" id="menu-btn" />
                <label class="menu-icon" for="menu-btn"><span class="navicon"></span></label>
                <ul class="menu">
                    <li class="active"><a href="{{ route('landing') }}#home">Home</a></li>
                    <li><a href="{{ route('landing') }}#about-us">About Us</a></li>
                    <li><a href="{{ route('landing') }}#services">Services</a></li>
                    <li><a href="{{ route('landing') }}#testimonials">Testimonials</a></li>
                    <li><a href="{{ route('landing') }}#partners">Partners</a></li>
                    <div class="rightmenu">
                        <li class="apply"><a href="{{ route('application') }}">Apply Now</a></li>
                        <li class="track"><a href="{{ route('track.application') }}">Track Application</a></li>
                    </div>
                </ul>


            </div>
        </div>
    </div>
</div>











{{-- home nav links --}}

{{-- <div class="header">
    <div class="row">
        <div class="container">
            <div class="col-md-12">
            <a href="{{ route('landing') }}#home">
                <div class="logo">
                    
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
