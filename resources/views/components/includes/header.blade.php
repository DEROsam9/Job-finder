<div class="header">
    <div class="row">
        <div class="container">
            <div class="col-md-12">
                <div class="logo">
                    <h2>Logo</h2>
                </div>
                <input class="menu-btn" type="checkbox" id="menu-btn" />
                <label class="menu-icon" for="menu-btn"><span class="navicon"></span></label>
                <!-- Mobile Apply Now button -->
                <div class="apply-now-mobile">
                    <a href="{{ route('application') }}" class="btn-apply">Apply Now</a>
                </div>
                
                {{-- Mobile apply button --}}
                <ul class="menu">
                    <li class="active">
                        <a href="{{ route('landing') }}">Home</a>
                    </li>
                    <li>
                        <a href="#">About Us</a>
                    </li>
                    <li>
                        <a href="#">Services</a>
                    </li>
                    <li>
                        <a href="#">Experiences</a>
                    </li>
                    <li>
                        <a href="#">Partners</a>
                    </li>
                    <div class="rightmenu">
                        <li class="apply"><a href="{{ route('application') }}">Apply Now</a></li>
                        <li class="track"><a href="{{ route('track.application') }}">Track Application</a></li>
                    </div>
                </ul>
            </div>
        </div>
    </div>
</div>
