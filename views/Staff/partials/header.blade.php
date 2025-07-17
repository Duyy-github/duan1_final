<div class="page-header">
    <div class="header-wrapper">
        <div class="header-logo-wrapper">
            <a href="#">
                <i class="bi bi-shop fs-3"></i>
                <span class="ms-2 fw-bold">ADMIN</span>
            </a>
        </div>

        <div class="nav-right">
            <ul class="nav-menus">
                <li class="onhover-dropdown">
                    <a href="#" class="notification-box position-relative">
                        <i class="bi bi-bell fs-5"></i>
                        <span class="badge rounded-pill bg-primary position-absolute">0</span>
                    </a>
                    <ul class="notification-dropdown">
                        <li class="fw-bold"><i class="bi bi-bell me-2"></i> Notifications</li>
                        {{-- <li><i class="bi bi-circle-fill text-primary me-2"></i>Delivery processing <span class="float-end">10 min</span></li>
                        <li><i class="bi bi-circle-fill text-success me-2"></i>Order Complete <span class="float-end">1 hr</span></li>
                        <li><i class="bi bi-circle-fill text-info me-2"></i>Tickets Generated <span class="float-end">3 hr</span></li>
                        <li><i class="bi bi-circle-fill text-danger me-2"></i>Delivery Complete <span class="float-end">6 hr</span></li>
                        <li><a class="btn btn-primary btn-sm w-100 mt-2" href="#">Check all notifications</a></li> --}}
                    </ul>
                </li>

                <li>
                    <a href="#" class="theme-toggle"><i class="bi bi-moon fs-5"></i></a>
                </li>

                <li class="onhover-dropdown">
                    <a href="#" class="profile-media d-flex align-items-center">
                        <i class="bi bi-person-circle fs-4"></i>
                        <div class="user-name-hide ms-2">
                            <span>Quản trị viên</span>
                            <p class="mb-0">Admin <i class="bi bi-caret-down-fill"></i></p>
                        </div>
                    </a>
                    <ul class="profile-dropdown">
                        {{-- <li><a href="#"><i class="bi bi-people me-2"></i> Users</a></li> --}}
                        <li><a href="#"><i class="bi bi-archive me-2"></i> Orders</a></li>
                        <li><a href="#"><i class="bi bi-telephone me-2"></i> Support Tickets</a></li>
                        <li><a href="#"><i class="bi bi-gear me-2"></i> Settings</a></li>
                        <li><a href="#"><i class="bi bi-box-arrow-right me-2"></i> Log out</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>

<style>
    .page-header {
        background: linear-gradient(145deg, #ffffff, #f8fafc);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        padding: 12px 24px;
        border-bottom: 1px solid #e5e7eb;
    }

    .header-wrapper {
        display: flex;
        align-items: center;
        justify-content: space-between;
        max-width: 1400px;
        margin: 0 auto;
    }

    .header-logo-wrapper a {
        display: flex;
        align-items: center;
        gap: 12px;
        text-decoration: none;
        color: #1f2937;
        font-size: 1.5rem;
        font-weight: 700;
        transition: color 0.2s ease;
    }

    .header-logo-wrapper a:hover {
        color: #3b82f6;
    }

    .nav-right {
        display: flex;
        align-items: center;
    }

    .nav-menus {
        display: flex;
        align-items: center;
        list-style: none;
        margin: 0;
        padding: 0;
        gap: 24px;
    }

    .nav-menus li {
        position: relative;
    }

    .notification-box, .theme-toggle, .profile-media {
        color: #4b5563;
        transition: color 0.2s ease;
    }

    .notification-box:hover, .theme-toggle:hover, .profile-media:hover {
        color: #3b82f6;
    }

    .notification-dropdown,
    .profile-dropdown {
        display: none;
        position: absolute;
        top: 100%;
        right: 0;
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 12px;
        min-width: 240px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        z-index: 1000;
        opacity: 0;
        transform: translateY(10px);
        transition: opacity 0.2s ease, transform 0.2s ease;
    }

    .onhover-dropdown:hover .notification-dropdown,
    .onhover-dropdown:hover .profile-dropdown {
        display: block;
        opacity: 1;
        transform: translateY(0);
    }

    .notification-dropdown li,
    .profile-dropdown li {
        padding: 8px 12px;
        font-size: 0.9rem;
        color: #1f2937;
    }

    .notification-dropdown li:hover,
    .profile-dropdown li:hover {
        background: #f1f5f9;
        border-radius: 6px;
    }

    .notification-box .badge {
        top: -8px;
        right: -8px;
        font-size: 0.75rem;
        padding: 2px 6px;
        transform: none;
    }

    .profile-media {
        text-decoration: none;
        color: #1f2937;
    }

    .user-name-hide span {
        font-weight: 600;
        font-size: 1rem;
    }

    .user-name-hide p {
        font-size: 0.85rem;
        color: #6b7280;
    }

    .profile-dropdown a,
    .notification-dropdown a {
        display: flex;
        align-items: center;
        color: #1f2937;
        text-decoration: none;
        transition: color 0.2s ease;
    }

    .profile-dropdown a:hover,
    .notification-dropdown a:hover {
        color: #3b82f6;
    }

    .btn-primary {
        background-color: #3b82f6;
        border-color: #3b82f6;
        transition: background-color 0.2s ease;
    }

    .btn-primary:hover {
        background-color: #2563eb;
        border-color: #2563eb;
    }
</style>