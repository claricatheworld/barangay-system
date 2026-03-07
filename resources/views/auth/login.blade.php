<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>PROJECT CONNECT - Log In</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet"/>
    <link rel="icon" type="image/x-icon" href="{{ asset('images/city_of_general_trias_seal.png') }}">
    <style>
        :root {
            --blue:       #1a6ec7;
            --blue-dark:  #154f96;
            --sky:        #d9f2fc;
            --sky-mid:    #a8dff5;
            --green:      #3a7d44;
            --green-dark: #2c5f35;
            --soft-blue:  #d4f4ff;
            --white:      #ffffff;
            --off-white:  #f4f8fb;
            --text:       #1a2433;
            --text-light: #4b5e72;
            --border:     rgba(26,110,199,0.12);
            --gold:       #e8b84b;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'DM Sans', sans-serif;
            display: flex;
            flex-wrap: wrap;
            min-height: 100vh;
            color: var(--text);
        }


        .left-panel {
            width: 42%;
            min-height: 100vh;
            background: linear-gradient(135deg, var(--blue-dark) 0%, var(--blue) 45%, #1a8fc7 100%);
            display: flex;
            flex-direction: column; 
            justify-content: center;
            padding: 60px 48px;
            color: white;
        }

        .shield-icon {
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            margin-bottom: 24px;
        }

        .left-panel h1 {
            font-size: 42px;
            font-weight: 800;
            margin: 0;
            margin-bottom: 8px;
        }

        .left-panel > p {
            font-size: 18px;
            margin: 8px 0 40px 0;
            opacity: 0.8;
        }

        .divider {
            width: 3px;
            height: 40px;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 2px;
            margin-bottom: 32px;
        }

        .feature-list {
            display: flex;
            flex-direction: column;
            gap: 16px;
            margin-bottom: 40px;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .feature-icon {
            width: 32px;
            height: 32px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            line-height: 32px;
            flex-shrink: 0;
        }

        .feature-text {
            font-size: 14px;
            font-weight: 500;
        }

        .left-panel-footer {
            font-size: 13px;
            opacity: 0.6;
        }

        .right-panel {
            width: 58%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--surface);
            padding: 40px;
        }

        .login-card {
            max-width: 400px;
            margin: 0 auto;
            width: 100%;
            background: white;
            border-radius: 24px;
            padding: 48px;
            box-shadow: 0 8px 40px rgba(26, 111, 204, 0.12);
            
        }

        .card-header {
            text-align: center;
            margin-bottom: 36px;
        }

        /* .badge {
            display: inline-block;
            background: var(--blue-light);
            color: var(--blue);
            padding: 4px 14px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 16px;
        } */

        .card-header h2 {
            font-size: 28px;
            font-weight: 800;
            color: var(--text);
            margin: 0;
            margin-bottom: 8px;
        }

        .card-header p {
            color: var(--blue-dark);
            font-size: 15px;
            margin: 8px 0 0 0;
        }

        .alert {
            border-radius: 10px;
            padding: 12px 16px;
            margin-bottom: 20px;
            font-size: 14px;
            display: flex;
            align-items: flex-start;
            gap: 8px;
        }

        .alert-error {
            background: #fce8e6;
            border-left: 4px solid #dc3545;
            color: #b91c1c;
        }

        .alert-success {
            background: var(--green-light);
            border-left: 4px solid var(--green);
            color: var(--green-dark);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            color: var(--blue-dark);
            margin-bottom: 6px;
        }

        .form-group input {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid var(--border);
            border-radius: 12px;
            font-size: 15px;
            font-family: inherit;
            color: var(--text);
            background: white;
            box-sizing: border-box;
            transition: border-color 0.2s, box-shadow 0.2s;
            outline: none;
        }

        .form-group input:focus {
            border-color: var(--blue);
            box-shadow: 0 0 0 4px rgba(26, 111, 204, 0.1);
        }

        .form-group input.error {
            border-color: #dc3545;
        }

        .error-message {
            color: #dc3545;
            font-size: 12px;
            margin-top: 4px;
        }

        .form-footer {
            display: flex;
            justify-content: flex-start;
            align-items: center;
            margin-bottom: 24px;
            font-size: 14px;
            color: var(--blue-dark);
        }

        .divider-or {
            text-align: center;
            color: var(--blue-dark);
            margin: 24px 0;
            position: relative;
            color: var(--text-muted);
            font-size: 13px;
        }

        .divider-or::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: var(--border);
            z-index: 0;
        }

        .divider-or span {
            color: var(--text-light);
            background: white;
            position: relative;
            padding: 0 8px;
            z-index: 1;
        }

        .register-link {
            text-align: center;
            font-size: 14px;
            color: var(--text-light);
        }

        .register-link a {
            color: var(--blue);
            text-decoration: none;
            font-weight: 700;
            transition: opacity 0.2s;
        }

        .register-link a:hover {
            opacity: 0.8;
        }

        .btn-primary {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #1a6ec7, #3a7d44);
            border: none;
            border-radius: 12px;
            color: white;
            font-size: 16px;
            font-weight: 700;
            font-family: inherit;
            cursor: pointer;
            margin-top: 8px;
            transition: opacity 0.2s, transform 0.1s;
        }

        .btn-primary:hover {
            opacity: 0.92;
        }

        .btn-primary:active {
            transform: scale(0.99);
        }

        header {
            width: 100%;
            background: white;
            padding: 16px 40px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
        }

        .header-inner {
            max-width: 1400px;
            max-height: 150px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo-group {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: var(--text);
        }

        .logo-group img {
            width: 40px;
            height: 40px;
        }

        .logo-text {
            font-size: 13px;
            line-height: 1.3;
        }

        .logo-text strong {
            font-size: 14px;
            font-weight: 700;
            color: var(--text);
            display: block;
        }

        .logo-text span {
            font-size: 11px;
            color: var(--text-light);
            font-weight: 500;
        }

        header nav {
            display: flex;
            gap: 32px;
        }

        header nav a {
            font-size: 14px;
            color: var(--text);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s;
        }

        header nav a:hover {
            color: var(--blue);
        }

        .hero {
        width:100%;
        height: auto;
        margin-top: 80px;
        color: white;
        padding: 80px 32px;
        position: relative;
        overflow: hidden;
      
    }

    .hero::before {
      content: '';
      position: absolute;
      top: -50%;
      right: -20%;
      width: 800px;
      height: auto;
      
      border-radius: 50%;
    }

    .hero-inner {
      max-width: 1200px;
      margin-top: 0;
      margin: 0 auto;
      text-align: center;
      position: relative;
      z-index: 2;
    }

    .hero-title {
      font-family: ''DM Sans', sans-serif';
      font-size: clamp(2rem, 5vw, 3.5rem);
      font-weight: 700;
      line-height: 1.2;
      margin-bottom: 16px;
      color: var(--text);
    }

    .hero-subtitle {
      font-size: clamp(1.1rem, 2vw, 1.4rem);
      font-weight: 600;
      color: #fbbf24;
      margin-bottom: 20px;
    }

    .hero-description {
      font-size: 1.1rem;
      line-height: 1.8;
      max-width: 800px;
      margin: 0 auto 40px;
      opacity: 0.95;
    }

    .hero-ctas {
      display: flex;
      justify-content: center;
      gap: 16px;
      flex-wrap: wrap;
      margin-bottom: 60px;
    }

    body {
            background: var(--soft-blue);
            padding-top: 72px;
    }

    /* ══════════════════════════════════════════════════════════════════
       FOOTER
    ══════════════════════════════════════════════════════════════════ */
    footer {
        margin-top: 50px;
        width: 100%;
      background: var(--text);
      color: rgba(255, 255, 255, 0.8);
      padding: 60px 32px 24px;
    }

    .footer-inner {
      max-width: 1200px;
      margin: 0 auto;
      display: grid;
      grid-template-columns: 2fr 1fr 1fr 1fr;
      gap: 48px;
      margin-bottom: 48px;
    }

    .footer-brand h3 {
      color: white;
      font-size: 1.4rem;
      margin-bottom: 12px;
      font-weight: 700;
    }

    .footer-brand p {
      font-size: 0.95rem;
      line-height: 1.7;
      margin-bottom: 20px;
    }

    .footer-section h4 {
      color: white;
      font-size: 1.1rem;
      margin-bottom: 16px;
      font-weight: 700;
    }

    .footer-section ul {
      
      list-style: none;
    }

    .footer-section ul li {
      margin-bottom: 12px;
    }

    .footer-section a {
      color: rgba(255, 255, 255, 0.7);
      text-decoration: none;
      transition: color 0.2s;
      font-size: 0.95rem;
    }

    .footer-section a:hover {
      color: white;
    }

    .footer-bottom {
      border-top: 1px solid rgba(255, 255, 255, 0.1);
      padding-top: 24px;
      text-align: center;
      font-size: 0.9rem;
    color: rgba(255, 255, 255, 0.6);
    }

    /* ══════════════════════════════════════════════════════════════════
       RESPONSIVE
    ══════════════════════════════════════════════════════════════════ */

    @media (max-width: 768px) {
        .hero {
            margin-top: 150px;
            padding: 60px 20px;
            margin: 0 auto;
            overflow-x: hidden;
        }

        .hero-inner {
      max-width: 1200px;
      margin-top: 80px;
 
    }

        
        .login-card {
            margin: 0 auto;
            padding: 20px;
        }

        .footer-inner {
        grid-template-columns: 1fr;
        gap: 32px;
      }

}

      
    </style>
</head>
<body>

<!-- ══════════════════════════════════════════════════════════════════
       HEADER
  ══════════════════════════════════════════════════════════════════ -->

  <header>

    <div class="header-inner">
      <a href="/" class="logo-group">
        <img src="{{ asset('images/city_of_general_trias_seal.png') }}" alt="General Trias Seal" />
        <div class="logo-text">
          <strong>PROJECT CONNECT</strong>
          
            <span style="display: block;">Brgy. San Juan I</span>
          
        </div>
      </a>

    </div>


  </header>

  <section class="hero">
    <div class="hero-inner">
   

      <div class="login-card">
            <div class="card-header">
              
                <h2>Welcome Back</h2>
                <p>Log in to your account</p>
            </div>

            @if(session('error'))
                <div class="alert alert-error">
                    <span>⚠️</span>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success">
                    <span>✓</span>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        value="{{ old('email') }}"
                        placeholder="Enter your email"
                        required
                        class="@error('email') error @enderror"
                    >
                    @error('email')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password"
                        placeholder="Enter your password"
                        required
                        class="@error('password') error @enderror"
                    >
                    @error('password')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-footer">
                    <label>
                        <input type="checkbox" name="remember" style="margin-right: 8px;">
                        <span style="font-size: 13px; color: var(--text-muted); display: inline-block;">Remember me</span>
                    </label>
                </div>

                <button type="submit" class="btn-primary">Log In</button>
            </form>

            <div class="divider-or">
                <span>or</span>
            </div>

            <div class="register-link">
                Don't have an account? <a href="{{ route('register') }}">Register here →</a>
            </div>
       

      

           
        </div>
      

      
    </div>
  </section>
  <br>


  <footer>
    <div class="footer-inner">
      <div class="footer-brand">
        <h3>PROJECT CONNECT</h3>
        <p>
          Providing transparent, efficient, and accessible government services to all residents 
          of Barangay San Juan I, City of General Trias City, Cavite.
        </p>
        <p style="margin-top: 20px; font-size: 0.85rem;">
          © 2026 PROJECT CONNECT. All rights reserved.
        </p>
      </div>

      <div class="footer-section">
        <h4>Quick Access</h4>
        <ul>
          <li><a href="{{ route('register') }}">Register</a></li>
          <li><a href="{{ route('homepage') }}#about">Services</a></li>

        </ul>
      </div>


      <div class="footer-section">
        <h4>Connect</h4>
        <ul>
          <li><a href="https://www.facebook.com/profile.php?id=61577772153879">Facebook</a></li>
          <li><a href="https://maps.app.goo.gl/jb8Hb745vhcvAAjD9">Google Maps</a></li>

        </ul>
      </div>
    </div>


  </footer>


    

    <style>
        body { 
            min-height: 100vh; 
            display: flex; 
            flex-wrap: wrap;
            padding: 0;
            margin: 0;
        }
        .left-panel {
            width: 42%;
            min-height: 100vh;
        }
        .right-panel { 
            width: 58%;
            display: flex; 
            align-items: center; 
            justify-content: center;
            min-height: 100vh;
        }
       

    </style>
</body>
</html>
