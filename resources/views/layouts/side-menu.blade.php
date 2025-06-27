<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
    <a href="index.html" class="app-brand-link">
      {{--   <span class="app-brand-logo demo">
        <svg width="32" height="22" viewBox="0 0 32 22" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
            fill-rule="evenodd"
            clip-rule="evenodd"
            d="M0.00172773 0V6.85398C0.00172773 6.85398 -0.133178 9.01207 1.98092 10.8388L13.6912 21.9964L19.7809 21.9181L18.8042 9.88248L16.4951 7.17289L9.23799 0H0.00172773Z"
            fill="#7367F0" />
            <path
            opacity="0.06"
            fill-rule="evenodd"
            clip-rule="evenodd"
            d="M7.69824 16.4364L12.5199 3.23696L16.5541 7.25596L7.69824 16.4364Z"
            fill="#161616" />
            <path
            opacity="0.06"
            fill-rule="evenodd"
            clip-rule="evenodd"
            d="M8.07751 15.9175L13.9419 4.63989L16.5849 7.28475L8.07751 15.9175Z"
            fill="#161616" />
            <path
            fill-rule="evenodd"
            clip-rule="evenodd"
            d="M7.77295 16.3566L23.6563 0H32V6.88383C32 6.88383 31.8262 9.17836 30.6591 10.4057L19.7824 22H13.6938L7.77295 16.3566Z"
            fill="#7367F0" />
        </svg>
        </span>--}}
        <span class="app-brand-text demo menu-text fw-bold">TAX Collection</span>
    </a>

    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
        <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
        <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
    </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">




   @if(auth()->user()->isAdmin())

     <li class="menu-item active">
        <a href="{{route("dashboard")}}" class="menu-link">
        <i class="menu-icon tf-icons ti ti-smart-home"></i>
        <div data-i18n="Dashboard">Dashboard</div>
        </a>
    </li>

    <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons ti ti-files"></i>
        <div data-i18n="Entities">Entities</div>
        </a>
        <ul class="menu-sub">
            <li class="menu-item">
                <a href="{{route('bars')}}" class="menu-link">
                <div data-i18n="Bars">Bars</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{route('hotels')}}" class="menu-link">
                <div data-i18n="Hotel">Hotels</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{route('guest-houses')}}" class="menu-link">
                <div data-i18n="Guest Houses">Guest Houses</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{route("motels")}}" class="menu-link" target="_blank">
                <div data-i18n="Motels">Motels</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{route("event-centers")}}" class="menu-link">
                <div data-i18n="Event Centers">Event Centers</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{route("restaurants")}}" class="menu-link">
                <div data-i18n="Restaurants">Restaurants</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{route("online-drinks")}}" class="menu-link">
                <div data-i18n="Online Drinks Trading">Online Drinks Trading</div>
                </a>
            </li>

        </ul>
    </li>

    <li class="menu-item">
        <a href="{{route('get-assessment')}}" class="menu-link">
        <i class="menu-icon tf-icons ti ti-layout-kanban"></i>
        <div data-i18n="List Assessment">List Assessment</div>
        </a>
    </li>

   @elseif(auth()->user()->isManager())

     <li class="menu-item active">
        <a href="{{route("manager.dashboard")}}" class="menu-link">
        <i class="menu-icon tf-icons ti ti-smart-home"></i>
        <div data-i18n="Dashboard">Dashboard</div>
        </a>
    </li>

   @else
    <li class="menu-item">
        <a href="{{route("user.dashboard")}}" class="menu-link">
        <i class="menu-icon tf-icons ti ti-smart-home"></i>
        <div data-i18n="Dashboard">Dashboard</div>
        </a>
    </li>

    {{-- <li class="menu-item">
        <a href="{{route("profile")}}" class="menu-link">
        <i class="menu-icon tf-icons ti ti-smart-home"></i>
        <div data-i18n="Profile">Profile</div>
        </a>
    </li> --}}

    <li class="menu-item">
        <a href="{{route('assessment')}}" class="menu-link">
        <i class="menu-icon tf-icons ti ti-layout-kanban"></i>
        <div data-i18n="Tax Assessment">Add Assessment</div>
        </a>
    </li>
    <li class="menu-item">
        <a href="{{route('view-assessment')}}" class="menu-link">
        <i class="menu-icon tf-icons ti ti-layout-kanban"></i>
        <div data-i18n="List Assessments">List Assessments</div>
        </a>
    </li>



   @endif




    <li class="menu-item">
        <a href="#" target="_blank" class="menu-link">
        <i class="menu-icon tf-icons ti ti-lifebuoy"></i>
        <div data-i18n="Support">Support</div>
        </a>
    </li>
    <li class="menu-item">
        <a
        href="https://demos.pixinvent.com/vuexy-html-admin-template/documentation/"
        target="_blank"
        class="menu-link">
        <i class="menu-icon tf-icons ti ti-file-description"></i>
        <div data-i18n="Documentation">Documentation</div>
        </a>
    </li>
    </ul>
</aside>
