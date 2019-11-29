<div class="wrapper ">
  @include('layouts.navbars.sidebar')
  <div class="main-panel" style="background-image: url('{{ asset('material') }}/img/login-background-min.jpg'); background-size: cover; background-position: center;">
    @include('layouts.navbars.navs.auth')
    @yield('content')
{{--    @include('layouts.footers.auth')--}}
  </div>
</div>