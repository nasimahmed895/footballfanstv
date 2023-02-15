<div class="sidebar sidebar-style-2">
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <div class="user">
                <div class="avatar-sm float-left mr-2">
                    <img src="{{ asset(user()->image) }}" alt="{{ _lang('image profile') }}" alt="..."
                        class="avatar-img rounded-circle">
                </div>
                <div class="info">
                    <a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
                        <span>
                            {{ user()->name }}
                            <span class="user-level">{{ _lang('Active Now') }}</span>
                            <span class="caret"></span>
                        </span>
                    </a>
                    <div class="clearfix"></div>
                    <div class="collapse in" id="collapseExample">
                        <ul class="nav">
                            <li>
                                <a href="{{ url('profile/show') }}" class="ajax-modal"
                                    data-title="{{ _lang('Profile Details') }}">
                                    <span class="link-collapse">{{ _lang('Profile Details') }}</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('profile/edit') }}" class="ajax-modal"
                                    data-title="{{ _lang('Edit Profile') }}">
                                    <span class="link-collapse">{{ _lang('Edit Profile') }}</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('password/change') }}" class="ajax-modal"
                                    data-title="{{ _lang('Change Password') }}">
                                    <span class="link-collapse">{{ _lang('Change Password') }}</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <ul class="nav nav-primary">
                <li class="nav-item">
                    <a href="{{ url('live_matches') }}" aria-expanded="false">
                        <i class="fas fa-desktop"></i>
                        <p>{{ _lang('Live Control') }}</p>
                    </a>
                </li>

                {{-- <li class="nav-item">
                    <a data-toggle="collapse" href="#live_control">
                        <i class="fas fa-desktop"></i>
                        <p>{{ _lang('Live Control') }}</p>
                        <span class="caret"></span>
                    </a>

                    <div class="collapse" id="live_control">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="{{ url('sports_types') }}">
                                    <span class="sub-item">{{ _lang('Sports Types') }}</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('live_matches') }}">
                                    <span class="sub-item">{{ _lang('Manage Live') }}</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li> --}}
                <li class="nav-item">
                    <a href="{{ url('highlights') }}" aria-expanded="false">
                        <i class="fas fa-file-video"></i>
                        <p>{{ _lang('Highlights') }}</p>
                    </a>
                </li>

                {{-- <li class="nav-item">
                    <a href="{{ url('apps') }}" aria-expanded="false">
                        <i class="fab fa-app-store-ios"></i>
                        <p>{{ _lang('Apps') }}</p>
                    </a>
                </li> --}}

                <li class="nav-item">
                    <a href="{{ url('manage_app') }}" aria-expanded="false">
                        <i class="fab fa-google-play"></i>
                        <p>{{ _lang('Manage App') }}</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('notifications') }}" aria-expanded="false">
                        <i class="fas fa-bell"></i>
                        <p>{{ _lang('Notifications') }}</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('promotions') }}" aria-expanded="false">
                        <i class="fas fa-bullhorn"></i>
                        <p>{{ _lang('Promotions') }}</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('users') }}" aria-expanded="false">
                        <i class="fas fa-user"></i>
                        <p>{{ _lang('Manage Users') }}</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('subscriptions') }}" aria-expanded="false">
                        <i class="fas fa-dice-four"></i>
                        <p>{{ _lang('Subscriptions') }}</p>
                    </a>
                </li>
                <!-- <li class="nav-item">
                    <a href="{{ url('payments') }}" aria-expanded="false">
                        <i class="fas fa-dollar-sign"></i>
                        <p>{{ _lang('Payments') }}</p>
                    </a>
                </li> -->
                <li class="nav-item">
                    <a href="{{ route('paypal_payment.index') }}" aria-expanded="false">
                        <i class="fab fa-paypal"></i>
                        <p>{{ _lang('Paypal Payments') }}</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('cache_clear') }}" aria-expanded="false">
                        <i class="fas fa-trash"></i>
                        <p>{{ _lang('Cache Clean') }}</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a data-toggle="collapse" href="#administration">
                        <i class="fas fa-cogs"></i>
                        <p>{{ _lang('Administration') }}</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="administration">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="{{ url('general_settings') }}">
                                    <span class="sub-item">{{ _lang('General Settings') }}</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('database_backup') }}">
                                    <span class="sub-item">{{ _lang('Database Backup') }}</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
