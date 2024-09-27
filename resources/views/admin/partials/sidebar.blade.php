<style>
    .collapse {
        visibility: unset !important;
    }
</style>
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <div class="text-center sidebar-brand-wrapper d-flex align-items-center">
        <a class="sidebar-brand brand-logo" href="{{url('/admin/dashboard')}}"><img src="/assets/images/logo.svg" alt="logo" /></a>
        <a class="pt-3 pl-4 sidebar-brand brand-logo-mini" href="index.html"><img src="/assets/images/logo-mini.svg"
                alt="logo" /></a>
    </div>
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                <i class="mdi mdi-home menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-user" aria-controls="ui-user">
                <i class="mdi mdi-account-multiple menu-icon"></i>
                <span class="menu-title">{{ __('messages.users') }}</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse {{ Request::is('admin/users*') ? 'show' : '' }}" id="ui-user">
                <ul class="nav flex-column">
                    <li class="nav-item {{ Route::currentRouteName() == 'admin.users.index' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.users.index') }}">{{ __('messages.user_list') }}</a>
                    </li>
                    <li class="nav-item {{ Route::currentRouteName() == 'admin.users.create' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.users.create') }}">{{ __('messages.add_user') }}</a>
                    </li>
                </ul>
            </div>

        </li>

        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-task" aria-controls="ui-task">
                <i class="mdi mdi-library-books menu-icon"></i>
                <span class="menu-title">{{ __('messages.tasks') }}</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse {{ Request::is('admin/tasks*') ? 'show' : '' }}" id="ui-task">
                <ul class="nav flex-column">
                    <li class="nav-item {{ Route::currentRouteName() == 'admin.tasks.index' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.tasks.index') }}">{{ __('messages.task_list') }}</a>
                    </li>
                    <li class="nav-item {{ Route::currentRouteName() == 'admin.tasks.create' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.tasks.create') }}">{{ __('messages.add_task') }}</a>
                    </li>
                </ul>
            </div>

        </li>

    </ul>
</nav>
