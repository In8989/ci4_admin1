<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="/master/main" class="app-brand-link">
            <span class="app-brand-text demo menu-text fw-bolder ms-2">Sneat</span>
        </a>
        <a href="/master/login/logout">
            <span class="ms-5"><i class="bx bx-power-off me-2"></i></span>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item <?php if (url_is('master/main*')) echo 'active' ?>">
            <a href="/master/main" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>

        <li class="menu-item <?php if (url_is('master/member*')) echo 'active' ?>">
            <a href="/master/member" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Member</div>
            </a>
        </li>

        <li class="menu-item <?php if (url_is('master/company*')) echo 'active' ?>">
            <a href="/master/company" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Company</div>
            </a>
        </li>


        <!-- Layouts -->

    </ul>
</aside>
