@extends('components.layout.app')

@section('content')
<div style="padding: 24px 40px; flex-direction: column; display: flex; align-items: center; gap: 24px; flex: 1 1 0">

      <!-- Page Title -->
      <div style="font-size: 40px; font-weight: 700">Apply For a Job</div>

      

        <!-- Success Message Section -->
        <div style="width: 426px; display: inline-flex; gap: 24px">
          <div style="flex-direction: column; display: inline-flex; align-items: center; gap: 24px">
            <!-- Success Icon Placeholder -->
            <div style="width: 120px; height: 120px; position: relative">
              <div style="background: #8DC63F; width: 119.90px; height: 114.89px; position: absolute; top: 2.51px"></div>
              <div style="background: white; width: 60.21px; height: 44.74px; position: absolute; top: 41.56px; left: 32.26px"></div>
            </div>

            <!-- Confirmation Message -->
            <div style="font-size: 24px; font-weight: 700">Application Sent Successfully</div>
            <div style="text-align: center; font-size: 20px">
              Your job application has been submitted successfully. Your Job reference Number Is <strong>{{$reference}}</strong>
            </div>
          </div>
        </div>

        <!-- Close Button -->
        <div style="display: inline-flex; justify-content: center; gap: 24px; cursor: pointer;" onclick="window.location.href='{{ route('track.application') }}'">
          <div style="width: 340px; padding: 16px 24px; background: #2D78C9; border-radius: 100px; display: flex; justify-content: center">
            <div style="color: white; font-size: 20px; font-weight: 700">Close</div>
          </div>
        </div>
      </div>
    </div>
@endsection