<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <div id="sidebar-menu">
            <ul class="metismenu list-unstyled" id="side-menu">

                {{-- Dashboard --}}
                <li>
                    <a href="{{ route('dashboard') }}">
                        <i class="bi bi-house-door"></i>
                        <span data-key="t-dashboard">Dashboard</span>
                    </a>
                </li>


                <li class="menu-title" data-key="t-menu">User Management</li>
                @if (is_module_enabled('Users'))
                    @canany(['user.index', 'user.create', 'user.edit', 'user.delete', 'user.show', 'role.index',
                        'permission.index'])
                        @if (is_module_enabled('Users'))
                            @canany(['user.index', 'user.create', 'user.edit', 'user.delete', 'user.show'])
                                <li>
                                    <a href="javascript: void(0);" class="has-arrow">
                                        <i class="bi bi-people"></i>
                                        <span data-key="t-users">Users</span>
                                    </a>
                                    <ul class="sub-menu" aria-expanded="false">
                                        @can('user.index')
                                            <li>
                                                <a href="{{ route('users.index') }}">
                                                    <span data-key="t-all-users">All Users</span>
                                                </a>
                                            </li>
                                        @endcan
                                    </ul>
                                </li>
                            @endcanany
                        @endif

                        @if (is_module_enabled('UserRoles'))
                            @canany(['role.index', 'permission.index'])
                                <li>
                                    <a href="javascript: void(0);" class="has-arrow">
                                        <i class="bi bi-shield-lock"></i>
                                        <span data-key="t-access-role">Access Control</span>
                                    </a>
                                    <ul class="sub-menu" aria-expanded="false">
                                        @can('role.index')
                                            <li><a href="{{ route('roles.index') }}"><span data-key="t-roles">Roles</span></a></li>
                                        @endcan
                                        @can('permission.index')
                                            <li><a href="{{ route('permissions.index') }}"><span
                                                        data-key="t-permissions">Permissions</span></a></li>
                                        @endcan
                                    </ul>
                                </li>
                            @endcanany
                        @endif
                    @endcanany
                @endif

                <li class="menu-title" data-key="t-menu">Content Management</li>
                
                {{-- Site Builder --}}
                @if (is_module_enabled('PageBuilder'))
                    @canany(['pages.index', 'components.index', 'pages.create'])
                        <li>
                            <a href="javascript: void(0);" class="has-arrow">
                                <i class="bi bi-layout-text-window"></i>
                                <span data-key="t-pages">Site Builder</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                @can('pages.index')
                                    <li>
                                        <a href="{{ route('pages.index') }}">
                                            <i class="bi bi-file-earmark-richtext"></i>
                                            <span data-key="t-page-manage">Page Manage</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcanany
                @endif
                @if (is_module_enabled('Blog'))
                    @canany(['post.index', 'post.create', 'post.edit', 'post.delete', 'post.show', 'category.index',
                        'tag.index'])
                        <li>
                            <a href="javascript: void(0);" class="has-arrow">
                                <i class="bi bi-journal-text"></i>
                                <span data-key="t-blogs">Blogs</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                @canany(['post.index', 'post.create', 'post.edit', 'post.delete', 'post.show'])
                                    <li>
                                        <a href="{{ route('posts.index') }}">
                                            <i class="bi bi-file-earmark-text"></i>
                                            <span data-key="t-posts">Posts</span>
                                        </a>
                                    </li>
                                @endcanany

                                @canany(['category.index', 'category.create', 'category.edit', 'category.delete',
                                    'category.show'])
                                    <li>
                                        <a href="{{ route('categories.index') }}">
                                            <i class="bi bi-grid"></i>
                                            <span data-key="t-categories">Categories</span>
                                        </a>
                                    </li>
                                @endcanany

                                @canany(['tag.index', 'tag.create', 'tag.edit', 'tag.delete', 'tag.show'])
                                    <li>
                                        <a href="{{ route('tags.index') }}">
                                            <i class="bi bi-tags"></i>
                                            <span data-key="t-tags">Tags</span>
                                        </a>
                                    </li>
                                @endcanany
                            </ul>
                        </li>
                    @endcanany
                @endif

                @if (is_module_enabled('Events'))
                    @can('event.index')
                        <li>
                            <a href="{{ route('events.index') }}">
                                <i class="bi bi-calendar-event"></i>
                                <span data-key="t-events">Events</span>
                            </a>
                        </li>
                    @endcan
                @endif

                {{-- @if (is_module_enabled('Cases')) --}}
                @can('cases.index')
                    <li>
                        <a href="{{ route('cases.index') }}">
                            {{-- <i class="bi bi-folder"></i> --}}
                            <i class="fas fa-file-medical-alt"></i>
                            <span data-key="t-cases">Cases</span>
                        </a>
                    </li>
                @endcan
                {{-- @endif --}}




                <li class="menu-title" data-key="t-menu">Applications</li>
                {{-- Contact --}}
                @if (is_module_enabled('Contact'))
                    @can('contact.index')
                        <li>
                            <a href="{{ route('contact.index') }}">
                                <i class="bi bi-envelope-open"></i>
                                <span data-key="t-contacts">Contacts</span>
                            </a>
                        </li>
                    @endcan
                @endif
                {{-- Newsletters --}}
                @if (is_module_enabled('Newsletter'))
                    @can('newsletter.index')
                        <li>
                            <a href="{{ route('admin.newsletters.index') }}">
                                <i class="bi bi-envelope-paper me-2"></i>
                                <span data-key="t-menus">Newsletter</span>
                            </a>
                        </li>
                    @endcan
                @endif



                <li class="menu-title" data-key="t-menu">Others</li>
                @if (is_module_enabled('Media'))
                    @can('media.index')
                        <li>
                            <a href="{{ route('media.index') }}">
                                <i class="bi bi-image"></i>
                                <span data-key="t-gallery">Gallery</span>
                            </a>
                        </li>
                    @endcan
                @endif

                @can('setting.index')
                    <li>
                        <a href="{{ route('setting.index') }}">
                            <i class="bi bi-gear"></i>
                            <span data-key="t-settings">Settings</span>
                        </a>
                    </li>
                @endcan

                @if (is_module_enabled('Menu'))
                    @can('menu.index')
                        <li>
                            <a href="{{ route('admin.menus.index') }}">
                                <i class="bi bi-list-ul"></i>
                                <span data-key="t-menus">Menus</span>
                            </a>
                        </li>
                    @endcan
                @endif

                {{-- @if (is_module_enabled('UrlRedirector')) --}}
                @can('urlredirector.index')
                    <li>
                        <a href="{{ route('urlredirector.index') }}">
                            <i class="bi bi-link-45deg fs-2"></i>
                            <span data-key="t-urlredirector">Url Redirector</span>
                        </a>
                    </li>
                @endcan
                {{-- @endif --}}
            </ul>
        </div>
    </div>
</div>
<!-- ========== Left Sidebar End ========== -->
