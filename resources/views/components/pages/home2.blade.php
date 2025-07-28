@extends('components.layout.app')

@section('content')

<div class="row">
        <div class="container">
            <div class="col-md-12">
                <div class="pg-title">
                    <h1>Your Dream Career Awaits</h1>
                </div>
            </div>
            <div class="col-md-12">
                <div class="page-content">
                    <p>Discover life-changing job opportunities across top global cities. Apply today and take the first step toward your future.</p>
                    <form>
                        <input type="search" name="search" placeholder="Search">
                    </form>
                    <div class="dream-img">
                        <img src="{{ asset('images/v27_51.png')}}">
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