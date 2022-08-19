@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="loading card-body p-4">
                  <div class="row">
                    <div class="col-3">
                  <svg width="100" height="100" viewBox="0 0 300 300">
                  <defs>
                    <linearGradient id="gradient-fill" gradientUnits="userSpaceOnUse" x1="0" y1="300" x2="300" y2="0">
                      <stop offset="0%">
                        <animate attributeName="stop-color" values="#00E06B;#CB0255;#00E06B" dur="5s" repeatCount="indefinite" />
                      </stop>
                      <stop offset="100%">
                        <animate attributeName="stop-color" values="#04AFC8;#8904C5;#04AFC8" dur="8s" repeatCount="indefinite" />
                      </stop>
                    </linearGradient>
                    <clipPath id="clip">
                      <rect class="square s1" x="0" y="0" rx="12" ry="12" height="90" width="90"></rect>
                      <rect class="square s2" x="100" y="0" rx="12" ry="12" height="90" width="90"></rect>
                      <rect class="square s3" x="200" y="0" rx="12" ry="12" height="90" width="90"></rect>
                      <rect class="square s4" x="0" y="100" rx="12" ry="12" height="90" width="90"></rect>
                      <rect class="square s5" x="200" y="100" rx="12" ry="12" height="90" width="90"></rect>
                      <rect class="square s6" x="0" y="200" rx="12" ry="12" height="90" width="90"></rect>
                      <rect class="square s7" x="100" y="200" rx="12" ry="12" height="90" width="90"></rect>
                    </clipPath>
                  </defs>
                  <rect class="gradient" clip-path="url('#clip')" height="300" width="300"></rect>
                </svg>
                </div>
                <div class="col">Please wait. The system is calculating data. It will redirect to dashboard after it completed.
                </div>
              </div>
              </div>
              <div class="card-body p-4 error d-none">
                System error. Could not calculate data.
              </div>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function(){
  $.ajax({
        url: '{{route('twitter_calculating')}}',
        type: 'get',
        contentType: false,
        processData: false,
        success: function(response){
          window.location.href='/dashboard';
        },
        error:function(response, textStatus, xhr){
          console.log(textStatus);
          $('.error').removeClass('d-none');
          $('.loading').addClass('d-none');

        }
    });
});
</script>
@endsection
