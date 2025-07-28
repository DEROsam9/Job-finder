@extends('components.layout.app')

@section('content')
{{-- Starter --}}
<div class="row">
  <div class="container">
    <div class="col-md-12">
      <div class="pg-title">
        <h1>Your Dream Career Awaits</h1>
      </div>
    </div>
    <div class="col-md-12">
      <div class="page-content">
        <p>
          Discover life-changing job opportunities across top global cities.
          Apply today and take the first step toward your future.
        </p>
        <form>
          <input type="search" name="search" placeholder="Search">
        </form>
        <div class="dream-img">
          <img src="{{ asset('images/v27_51.png') }}">
        </div>
      </div>
    </div>
    <div class="col-md-12">
      <div class="apply-section">
        <a href="apply.html">Apply now</a>
      </div>
    </div>
  </div>
</div>

{{-- About Us --}}
<div class="row">
  <div class="container">
    <div class="col-md-12">
      <div class="pg-title">
        <h1>About Us</h1>
      </div>
    </div>
    <div class="col-md-12">
      <div class="page-content">
        <div class="dream-img">
          <img src="images/v27_67.png">
        </div>
        <p>
          At [Your Platform Name], we connect ambitious job seekers with exciting career opportunities
          in Dubai and other global cities. Our mission is to simplify the job search process by
          offering a reliable, user-friendly platform where talent meets opportunity. Join thousands
          of professionals who trust us to take the next big step in their careers.
        </p>
      </div>
    </div>
    <div class="col-md-12">
      <div class="apply-section">
        <a href="apply.html">Apply now</a>
      </div>
    </div>
  </div>
</div>

{{-- Partners --}}
<div class="row">
  <div class="container">
    <div class="col-md-12">
      <div class="pg-title">
        <h1>Partners</h1>
      </div>
    </div>
    <div class="col-md-12">
      <div class="page-content">
        <div class="partners-pics row">
          @php
            $partners = [
              ['img' => 'v54_724.png', 'name' => 'Janta'],
              ['img' => 'accurex.png', 'name' => 'Accurex'],
              ['img' => 'mal.png', 'name' => 'MAL Consultancy'],
              ['img' => 'hr.png', 'name' => 'Hallmark']
            ];
          @endphp

          @foreach($partners as $partner)
          <div class="col-md-3">
            <div class="partner">
              <div class="partner-pic">
                <img src="images/{{ $partner['img'] }}">
              </div>
              <h3>{{ $partner['name'] }}</h3>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
    <div class="col-md-12">
      <div class="apply-section">
        <a href="#">Explore</a>
      </div>
    </div>
  </div>
</div>

{{-- Experiences --}}
<div class="row">
  <div class="container">
    <div class="col-md-12">
      <div class="pg-title">
        <h1>Experiences</h1>
      </div>
    </div>
    <div class="col-md-12">
      <div class="page-content">
        <div class="experiences-pics row">
          @php
            $experiences = [
              ['img' => 'v108_550.png', 'name' => 'Kevin Muriithi'],
              ['img' => 'v108_548.png', 'name' => 'Mary Mweni'],
              ['img' => 'v108_407.png', 'name' => 'Joseph Ochiel'],
              ['img' => 'v108_406.png', 'name' => 'Martin Muriithi']
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
<div class="row">
  <div class="container">
    <div class="col-md-12">
      <div class="pg-title">
        <h1>Our Services</h1>
      </div>
    </div>
    <div class="col-md-12">
      <div class="page-content">
        <div class="services-section row">
          @php
            $services = [
              'Temporary and contact placement',
              'Technical and specialized recruitment',
              'Professional staffing',
              'Permanent placements',
              'Outsourcing services',
              'Business support and service'
            ];
          @endphp

          @foreach($services as $service)
          <div class="col-md-4">
            <div class="service">
              <img src="images/160103.png">
              <div class="service-title">
                <h3>{{ $service }}</h3>
              </div>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
    <div class="col-md-12">
      <div class="apply-section">
        <a href="apply.html">Apply now</a>
      </div>
    </div>
  </div>
</div>
@endsection
