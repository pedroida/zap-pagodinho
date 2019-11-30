<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-white navbar-absolute fixed-top" style="box-shadow: unset">
  <div class="container-fluid">
    <div class="navbar-wrapper">
      <a class="navbar-brand" href="#">{{ $titlePage }}</a>
    </div>
    <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
    <span class="sr-only">Toggle navigation</span>
    <span class="navbar-toggler-icon icon-bar"></span>
    <span class="navbar-toggler-icon icon-bar"></span>
    <span class="navbar-toggler-icon icon-bar"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end">
      <form class="navbar-form d-none">
        <div class="input-group no-border">
          <input type="text" value="" class="form-control" placeholder="...">
          <button type="submit" class="btn btn-white btn-round btn-just-icon">
            <i class="material-icons">search</i>
            <div class="ripple-container"></div>
          </button>
        </div>
      </form>
      <ul class="navbar-nav">
        <notifications empty-phrase="Sem convites" icon="notifications" notifications-url="{{ route('ajax.notifications.invites') }}">
        </notifications>
        <li class="nav-item d-md-none d-lg-block">
            <p class="text-center">
              {{ Auth::user()->name }}
            </p>
        </li>
        <li class="nav-item dropdown d-lg-block d-md-none">
          <a class="nav-link" href="#pablo" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="material-icons">person</i>
            <p class="d-lg-none d-md-block">
              {{ Auth::user()->name }}
            </p>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">
            <a class="dropdown-item" href="{{ route('profile.edit') }}">{{ __('phrases.profile') }}</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">{{ __('phrases.logout') }}</a>
          </div>
        </li>
        <li class="nav-item d-lg-none d-md-block">
          <a class="dropdown-item" href="{{ route('profile.edit') }}">
            <i class="material-icons">person</i>
            <p>
              {{ __('phrases.profile') }}
            </p>
          </a>
        </li>
        <li class="nav-item d-lg-none d-md-block">
          <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
            <i class="material-icons">logout</i>
            <p>
              {{ __('phrases.logout') }}
            </p>
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>
