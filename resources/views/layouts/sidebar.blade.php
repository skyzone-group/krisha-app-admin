{{--Left sidebar--}}
<nav class="mt-2">

    <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
        @canany([
          'permission.show',
          'roles.show',
          'user.show'
       ])
            <li class="nav-item has-treeview">
                <a href="#" class="nav-link {{ (Request::is('permission*') || Request::is('role*') || Request::is('user*')) ? 'active':''}}">
                    <i class="fas fa-users-cog"></i>
                    <p>
                        @lang('cruds.userManagement.title')
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview" style="display: {{ (Request::is('permission*') || Request::is('role*') || Request::is('user*')) ? 'block':'none'}};">
                    @can('permission.show')
                        <li class="nav-item">
                            <a href="{{ route('permissionIndex') }}" class="nav-link {{ Request::is('permission*') ? "active":'' }}">
                                <i class="fas fa-key"></i>
                                <p> @lang('cruds.permission.title_singular')</p>
                            </a>
                        </li>
                    @endcan

                    @can('roles.show')
                        <li class="nav-item">
                            <a href="{{ route('roleIndex') }}" class="nav-link {{ Request::is('role*') ? "active":'' }}">
                                <i class="fas fa-user-lock"></i>
                                <p> @lang('cruds.role.fields.roles')</p>
                            </a>
                        </li>
                    @endcan

                    @can('user.show')
                        <li class="nav-item">
                            <a href="{{ route('userIndex') }}" class="nav-link {{ Request::is('user*') ? "active":'' }}">
                                <i class="fas fa-user-friends"></i>
                                <p> @lang('cruds.user.title')</p>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcanany
{{--        @can('api-user.view')--}}
{{--            <li class="nav-item">--}}
{{--                <a href="{{ route('api-userIndex') }}" class="nav-link {{ Request::is('api-users*') ? "active":'' }}">--}}
{{--                    <i class="fas fa-cog"></i>--}}
{{--                    <sub><i class="fas fa-child"></i></sub>--}}
{{--                    <p> API Users</p>--}}
{{--                </a>--}}
{{--            </li>--}}
{{--        @endcan--}}

    </ul>
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item has-treeview ">
            <a href="" class="nav-link {{ (Request::is('*region*') || Request::is('*district*') || Request::is('*quarter*')) ? "active":'' }}">
                <i class="fas fa-angle-right"></i>
                <p>
                    @lang('global.places')
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview pl-3" style="display: {{ (Request::is('*region*') || Request::is('*district*') || Request::is('*quarter*')) ? "block":'none' }}">
                <li class="nav-item">
                    <a href="{{ route('regionIndex') }}" class="nav-link {{ Request::is('*region*') ? "active":'' }}">
                        <i class="fas fa-angle-right"></i>
                        <p> @lang('cruds.region.title')</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('districtIndex') }}" class="nav-link {{ Request::is('*district*') ? "active":'' }}">
                        <i class="fas fa-angle-right"></i>
                        <p> @lang('cruds.district.title')</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('quarterIndex') }}" class="nav-link {{ Request::is('*quarter*') ? "active":'' }}">
                        <i class="fas fa-angle-right"></i>
                        <p> @lang('cruds.quarter.title')</p>
                    </a>
                </li>
            </ul>
        </li>
    </ul>

    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item has-treeview ">
            <a href="" class="nav-link {{ (Request::is('*/item*')) ? "active":'' }}">
                <i class="fas fa-angle-right"></i>
                <p>
                    @lang('global.items')
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview pl-3" style="display: {{ (Request::is('*/item*') || Request::is('*key*')) ? "block":'none' }}">
                <li class="nav-item">
                    <a href="{{ route('itemIndex') }}" class="nav-link {{ (Request::is('*/item*')) ? "active":'' }}">
                        <i class="fas fa-angle-right"></i>
                        <p> @lang('cruds.item.title')</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('keyIndex') }}" class="nav-link {{ Request::is('*key*') ? "active":'' }}">
                        <i class="fas fa-angle-right"></i>
                        <p> @lang('cruds.key.title')</p>
                    </a>
                </li>
            </ul>
        </li>
    </ul>


    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item has-treeview ">
            <a href="" class="nav-link {{ (Request::is('*story-categor*') || Request::is('*story-item*')) ? "active":'' }}">
                <i class="fas fa-angle-right"></i>
                <p>
                    @lang('cruds.story.title')
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview pl-3" style="display: {{ (Request::is('*story-categor*') || Request::is('*story-item*')) ? "block":'none' }}">
                <li class="nav-item">
                    <a href="{{ route('story-categoryIndex') }}" class="nav-link {{ (Request::is('*story-categor*')) ? "active":'' }}">
                        <i class="fas fa-angle-right"></i>
                        <p> @lang('cruds.story-category.title')</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('story-itemIndex') }}" class="nav-link {{ (Request::is('*story-item*')) ? "active":'' }}">
                        <i class="fas fa-angle-right"></i>
                        <p> @lang('cruds.story-item.title')</p>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item">
            <a href="{{ route('special-tagIndex') }}" class="nav-link {{ (Request::is('*special-tag*')) ? "active":'' }}">
                <i class="fas fa-angle-right"></i>
                <p> @lang('cruds.special-tag.title')</p>
            </a>
        </li>

    </ul>

    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item has-treeview ">
            <a href="" class="nav-link {{ (Request::is('*/developer*')) ? "active":'' }}">
                <i class="fas fa-angle-right"></i>
                <p>
                    @lang('cruds.sidebar-jk.title')
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview pl-3" style="display: {{ (Request::is('*/developer*') || Request::is('*developer*')) ? "block":'none' }}">
                <li class="nav-item">
                    <a href="{{ route('developerIndex') }}" class="nav-link {{ (Request::is('*/developer*')) ? "active":'' }}">
                        <i class="fas fa-angle-right"></i>
                        <p> @lang('cruds.developer.title')</p>
                    </a>
                </li>
{{--                <li class="nav-item">--}}
{{--                    <a href="{{ route('keyIndex') }}" class="nav-link {{ Request::is('*key*') ? "active":'' }}">--}}
{{--                        <i class="fas fa-angle-right"></i>--}}
{{--                        <p> @lang('cruds.key.title')</p>--}}
{{--                    </a>--}}
{{--                </li>--}}
            </ul>
        </li>
    </ul>


    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item has-treeview">
            <a href="" class="nav-link">
            <i class="fas fa-palette"></i>
            <p>
                @lang('global.theme')
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>
            <ul class="nav nav-treeview" style="display: none">
                <li class="nav-item">
                    <a href="{{ route('userSetTheme',[auth()->id(),'theme' => 'default']) }}" class="nav-link">
                        <i class="nav-icon fas fa-circle text-info"></i>
                        <p class="text">Default {{ auth()->user()->theme == 'default' ? '✅':'' }}</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('userSetTheme',[auth()->id(),'theme' => 'light']) }}" class="nav-link">
                        <i class="nav-icon fas fa-circle text-white"></i>
                        <p>Light {{ auth()->user()->theme == 'light' ? '✅':'' }}</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('userSetTheme',[auth()->id(),'theme' => 'dark']) }}" class="nav-link">
                        <i class="nav-icon fas fa-circle text-gray"></i>
                        <p>Dark {{ auth()->user()->theme == 'dark' ? '✅':'' }}</p>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
{{--    @can('card.main')--}}

{{--    @endcan--}}
</nav>
