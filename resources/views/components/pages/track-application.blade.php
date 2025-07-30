@extends('components.layout.app')

@section('content')
<div class="row">
      <div class="container">
        <div class="col-md-12">
          <div class="pg-title">
            <h1>Track Your Application</h1>
          </div>
          <div class="pg-content">

            <div class="form-track">
              <h3>Enter your Job reference Number below to track your application</h3>
              <form>
                <p>
                  <input type="text" name="Job reference Number" placeholder="Job reference Number">
                  <button class="search">Search</button>
                </p>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
@endsection    