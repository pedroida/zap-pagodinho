<div class="sidebar" data-color="orange" data-background-color="white" data-image="{{ asset('material') }}/img/sidebar-1.jpg">
  <!--
      Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

      Tip 2: you can also add an image using data-image tag
  -->
  <div class="logo">
    <a href="{{ route('home') }}" class="simple-text logo-normal">
      <img src="{{ asset('material') }}/img/beer-icon.png" class="embed-responsive w-50 m-auto" alt="">
      {{ config('app.name') }}
    </a>
  </div>
  <div class="sidebar-wrapper">
    <ul class="nav">
      <li class="nav-item{{ $activePage == 'chats' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('chats') }}">
          <i class="material-icons">chat</i>
            <p>{{ __('phrases.chats') }}</p>
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'friends' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('friends.index') }}">
          <i class="fa fa-users"></i>
            <p>{{ __('phrases.friends') }}</p>
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'table' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('table') }}">
          <i class="material-icons">content_paste</i>
            <p>{{ __('Table List') }}</p>
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'icons' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('icons') }}">
          <i class="material-icons">bubble_chart</i>
          <p>{{ __('Icons') }}</p>
        </a>
      </li>
    </ul>
  </div>
</div>