<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - Barangay Service Portal</title>
    
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

            /* Backward compatibility with old variable names */
            --primary: #1a6ec7;
            --primary-dark: #154f96;
            --primary-light: #d9f2fc;
            --secondary: #3a7d44;
            --secondary-dark: #2c5f35;
            --secondary-light: rgba(58,125,68,0.12);
            --accent: #e8b84b;
            --accent-light: #fef3c7;
            --gray-50: #f4f8fb;
            --gray-100: #eff2f5;
            --gray-200: #dfe5eb;
            --gray-300: #c8d5e0;
            --gray-400: #9ca3af;
            --gray-500: #4b5e72;
            --gray-600: #4b5e72;
            --gray-700: #1a2433;
            --gray-800: #1a2433;
            --gray-900: #1a2433;
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html { scroll-behavior: smooth; }

        body {
            font-family: 'DM Sans', sans-serif;
            color: var(--text);
            background: var(--white);
            overflow-x: hidden;
        }

        /* ── HEADER ──────────────────────────────── */
        header, .top-nav {
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 1000;
            background: rgba(255,255,255,0.96);
            backdrop-filter: blur(14px);
            border-bottom: 1px solid var(--border);
            box-shadow: 0 2px 20px rgba(26,110,199,0.08);
        }

        .header-inner, .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 28px;
            height: 72px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        .logo-group, .nav-brand {
            display: flex;
            align-items: center;
            gap: 14px;
            text-decoration: none;
            flex-shrink: 0;
        }

        .logo-group img, .brand-icon img {
            width: 48px;
            height: 48px;
            object-fit: contain;
            mix-blend-mode: multiply;
            filter: drop-shadow(0 1px 3px rgba(0,0,0,0.15));
        }

        .logo-text, .brand-text {
            line-height: 1.2;
            display: flex;
            flex-direction: column;
        }

        .logo-text strong, .brand-text strong, .brand-title {
            display: block;
            font-family: 'Playfair Display', serif;
            font-size: 1rem;
            color: var(--blue-dark);
            letter-spacing: 0.01em;
            font-weight: 700;
            line-height: 1.1;
        }

        .logo-text span, .brand-text span, .brand-subtitle {
            font-size: 0.72rem;
            color: var(--green);
            font-weight: 500;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }

        nav, .nav-menu {
            display: flex;
            align-items: center;
            gap: 6px;
            list-style: none;
        }

        nav a, .nav-item a {
            padding: 8px 14px;
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--text-light);
            text-decoration: none;
            border-radius: 8px;
            transition: all .2s;
        }

        nav a:hover, .nav-item a:hover,
        nav a.active, .nav-item a.active {
            color: var(--blue);
            background: var(--sky);
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .notif-button {
            background: transparent;
            border: none;
            font-size: 1.2rem;
            cursor: pointer;
            position: relative;
            padding: 8px;
            transition: all 0.2s;
        }

        .notif-button:hover {
            transform: scale(1.1);
        }

        .notif-badge {
            position: absolute;
            top: -4px;
            right: -4px;
            background: var(--gold);
            color: white;
            font-size: 10px;
            font-weight: 700;
            min-width: 18px;
            height: 18px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 5px;
            border: 2px solid var(--white);
        }

        .user-menu {
            position: relative;
        }

        .user-button {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 6px 12px;
            border-radius: 24px;
            background: var(--sky);
            border: none;
            cursor: pointer;
            transition: all 0.2s;
        }

        .user-button:hover {
            background: var(--sky-mid);
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--blue), var(--green));
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 14px;
        }

        .user-name {
            font-size: 14px;
            font-weight: 600;
            color: var(--text);
            display: inline;
        }

        .user-dropdown {
            display: none;
            position: absolute;
            top: calc(100% + 8px);
            right: 0;
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 12px;
            min-width: 220px;
            box-shadow: 0 10px 30px rgba(26,110,199,0.15);
            overflow: hidden;
        }

        .user-dropdown.show {
            display: block;
        }

        .dropdown-header {
            padding: 16px;
            border-bottom: 1px solid var(--border);
        }

        .dropdown-header .user-full-name {
            font-weight: 600;
            font-size: 14px;
            color: var(--text);
        }

        .dropdown-header .user-email {
            font-size: 12px;
            color: var(--text-light);
            margin-top: 2px;
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
            padding: 12px 16px;
            border: none;
            background: none;
            cursor: pointer;
            text-align: left;
            font-family: inherit;
            font-size: 14px;
            color: var(--text);
            transition: background 0.2s;
            text-decoration: none;
        }

        .dropdown-item:hover {
            background: var(--off-white);
        }

        .dropdown-divider {
            height: 1px;
            background: var(--border);
            margin: 4px 0;
        }

        .dropdown-item.logout {
            color: #dc2626;
        }

        /* MAIN CONTENT */
        .main-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 32px 28px 100px;
            margin-top: 72px;
        }

        /* ALERT MESSAGES */
        .alert {
            border-radius: 12px;
            padding: 16px 20px;
            margin-bottom: 24px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            font-size: 14px;
            font-weight: 500;
        }

        .alert-success {
            background: rgba(58,125,68,0.12);
            border: 1px solid var(--green);
            color: var(--green-dark);
        }

        .alert-error {
            background: rgba(220,38,38,0.12);
            border: 1px solid #dc2626;
            color: #b91c1c;
        }

        .alert-icon {
            font-size: 20px;
            flex-shrink: 0;
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            nav, .nav-menu {
                display: none;
            }

            .user-name {
                display: none;
            }

            .brand-subtitle {
                display: none;
            }

            .header-inner, .nav-container {
                padding: 0 16px;
            }

            .main-container {
                padding: 20px 16px 100px;
            }
        }
    </style>

    <!-- Google Fonts for Typography -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet"/>
</head>
<body>
    @php
        $sealLogo = file_exists(public_path('images/city_of_general_trias_seal.png'))
            ? asset('images/city_of_general_trias_seal.png')
            : (file_exists(public_path('images/city_of_general trias.png'))
                ? asset('images/city_of_general trias.png')
                : asset('images/city_of_general_trias.png'));
    @endphp
    <!-- TOP NAVIGATION -->
    <nav class="top-nav">
        <div class="nav-container">
            <a href="{{ route('resident.dashboard') }}" class="nav-brand">
                <div class="brand-icon">
                    <img src="{{ $sealLogo }}" alt="City of General Trias Seal">
                </div>
                <div class="brand-text">
                    <div class="brand-title">Barangay Portal</div>
                    <div class="brand-subtitle">Resident Services</div>
                </div>
            </a>

            <ul class="nav-menu">
                <li class="nav-item">
                    <a href="{{ route('resident.dashboard') }}" class="{{ request()->is('resident/dashboard') ? 'active' : '' }}">
                        <span class="nav-icon">🏠</span>
                        <span>Home</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('resident.online-id') }}" class="{{ request()->is('resident/online-id') ? 'active' : '' }}">
                        <span class="nav-icon">🪪</span>
                        <span>My ID</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('resident.notifications') }}" class="{{ request()->is('resident/notifications') ? 'active' : '' }}">
                        <span class="nav-icon">📢</span>
                        <span>Announcements</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('resident.profile') }}" class="{{ request()->is('resident/profile') ? 'active' : '' }}">
                        <span class="nav-icon">👤</span>
                        <span>Profile</span>
                    </a>
                </li>
            </ul>

            <div class="nav-actions">
                <button class="notif-button" onclick="window.location.href='{{ route('resident.notifications') }}'">
                    🔔
                    @php
                        $unreadCount = App\Models\Notification::where('user_id', auth()->id())
                            ->where('is_read', false)
                            ->where('title', '!=', 'Account Approved')
                            ->count();
                    @endphp
                    @if($unreadCount > 0)
                        <span class="notif-badge">{{ $unreadCount }}</span>
                    @endif
                </button>

                <div class="user-menu">
                    <button class="user-button" onclick="toggleUserMenu()">
                        <div class="user-avatar">{{ substr(auth()->user()->getFullName(), 0, 1) }}</div>
                        <span class="user-name">{{ auth()->user()->getFullName() }}</span>
                    </button>

                    <div class="user-dropdown" id="userDropdown">
                        <div class="dropdown-header">
                            <div class="user-full-name">{{ auth()->user()->getFullName() }}</div>
                            <div class="user-email">{{ auth()->user()->email }}</div>
                        </div>
                        <a href="{{ route('resident.profile') }}" class="dropdown-item">
                            <span>👤</span>
                            <span>My Profile</span>
                        </a>
                        <a href="{{ route('resident.online-id') }}" class="dropdown-item">
                            <span>🪪</span>
                            <span>My Online ID</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <form action="{{ route('logout') }}" method="POST" style="width: 100%;">
                            @csrf
                            <button type="submit" class="dropdown-item logout" style="width: 100%;">
                                <span>🚪</span>
                                <span>Log Out</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- MAIN CONTENT -->
    <main class="main-container">
        <!-- Flash Messages -->
        @if($errors->any())
            <div class="alert alert-error">
                <span class="alert-icon">⚠️</span>
                <div>
                    <strong>Please correct the following errors:</strong>
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">
                <span class="alert-icon">✓</span>
                <div>{{ session('success') }}</div>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                <span class="alert-icon">✕</span>
                <div>{{ session('error') }}</div>
            </div>
        @endif

        <!-- Page Content -->
        @yield('content')
    </main>

    @include('resident.partials.chat-widget')

    <!-- ══ FOOTER ═══════════════════════════════════════════════ -->
    <footer style="background: linear-gradient(135deg, var(--text) 0%, #0f1820 100%); color: rgba(255,255,255,0.75); padding: 60px 28px 32px; margin-top: 80px;">
        <div style="max-width: 1200px; margin: 0 auto;">
            <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr; gap: 48px; margin-bottom: 48px;">
                <div class="footer-brand">
                    <div style="display: flex; align-items: center; gap: 14px; margin-bottom: 16px; text-decoration: none;">
                        @php
                            $sealLogo = file_exists(public_path('images/city_of_general_trias_seal.png'))
                                ? asset('images/city_of_general_trias_seal.png')
                                : (file_exists(public_path('images/city_of_general trias.png'))
                                    ? asset('images/city_of_general trias.png')
                                    : asset('images/city_of_general_trias.png'));
                        @endphp
                        <img src="{{ $sealLogo }}" alt="Logo" style="width: 40px; height: 40px; filter: brightness(0) invert(1) drop-shadow(0 2px 4px rgba(0,0,0,0.3));"/>
                        <div style="line-height: 1.2;">
                            <strong style="display: block; font-family: 'Playfair Display', serif; font-size: 15px; color: white; letter-spacing: 0.01em;">Barangay Service</strong>
                            <span style="font-size: 11px; color: rgba(255,255,255,0.5); font-weight: 500; letter-spacing: 0.04em; text-transform: uppercase;">Portal</span>
                        </div>
                    </div>
                    <p style="font-size: 13px; line-height: 1.7; color: rgba(255,255,255,0.75); max-width: 280px;">Empowering residents through secure, transparent, and convenient online access to barangay services and information.</p>
                </div>
                <div class="footer-col">
                    <h4 style="font-size: 13px; font-weight: 700; color: white; letter-spacing: .06em; text-transform: uppercase; margin-bottom: 16px;">Services</h4>
                    <a href="#" style="display: block; font-size: 13px; color: rgba(255,255,255,.6); text-decoration: none; margin-bottom: 10px; transition: color .2s;">Barangay Clearance</a>
                    <a href="#" style="display: block; font-size: 13px; color: rgba(255,255,255,.6); text-decoration: none; margin-bottom: 10px; transition: color .2s;">Residency Certificate</a>
                    <a href="#" style="display: block; font-size: 13px; color: rgba(255,255,255,.6); text-decoration: none; margin-bottom: 10px; transition: color .2s;">Business Permits</a>
                    <a href="#" style="display: block; font-size: 13px; color: rgba(255,255,255,.6); text-decoration: none; margin-bottom: 10px; transition: color .2s;">Indigency Certificate</a>
                </div>
                <div class="footer-col">
                    <h4 style="font-size: 13px; font-weight: 700; color: white; letter-spacing: .06em; text-transform: uppercase; margin-bottom: 16px;">Resources</h4>
                    <a href="{{ route('resident.dashboard') }}" style="display: block; font-size: 13px; color: rgba(255,255,255,.6); text-decoration: none; margin-bottom: 10px; transition: color .2s;">My Dashboard</a>
                    <a href="{{ route('resident.profile') }}" style="display: block; font-size: 13px; color: rgba(255,255,255,.6); text-decoration: none; margin-bottom: 10px; transition: color .2s;">My Profile</a>
                    <a href="{{ route('resident.online-id') }}" style="display: block; font-size: 13px; color: rgba(255,255,255,.6); text-decoration: none; margin-bottom: 10px; transition: color .2s;">Online ID</a>
                    <a href="{{ route('resident.notifications') }}" style="display: block; font-size: 13px; color: rgba(255,255,255,.6); text-decoration: none; margin-bottom: 10px; transition: color .2s;">Announcements</a>
                </div>
                <div class="footer-col">
                    <h4 style="font-size: 13px; font-weight: 700; color: white; letter-spacing: .06em; text-transform: uppercase; margin-bottom: 16px;">Support</h4>
                    <a href="#" style="display: block; font-size: 13px; color: rgba(255,255,255,.6); text-decoration: none; margin-bottom: 10px; transition: color .2s;">FAQs</a>
                    <a href="#" style="display: block; font-size: 13px; color: rgba(255,255,255,.6); text-decoration: none; margin-bottom: 10px; transition: color .2s;">Privacy Policy</a>
                    <a href="#" style="display: block; font-size: 13px; color: rgba(255,255,255,.6); text-decoration: none; margin-bottom: 10px; transition: color .2s;">Terms of Use</a>
                </div>
            </div>
            <div style="border-top: 1px solid rgba(255,255,255,0.08); padding-top: 28px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
                <p style="font-size: 13px; color: rgba(255,255,255,0.4); margin: 0;">© 2026 City Government of General Trias, Cavite. All rights reserved.</p>
                <p style="font-size: 13px; color: rgba(255,255,255,0.4); margin: 0;">Powered by the Barangay Management System</p>
            </div>
        </div>
    </footer>

    <script>
        function toggleUserMenu() {
            const dropdown = document.getElementById('userDropdown');
            dropdown.classList.toggle('show');
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const userMenu = event.target.closest('.user-menu');
            const dropdown = document.getElementById('userDropdown');
            
            if (!userMenu && dropdown) {
                dropdown.classList.remove('show');
            }
        });
    </script>
</body>
</html>
