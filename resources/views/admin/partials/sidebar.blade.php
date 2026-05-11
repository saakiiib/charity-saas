<div class="app-menu navbar-menu">
    <div class="navbar-brand-box">
        @if(session('managing_tenant'))
            <a href="{{ route('tenant.manage', session('managing_tenant')) }}" class="logo">
                <span class="text-white fw-bold fs-6">{{ session('managing_tenant_name') }}</span>
            </a>
        @else
            <a href="{{ route('dashboard') }}" class="logo">
                <span class="text-white fw-bold fs-6">{{ config('app.name') }}</span>
            </a>
        @endif
    </div>

    <div id="scrollbar">
        <div class="container-fluid">
            <div id="two-column-menu"></div>
            <ul class="navbar-nav" id="navbar-nav">

                @if(session('managing_tenant'))

                    <li class="nav-item">
                        <a href="{{ route('tenant.manage.exit') }}" class="nav-link text-warning">
                            <i class="ri-shut-down-line"></i>
                            <span>Exit to Charities</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('companyDetails.index') }}"
                           class="nav-link {{ Route::is('companyDetails.index') ? 'active' : '' }}">
                            <i class="ri-building-line"></i>
                            <span>Company Details</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('theme.index') }}"
                        class="nav-link {{ Route::is('theme.index') ? 'active' : '' }}">
                            <i class="ri-palette-line"></i>
                            <span>Theme Settings</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('master.index') }}"
                           class="nav-link {{ Route::is('master.index') ? 'active' : '' }}">
                            <i class="ri-file-list-3-line"></i>
                            <span>Master Contents</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('sections.index') }}"
                        class="nav-link {{ Route::is('sections.index') ? 'active' : '' }}">
                            <i class="ri-layout-grid-line"></i>
                            <span>Section Contents</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('slider.index') }}"
                           class="nav-link {{ Route::is('slider.index') ? 'active' : '' }}">
                            <i class="ri-image-line"></i>
                            <span>Sliders</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('post.index') }}"
                           class="nav-link {{ Route::is('post.index') ? 'active' : '' }}">
                            <i class="ri-article-line"></i>
                            <span>Updates</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('testimonial.index') }}"
                        class="nav-link {{ Route::is('testimonial.index') ? 'active' : '' }}">
                            <i class="ri-chat-quote-line"></i>
                            <span>Testimonials</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('gallery.index') }}"
                        class="nav-link {{ Route::is('gallery.index') ? 'active' : '' }}">
                            <i class="ri-image-line"></i>
                            <span>Gallery</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('service.index') }}"
                        class="nav-link {{ Route::is('service.index') ? 'active' : '' }}">
                            <i class="ri-service-line"></i>
                            <span>Services</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('faq.index') }}"
                        class="nav-link {{ Route::is('faq.index') ? 'active' : '' }}">
                            <i class="ri-question-answer-line"></i>
                            <span>FAQs</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('contacts.index') }}"
                        class="nav-link {{ Route::is('contacts.index') ? 'active' : '' }}">
                            <i class="ri-contacts-book-line"></i>
                            <span>Contacts</span>
                        </a>
                    </li>

                    <li class="nav-item" style="margin-bottom: 200px"></li>

                @else

                    <li class="nav-item">
                        <a href="{{ route('tenant.index') }}"
                           class="nav-link {{ Route::is('tenant.index') ? 'active' : '' }}">
                            <i class="ri-account-circle-line"></i>
                            <span>Charities</span>
                        </a>
                    </li>

                    <li class="nav-item" style="margin-bottom: 200px"></li>

                @endif

            </ul>
        </div>
    </div>
</div>