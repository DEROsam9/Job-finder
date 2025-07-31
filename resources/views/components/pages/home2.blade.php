@extends('components.layout.app')

@section('content')
{{-- Starter --}}
<div class="row" id="home">
  <div class="container">
    <div class="col-md-12">
      <div class="pg-title">
        <h2>Your Dream Career Awaits</h2>
      </div>
    </div>
  </div>
  <div class="col-md-12">
    <div class="page-content">
      <p>
        Discover life-changing job opportunities across top global cities.
        Apply today and take the first step toward your future.
      </p>
      <!-- <form>
        <input type="search" name="search" placeholder="Search">
      </form> -->
      <div class="dream-img">
        <img src="{{ asset('images/v27_51.jpg') }}">
      </div>
    </div>
  </div>
  <div class="col-md-12">
    <div class="apply-section">
      <a href="/application-form">Apply now</a>
    </div>
  </div>
</div>

{{-- About Us --}}
{{-- <div class="row" id="about-us">
<div class="container">
  <div class="col-md-12">
    <div class="pg-title">
      <h2>About Us</h2>
    </div>
  </div>
  <div class="col-md-12">
    <div class="page-content">
      <div class="dream-img">
        <img src="images/v27_67.jpg">
      </div>
      <p>
        At Talent Bridge, we connect ambitious job seekers with exciting career opportunities
        in Dubai and other global cities. Our mission is to simplify the job search process by
        offering a reliable, user-friendly platform where talent meets opportunity. Join thousands
        of professionals who trust us to take the next big step in their careers.
      </p>
    </div>
  </div>
  <div class="col-md-12">
    <div class="apply-section">
      <a href="/application-form">Apply now</a>
    </div>
  </div>
</div>
</div> --}}
<div class="row" id="about-us">
<div class="container">
  <div class="col-md-12">
    <div class="pg-title">
      <h2>About Us</h2>
    </div>
  </div>
  <div class="col-md-12">
    <div class="page-content">
      <div class="dream-img">
        <img src="images/v27_67.jpg">
      </div>
      <p>
        Talent Bridge Careers is a leading international recruitment agency committed to connecting skilled professionals with rewarding job opportunities abroad.

We specialize in placing skilled talent with top-tier employers across diverse sectors. Whether you're a sales professional, hospitality expert, skilled administrator, or aiming to grow in fast-paced industries like retail, administration, hospitality or real estate, we’ve got verified, high-quality job openings tailored for you.

At Talent Bridge, we offer comprehensive recruitment support—from application to placement—including personalized assistance with visa processing, relocation logistics, and onboarding.
</p>
<h2>Our goal</h2>
 <p>To help you succeed abroad with confidence and dignity.

We’re passionate about helping people move, grow, and thrive.</p>

<h2>Mission</h2>
<p>

To deliver ethical, transparent, and effective recruitment solutions globally.</p>

<h2>Vision</h2>
<p>To transform lives through global opportunities.</p>
      </p>
    </div>
  </div>
  <div class="col-md-12">
    <div class="apply-section">
      <a href="/application-form">Apply now</a>
    </div>
  </div>
</div>
</div> 


{{-- Partners --}}
<div class="row" id="partners">
    <div class="container">
      <div class="col-md-12">
        <div class="pg-title">
          <h2>Partners</h2>
        </div>
      </div>
      <div class="col-md-12">
        <div class="page-content">
          <div class="partners-pics">
            <div class="col-md-3">
              <div class="partner">
                <div class="partner-pic">
                  <img src="images/v54_724.png">
                </div>
                <h3>Janta</h3>
              </div>
            </div>
            <div class="col-md-3">
              <div class="partner">
                <div class="partner-pic">
                  <img src="images/accurex.png">
                </div>
                <h3>Accurex</h3>
              </div>
            </div>
            <div class="col-md-3">
              <div class="partner">
                <div class="partner-pic">
                  <img src="images/mal.png">
                </div>
                <h3>MAL Consultancy</h3>
              </div>
            </div>
            <div class="col-md-3">
              <div class="partner">
                <div class="partner-pic">
                  <img src="images/hr.png">
                </div>
                <h3>Hallmark</h3>
              </div>
            </div>

{{-- Experiences --}}
<div class="row" id="testimonials">
<div class="container">
  <div class="col-md-12">
    <div class="pg-title">
      <h2>Experiences</h2>
    </div>
  </div>
  <div class="col-md-12">
    <div class="page-content">
      <div class="experiences-pics row">
        @php
          $experiences = [
            ['img' => 'v108_550.jpg', 'name' => 'Kevin Muriithi'],
            ['img' => 'v108_548.jpg', 'name' => 'Mary Mweni'],
            ['img' => 'v108_407.jpg', 'name' => 'Joseph Ochiel'],
            ['img' => 'v108_406.jpg', 'name' => 'Martin Muriithi']
          ];
        @endphp

        @foreach($experiences as $exp)
        <div class="col-md-3">
          <div class="experience-pic">
            <img src="images/{{ $exp['img'] }}">
            <h3>{{ $exp['name'] }}</h3>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</div>
</div>

{{-- Services --}}

<div class="row" id="services">
  <div class="container">
    <div class="col-md-12">
      <div class="pg-title">
        <h2>Our Services</h2>
      </div>
    </div>
    <div class="col-md-12">
      <div class="page-content">
<div class="services-section row">
<div class="service-carousel">
  <div class="carousel-wrapper" id="carouselWrapper">
    <!-- Slide 1 -->
    <div class="service-slide">
      <div class="service-image-container">
        <img src="{{ asset('images/placement1.jpeg') }}" class="service-image">
        <div class="overlay-text">
          <h3>🔹 International Job Placement</h3>
          <p>We match qualified candidates with trusted employers in UAE, Bahrain, Qatar, Saudi Arabia, and North America.</p>
          <ul>
            <li>Hospitality & Tourism</li>
            <li>Retail & Sales</li>
            <li>Office Administration</li>
            <li>Healthcare</li>
            <li>Construction</li>
            <li>Logistics & Warehousing</li>
          </ul>
        </div>
      </div>
    </div>

    <!-- Slide 2 -->
    <div class="service-slide">
      <div class="service-image-container">
        <img src="{{ asset('images/interview.jpeg') }}" class="service-image">
        <div class="overlay-text">
          <h3>🔹 Pre-Screening & Interview Prep</h3>
          <p>We conduct assessments and coach you through interviews to increase your success rate.</p>
        </div>
      </div>
    </div>

    <!-- Slide 3 -->
    <div class="service-slide">
      <div class="service-image-container">
        <img src="{{ asset('images/passport.jpg') }}" class="service-image">
        <div class="overlay-text">
          <h3>🔹 Visa & Documentation Support</h3>
          <p>We help with visa applications and necessary paperwork for a stress-free process.</p>
        </div>
      </div>
    </div>

    <!-- Slide 4 -->
    <div class="service-slide">
      <div class="service-image-container">
        <img src="{{ asset('images/work.jpg') }}" class="service-image">
        <div class="overlay-text">
          <h3>🔹 Relocation & Orientation</h3>
          <p>Travel tips and cultural training to help you settle abroad with confidence.</p>
        </div>
      </div>
    </div>

    <!-- Slide 5 -->
    <div class="service-slide">
      <div class="service-image-container">
        <img src="{{ asset('images/ethics.jpeg') }}" class="service-image">
        <div class="overlay-text">
          <h3>🔹 Ethical Recruitment Practices</h3>
          <p>We ensure transparency and dignity for all candidates and employers.</p>
        </div>
      </div>
    </div>  
    </div>
  </div>
  {{-- <p>At Talent Bridge Careers, we are dedicated to connecting skilled professionals with verified and rewarding international job opportunities. Our comprehensive recruitment solutions are designed to support candidates at every stage of their journey—from job search to successful placement abroad.</p> --}}
  <p>At Talent Bridge, we don’t just place you in a job—we help you grow your career and transform your future.
Let us be your bridge to global opportunities.</p>
</div>

<!--FAQ-->
    <div class="container">
    <div class="pg-title">
      <h2>Frequently Asked Questions</h2>
      </div>
      <div class="accordion">
        <div class="accordion-item">
          <button id="accordion-button-1" aria-expanded="false">
            <span class="accordion-title">Why is the moon sometimes out during the day?</span>
            <span class="icon" aria-hidden="true"></span>
          </button>
          <div class="accordion-content">
            <p>
              Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
              incididunt ut labore et dolore magna aliqua. Elementum sagittis vitae et leo duis ut.
              Ut tortor pretium viverra suspendisse potenti.
            </p>
          </div>
        </div>
        <div class="accordion-item">
          <button id="accordion-button-2" aria-expanded="false">
            <span class="accordion-title">Why is the sky blue?</span>
            <span class="icon" aria-hidden="true"></span>
          </button>
          <div class="accordion-content">
            <p>
              Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
              incididunt ut labore et dolore magna aliqua. Elementum sagittis vitae et leo duis ut.
              Ut tortor pretium viverra suspendisse potenti.
            </p>
          </div>
        </div>
        <div class="accordion-item">
          <button id="accordion-button-3" aria-expanded="false">
            <span class="accordion-title">Will we ever discover aliens?</span>
            <span class="icon" aria-hidden="true"></span>
          </button>
          <div class="accordion-content">
            <p>
              Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
              incididunt ut labore et dolore magna aliqua. Elementum sagittis vitae et leo duis ut.
              Ut tortor pretium viverra suspendisse potenti.
            </p>
          </div>
        </div>
        <div class="accordion-item">
          <button id="accordion-button-4" aria-expanded="false">
            <span class="accordion-title">How much does the Earth weigh?</span>
            <span class="icon" aria-hidden="true"></span>
          </button>
          <div class="accordion-content">
            <p>
              Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
              incididunt ut labore et dolore magna aliqua. Elementum sagittis vitae et leo duis ut.
              Ut tortor pretium viverra suspendisse potenti.
            </p>
          </div>
        </div>
        <div class="accordion-item">
          <button id="accordion-button-5" aria-expanded="false">
            <span class="accordion-title">How do airplanes stay up?</span>
            <span class="icon" aria-hidden="true"></span>
          </button>
          <div class="accordion-content">
            <p>
              Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
              incididunt ut labore et dolore magna aliqua. Elementum sagittis vitae et leo duis ut.
              Ut tortor pretium viverra suspendisse potenti.
            </p>
          </div>
        </div>
      </div>
      
      {{-- <div class="pg-title">
      <h2>Our Mission</h2>
      <p>To deliver ethical, transparent, and effective recruitment solutions globally.</p>
      </div>
      <div class="pg-title">
      <h2>Our Vision</h2>
      <p>To transform lives through global opportunities.</p>
    </div> --}}
    



  <style>
  .service-carousel {
    position: relative;
    width: 100%;
    max-width: 800px;
    margin: 0 auto;
    overflow: hidden;
    background: #f6f6f6;
    border-radius: 8px;
  }

  .carousel-wrapper {
    display: flex;
    transition: transform 1s ease-in-out;
    width: calc(800px * 5); /* 5 slides */
  }

  .service-slide {
    position: relative;
    flex: 0 0 800px;
    height: 320px;
  }

  .service-image-container {
    position: relative;
    width: 100%;
    height: 100%;
  }

  .service-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 8px;
  }

  
  .overlay-text {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  padding: 20px;
  box-sizing: border-box;
  background-color: rgba(0, 0, 0, 0.4); /* semi-transparent background */
  color: white;
  display: flex;
  flex-direction: column;
  justify-content: center;  /* vertical centering */
  align-items: center;      /* horizontal centering */
  text-align: center;
  border-radius: 8px;
}

.overlay-text h3,
.overlay-text p {
  margin: 25px 0;
}



 

  .overlay-text p, .overlay-text ul {
    font-size: 1rem;
    margin: 0;
  }

  .overlay-text ul {
    padding-left: 20px;
  }.accordion {
  width: 100%;
  max-width: 800px;
  margin: 40px auto;
  border-radius: 8px;
  overflow: hidden;
}

.accordion-item {
  border-bottom: 1px solid #ccc;
}

.accordion button {
  width: 100%;
  background-color: #fff;
  border: none;
  outline: none;
  text-align: left;
  padding: 18px 20px;
  font-size: 1.1rem;
  font-weight: 600;
  cursor: pointer;
  transition: background-color 0.3s ease;
  position: relative;
}

.accordion button:hover {
  background-color: #f1f1f1;
}

.accordion .icon::after {
  content: '+';
  position: absolute;
  right: 20px;
  font-size: 1.5rem;
  transition: transform 0.3s ease;
}

.accordion button[aria-expanded="true"] .icon::after {
  content: '−';
  transform: rotate(180deg);
}

.accordion-content {
  max-height: 0;
  overflow: hidden;
  transition: max-height 0.4s ease;
  background: #fafafa;
  padding: 0 20px;
}

.accordion-content p {
  padding: 15px 0;
  margin: 0;
  font-size: 1.1rem;
  line-height: 1.5;
}

  
</style>
<script>
  const wrapper = document.getElementById('carouselWrapper');
  const totalSlides = document.querySelectorAll('.service-slide').length;
  let currentIndex = 0;

  function autoSlide() {
    currentIndex = (currentIndex + 1) % totalSlides;
    wrapper.style.transform = `translateX(-${currentIndex * 800}px)`;
  }

  setInterval(autoSlide, 4000); // change slide every 4 seconds
  const items = document.querySelectorAll('.accordion button');
  // FAQ Accordion Toggle
const accordionButtons = document.querySelectorAll(".accordion button");

accordionButtons.forEach((button) => {
  button.addEventListener("click", () => {
    const expanded = button.getAttribute("aria-expanded") === "true";

    // Close all other accordions
    accordionButtons.forEach((btn) => {
      btn.setAttribute("aria-expanded", "false");
      btn.nextElementSibling.style.maxHeight = null;
    });

    // Toggle current accordion
    if (!expanded) {
      button.setAttribute("aria-expanded", "true");
      const content = button.nextElementSibling;
      content.style.maxHeight = content.scrollHeight + "px";
    }
  });
});


</script>

</div>
@endsection
