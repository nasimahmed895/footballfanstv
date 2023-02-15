<nav class="navbar navbar-header navbar-expand-lg" color="blue2">
    <div class="container-fluid">
        <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
            <li class="nav-item dropdown hidden-caret">
                <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
                    <div class="avatar-sm">
                        <img src="{{ asset(user()->image) }}" alt="..." class="avatar-img rounded-circle">
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-user animated fadeIn">
                    <div class="dropdown-user-scroll scrollbar-outer">
                        <li>
                            <div class="user-box">
                                <div class="avatar-lg"><img src="{{ asset(user()->image) }}"
                                        alt="{{ _lang('image profile') }}" class="avatar-img rounded">
                                </div>
                                <div class="u-text pt-2">
                                    <h4>{{ user()->name }}</h4>
                                    <p class="text-muted">{{ user()->email }}</p>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item ajax-modal" href="{{ url('profile/show') }}"
                                data-title="{{ _lang('Profile Details') }}">{{ _lang('My Profile') }}</a>
                            <a class="dropdown-item ajax-modal" href="{{ url('profile/edit') }}"
                                data-title="{{ _lang('Edit Profile') }}">{{ _lang('Edit Profile') }}</a>
                            <a class="dropdown-item ajax-modal" href="{{ url('password/change') }}"
                                data-title="{{ _lang('Change Password') }}">{{ _lang('Change Password') }}</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ url('logout') }}">{{ _lang('Logout') }}</a>
                        </li>
                    </div>
                </ul>
            </li>
        </ul>
    </div>
</nav>
