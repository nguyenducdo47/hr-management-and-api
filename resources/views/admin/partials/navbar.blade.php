<nav class="flex-row navbar col-lg-12 col-12 p-lg-0 fixed-top d-flex">
    <div class="navbar-menu-wrapper d-flex align-items-stretch justify-content-between">
        <a class="navbar-brand brand-logo-mini align-self-center d-lg-none" href="{{url('/admin/dashboard')}}"><img
                src="/assets/images/logo-mini.svg" alt="logo" /></a>
        <button class="mr-2 navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <i class="mdi mdi-menu"></i>
        </button>

        <ul class="navbar-nav navbar-nav-right ml-lg-auto ">
            <li class="border-0 nav-item dropdown d-xl-flex">
                <a class="nav-link dropdown-toggle" id="languageDropdown" href="#" data-toggle="dropdown">
                    <i class="mdi mdi-earth"></i>
                    @if (app()->getLocale() == 'en')
                        {{ __('T. Anh') }}
                    @elseif (app()->getLocale() == 'vi')
                        {{ __('T. Việt') }}
                    @else
                        {{ app()->getLocale() }}
                    @endif
                </a>
                <div class="dropdown-menu navbar-dropdown" aria-labelledby="languageDropdown">
                    <a class="dropdown-item" href="{{ route('lang.en') }}">
                        {{ __('messages.language_en') }}
                        @if (app()->getLocale() == 'en')
                            <span class="float-right">✔</span>
                        @endif
                    </a>
                    <a class="dropdown-item" href="{{ route('lang.vi') }}">
                        {{ __('messages.language_vn') }}
                        @if (app()->getLocale() == 'vi')
                            <span class="float-right">  <i class="mdi mdi-check"></i></span>
                        @endif
                    </a>
                </div>
            </li>


            <li class="border-0 nav-item nav-profile dropdown">
                <a class="nav-link dropdown-toggle d-flex" id="profileDropdown" href="#" data-toggle="dropdown">
                    @if (Auth::user()->avatar)
                        <img class="mr-2 nav-profile-img" alt=""
                            src="{{ asset('storage/' . Auth::user()->avatar) }}" />
                    @else
                        <img src="{{ asset('/img/avatar-default.png') }}" alt="Default Avatar"
                            class="mr-2 nav-profile-img">
                    @endif
                    {{ Auth::user()->name }}
                </a>
                <div class="dropdown-menu navbar-dropdown w-150" aria-labelledby="profileDropdown">
                    <a class="dropdown-item" href="{{ route('admin.profile.edit') }}">
                        <i class="mdi mdi-information-outline text-success"></i>
                        {{ __('messages.profile') }}
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a class="dropdown-item" href="{{route('logout')}}" onclick="event.preventDefault(); this.closest('form').submit();">
                            <i class="mr-2 mdi mdi-logout text-primary"></i>
                            {{ __('messages.signout') }}
                        </a>
                    </form>

                </div>
            </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
            data-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
        </button>
    </div>
</nav>
