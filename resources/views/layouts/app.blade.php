<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - Barangay Management System</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet"/>
    
    <style>
        :root {
            --blue:       #1a6ec7;
            --blue-dark:  #154f96;
            --sky:        #d9f2fc;
            --sky-mid:    #a8dff5;
            --green:      #3a7d44;
            --green-dark: #2c5f35;
            --white:      #ffffff;
            --off-white:  #f4f8fb;
            --text:       #1a2433;
            --text-light: #4b5e72;
            --border:     rgba(26,110,199,0.12);
            --gold:       #e8b84b;
            
            /* Legacy aliases for backward compatibility */
            --primary: #1a6ec7;
            --primary-dark: #154f96;
            --primary-light: #d9f2fc;
            --secondary: #3a7d44;
            --secondary-dark: #2c5f35;
            --surface: #f4f8fb;
            --surface-2: #e3f2fd;
            --sidebar-width: 260px;
            --shadow: 0 4px 20px rgba(26, 110, 199, 0.12);
            --radius: 12px;
            --radius-lg: 20px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            height: 100%;
        }

        body {
            margin: 0;
            font-family: 'DM Sans', sans-serif;
            background: var(--surface);
            color: var(--text);
            line-height: 1.6;
        }

        .app-wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* SIDEBAR */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--white);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            z-index: 100;
            overflow-y: auto;
        }

        .sidebar-logo {
            padding: 24px 20px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logo-icon {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid var(--blue-light);
            background: var(--white);
        }

        .logo-icon img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .logo-text .logo-title {
            font-weight: 800;
            font-size: 16px;
            color: var(--text);
            line-height: 1.2;
        }

        .logo-text .logo-sub {
            font-size: 11px;
            color: var(--text-muted);
            letter-spacing: 0.3px;
            line-height: 1.2;
        }

        .sidebar-user {
            padding: 16px 20px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--blue), var(--green));
            color: white;
            font-weight: 700;
            font-size: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .user-info .user-name {
            font-weight: 600;
            font-size: 14px;
            color: var(--text);
        }

        .user-info .user-role {
            font-size: 11px;
            padding: 2px 10px;
            border-radius: 20px;
            display: inline-block;
            margin-top: 2px;
        }

        .user-role.official,
        .user-role.admin {
            background: var(--blue-light);
            color: var(--blue);
        }

        .user-role.resident {
            background: var(--green-light);
            color: var(--green);
        }

        .sidebar-nav {
            flex: 1;
            padding: 16px 12px;
            display: flex;
            flex-direction: column;
            gap: 4px;
            overflow-y: auto;
        }

        .nav-section-label {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1.5px;
            color: var(--text-muted);
            text-transform: uppercase;
            padding: 12px 10px 6px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            border-radius: var(--radius);
            color: var(--text-muted);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .nav-icon {
            font-size: 17px;
            width: 22px;
            text-align: center;
        }

        .nav-link:hover {
            background: var(--blue-light);
            color: var(--blue);
        }

        .nav-link.active {
            background: var(--blue);
            color: var(--white);
        }

        .nav-link.active:hover {
            background: var(--blue-dark);
        }

        .sidebar-footer {
            padding: 16px 20px;
            border-top: 1px solid var(--border);
            font-size: 11px;
            color: var(--text-muted);
            text-align: center;
        }

        /* MAIN CONTENT */
        .main-content {
            margin-left: var(--sidebar-width);
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* TOPBAR */
        .topbar {
            background: var(--white);
            border-bottom: 1px solid var(--border);
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 28px;
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .topbar-left .page-title {
            font-size: 18px;
            font-weight: 700;
            color: var(--text);
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .notif-btn {
            position: relative;
            background: transparent;
            border: none;
            cursor: pointer;
            font-size: 20px;
            padding: 8px;
            border-radius: 10px;
            transition: background 0.2s ease;
            color: var(--text-muted);
        }

        .notif-btn:hover {
            background: var(--blue-light);
            color: var(--blue);
        }

        .notif-badge {
            position: absolute;
            top: 4px;
            right: 4px;
            background: var(--green);
            color: white;
            font-size: 10px;
            font-weight: 700;
            min-width: 18px;
            height: 18px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 4px;
        }

        .topbar-user {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            padding: 8px 12px;
            border-radius: 10px;
            transition: background 0.2s ease;
        }

        .topbar-user:hover {
            background: var(--surface);
        }

        .topbar-user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--blue), var(--green));
            color: white;
            font-weight: 700;
            font-size: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .topbar-user-dropdown {
            display: none;
            position: absolute;
            top: 64px;
            right: 28px;
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            min-width: 200px;
            box-shadow: var(--shadow);
            z-index: 1000;
        }

        .topbar-user-dropdown.show {
            display: block;
        }

        .dropdown-item {
            display: block;
            width: 100%;
            padding: 12px 16px;
            border: none;
            background: none;
            cursor: pointer;
            text-align: left;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 14px;
            color: var(--text);
            transition: background 0.2s ease;
            border-bottom: 1px solid var(--border);
        }

        .dropdown-item:last-child {
            border-bottom: none;
        }

        .dropdown-item:hover {
            background: var(--surface);
        }

        .dropdown-item.logout {
            color: #dc3545;
        }

        /* CONTENT AREA */
        .content-area {
            padding: 28px;
            flex: 1;
        }

        /* FLASH MESSAGES */
        .alert {
            border-radius: var(--radius);
            padding: 14px 20px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 500;
            font-size: 14px;
        }

        .alert-success {
            background: var(--green-light);
            border-left: 4px solid var(--green);
            color: var(--green-dark);
        }

        .alert-error {
            background: #fce8e6;
            border-left: 4px solid #dc3545;
            color: #b91c1c;
        }
    </style>
</head>
<body>
    @php
        $sealLogo = file_exists(public_path('images/city_of_general_trias_seal.png'))
            ? asset('images/city_of_general_trias_seal.png')
            : (file_exists(public_path('images/city_of_general trias.png'))
                ? asset('images/city_of_general trias.png')
                : asset('images/city_of_general_trias.png'));
    @endphp
    <div class="app-wrapper">
        <!-- SIDEBAR -->
        <aside class="sidebar">
            <!-- Logo -->
            <div class="sidebar-logo">
                <div class="logo-icon">
                    <img src="{{ $sealLogo }}" alt="City of General Trias Seal">
                </div>
                <div class="logo-text">
                    <div class="logo-title">Barangay</div>
                    <div class="logo-sub">SYSTEM</div>
                </div>
            </div>

            <!-- User Info -->
            @auth
            <div class="sidebar-user">
                <div class="user-avatar">{{ substr(auth()->user()->name, 0, 1) }}</div>
                <div class="user-info">
                    <div class="user-name">{{ auth()->user()->name }}</div>
                    <div class="user-role {{ strtolower(auth()->user()->role) }}">
                        {{ ucfirst(auth()->user()->role) }}
                    </div>
                </div>
            </div>
            @endauth

            <!-- Navigation -->
            <nav class="sidebar-nav">
                @auth
                    @if(auth()->user()->role === 'resident')
                        <div class="nav-section-label">Main</div>
                        <a href="{{ route('resident.dashboard') }}" class="nav-link {{ request()->is('resident/dashboard') ? 'active' : '' }}">
                            <span class="nav-icon">🏠</span>
                            <span>Dashboard</span>
                        </a>
                        <a href="{{ route('resident.profile') }}" class="nav-link {{ request()->is('resident/profile') ? 'active' : '' }}">
                            <span class="nav-icon">👤</span>
                            <span>My Profile</span>
                        </a>
                        <a href="{{ route('resident.online-id') }}" class="nav-link {{ request()->is('resident/online-id') ? 'active' : '' }}">
                            <span class="nav-icon">🪪</span>
                            <span>Online ID</span>
                        </a>
                        <a href="{{ route('resident.notifications') }}" class="nav-link {{ request()->is('resident/notifications') ? 'active' : '' }}">
                            <span class="nav-icon">🔔</span>
                            <span>Notifications</span>
                        </a>

                    @elseif(auth()->user()->role === 'official')
                        <div class="nav-section-label">Main</div>
                        <a href="{{ route('official.dashboard') }}" class="nav-link {{ request()->is('official/dashboard') ? 'active' : '' }}">
                            <span class="nav-icon">📊</span>
                            <span>Dashboard</span>
                        </a>
                        <a href="{{ route('official.residents.index') }}" class="nav-link {{ request()->is('official/residents*') ? 'active' : '' }}">
                            <span class="nav-icon">👥</span>
                            <span>Residents</span>
                        </a>
                        <a href="{{ route('official.announcements.index') }}" class="nav-link {{ request()->is('official/announcements*') ? 'active' : '' }}">
                            <span class="nav-icon">📢</span>
                            <span>Announcements</span>
                        </a>
                        <a href="{{ route('official.notifications.create') }}" class="nav-link {{ request()->is('official/notifications*') ? 'active' : '' }}">
                            <span class="nav-icon">🔔</span>
                            <span>Send Notification</span>
                        </a>
                        <a href="{{ route('official.chat.index') }}" class="nav-link {{ request()->is('official/chat*') ? 'active' : '' }}">
                            <span class="nav-icon">💬</span>
                            <span>Resident Chat</span>
                        </a>
                        <a href="{{ route('official.profile') }}" class="nav-link {{ request()->is('official/profile') ? 'active' : '' }}">
                            <span class="nav-icon">👤</span>
                            <span>My Profile</span>
                        </a>

                    @elseif(auth()->user()->role === 'admin')
                        <div class="nav-section-label">Main</div>
                        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                            <span class="nav-icon">📊</span>
                            <span>Dashboard</span>
                        </a>
                        <a href="{{ route('admin.officials.index') }}" class="nav-link {{ request()->is('admin/officials*') ? 'active' : '' }}">
                            <span class="nav-icon">👮</span>
                            <span>Officials</span>
                        </a>
                    @endif
                @endauth
            </nav>

            <!-- Footer -->
            <div class="sidebar-footer">
                <p>Barangay System v1.0</p>
            </div>
        </aside>

        <!-- MAIN CONTENT -->
        <div class="main-content">
            <!-- TOPBAR -->
            <div class="topbar">
                <div class="topbar-left">
                    <div class="page-title">@yield('title')</div>
                </div>

                <div class="topbar-right">
                    @auth
                        @if(auth()->user()->role === 'resident')
                            <button class="notif-btn" onclick="window.location.href='{{ route('resident.notifications') }}'">
                                🔔
                                @php
                                    $unreadCount = App\Models\Notification::where('user_id', auth()->id())
                                        ->where('is_read', false)
                                        ->count();
                                @endphp
                                @if($unreadCount > 0)
                                    <span class="notif-badge">{{ $unreadCount }}</span>
                                @endif
                            </button>
                        @endif

                        <div class="topbar-user" onclick="toggleUserDropdown()">
                            <div class="topbar-user-avatar">{{ substr(auth()->user()->getFullName(), 0, 1) }}</div>
                            <span style="font-size: 14px; font-weight: 500; color: var(--text);">{{ auth()->user()->getFullName() }}</span>
                        </div>

                        <div class="topbar-user-dropdown" id="userDropdown">
                            <button class="dropdown-item" onclick="window.location.href='{{ auth()->user()->role === 'resident' ? route('resident.profile') : (auth()->user()->role === 'official' ? route('official.profile') : '#') }}'">
                                👤 Profile
                            </button>
                            <form action="{{ route('logout') }}" method="POST" style="width: 100%;">
                                @csrf
                                <button type="submit" class="dropdown-item logout" style="width: 100%;">
                                    🚪 Logout
                                </button>
                            </form>
                        </div>
                    @endauth
                </div>
            </div>

            <!-- CONTENT AREA -->
            <div class="content-area">
                <!-- Flash Messages -->
                @if($errors->any())
                    <div class="alert alert-error">
                        <span style="font-size: 16px;">⚠️</span>
                        <div>
                            <strong>Validation Error</strong>
                            @foreach($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if(session('success'))
                    <div class="alert alert-success">
                        <span style="font-size: 16px;">✓</span>
                        <div>{{ session('success') }}</div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-error">
                        <span style="font-size: 16px;">✕</span>
                        <div>{{ session('error') }}</div>
                    </div>
                @endif

                <!-- Page Content -->
                @yield('content')
            </div>
        </div>
    </div>

    <script>
        function toggleUserDropdown() {
            const dropdown = document.getElementById('userDropdown');
            dropdown.classList.toggle('show');
            
            // Close dropdown when clicking outside
            document.addEventListener('click', function(event) {
                const topbarUser = event.target.closest('.topbar-user');
                if (!topbarUser) {
                    dropdown.classList.remove('show');
                }
            });
        }
    </script>
</body>
</html>
