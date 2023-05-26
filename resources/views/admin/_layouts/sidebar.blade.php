<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">
    <?php
    $authorizationService = new \App\Http\Services\AuthorizationService();
    ?>
    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">

                <li>
                    <a href="{{ route('dashboard.index') }}" class="waves-effect">
                        <i class="bx bxs-user-detail"></i>
                        <span key="t-all-devices">Tüm Cihazlar</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('report.index') }}" class="waves-effect">
                        <i class="bx bxs-user-detail"></i>
                        <span key="t-report">Rapor</span>
                    </a>
                </li>

                <li class="menu-title" key="t-bag">ÇANTA CİHAZLARI</li>

                <li>
                    <a href="{{ route('bag-device-summary') }}" class="waves-effect">
                        <i class="bx bxs-user-detail"></i>
                        <span key="t-bag-device-types">Cihaz Özeti</span>
                    </a>
                </li>

                @if($authorizationService->setName('Çanta Cihaz Tipi')->canDisplay(true))
                <li>
                    <a href="{{ route('bag-device-types.index') }}" class="waves-effect">
                        <i class="bx bxs-user-detail"></i>
                        <span key="t-bag-device-types">Cihaz Tipleri</span>
                    </a>
                </li>
                @endif

                @if($authorizationService->setName('Çanta Cihazı')->canDisplay(true))
                <li>
                    <a href="{{ route('bag-devices.index') }}" class="waves-effect">
                        <i class="bx bxs-user-detail"></i>
                        <span key="t-bag-devices">Cihazlar</span>
                    </a>
                </li>
                @endif
                @if($authorizationService->setName('Data Kartı')->canDisplay(true))
                <li>
                    <a href="{{ route('data-cards.index') }}" class="waves-effect">
                        <i class="bx bxs-user-detail"></i>
                        <span key="t-data-cards">Data Kartlar</span>
                    </a>
                </li>
                @endif

                <li class="menu-title" key="t-env">ÇEVRE CİHAZLARI</li>

                <li>
                    <a href="{{ route('env-device-summary') }}" class="waves-effect">
                        <i class="bx bxs-user-detail"></i>
                        <span key="t-env-device-types">Cihaz Özeti</span>
                    </a>
                </li>

                @if($authorizationService->setName('Çevre Cihazı')->canDisplay(true))
                <li>
                    <a href="{{ route('env-devices.index') }}" class="waves-effect">
                        <i class="bx bxs-user-detail"></i>
                        <span key="t-env-devices">Cihazlar</span>
                    </a>
                </li>
                @endif

                @if(
                    $authorizationService->setName('Bölge')->canDisplay(true) ||
                    $authorizationService->setName('Kullanıcı')->canDisplay(true) ||
                    $authorizationService->setName('Yetki')->canDisplay(true)
                )
                    <li class="menu-title" key="t-other">DİĞER</li>

                    @if($authorizationService->setName('Bölge')->canDisplay(true))
                    <li>
                        <a href="{{ route('regions.index') }}" class="waves-effect">
                            <i class="bx bxs-user-detail"></i>
                            <span key="t-regions">Bölgeler</span>
                        </a>
                    </li>
                    @endif

                    @if($authorizationService->setName('Kullanıcı')->canDisplay(true))
                    <li>
                        <a href="{{ route('users.index') }}" class="waves-effect">
                            <i class="bx bxs-user-detail"></i>
                            <span key="t-users">Kullanıcılar</span>
                        </a>
                    </li>
                    @endif

                    @if($authorizationService->setName('Yetki')->canDisplay(true))
                    <li>
                        <a href="{{ route('roles.index') }}" class="waves-effect">
                            <i class="bx bxs-user-detail"></i>
                            <span key="t-roles">Yetkiler</span>
                        </a>
                    </li>
                    @endif
                @endif

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
