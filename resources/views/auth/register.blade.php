<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Barangay Management System - Register</title>
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
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: 'DM Sans', sans-serif;
            display: flex;
            color: var(--text);
        }

        .left-panel {
            width: 58%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--off-white);
            padding: 40px;
            min-height: 100vh;
        }

        .register-card {
            max-width: 600px;
            width: 100%;
            background: white;
            border-radius: 24px;
            padding: 48px;
            box-shadow: 0 8px 40px rgba(26, 110, 199, 0.12);
        }

        .card-header {
            text-align: center;
            margin-bottom: 36px;
        }

        .card-header h2 {
            font-size: 26px;
            font-weight: 800;
            color: var(--text);
            margin: 0;
            margin-bottom: 8px;
        }

        .card-header p {
            color: var(--text-muted);
            font-size: 13px;
            margin: 8px 0 0 0;
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
            color: var(--text-muted);
            margin-bottom: 6px;
        }

        .form-group label .required {
            color: #dc3545;
        }

        .form-group input,
        .form-group select {
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

        .form-group input:focus,
        .form-group select:focus {
            border-color: var(--blue);
            box-shadow: 0 0 0 4px rgba(26, 110, 199, 0.1);
        }

        .form-group input.error,
        .form-group select.error {
            border-color: #dc3545;
        }

        .form-group select {
            appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%235a7a9a' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 12px center;
            background-size: 20px;
            padding-right: 40px;
        }

        .error-message {
            color: #dc3545;
            font-size: 12px;
            margin-top: 4px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-grid .full {
            grid-column: 1 / -1;
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
            transition: opacity 0.2s, transform 0.1s;
        }

        .btn-primary:hover {
            opacity: 0.92;
        }

        .btn-primary:active {
            transform: scale(0.99);
        }

        .info-banner {
            background: var(--blue-light);
            border-left: 4px solid var(--blue);
            border-radius: 10px;
            padding: 14px 16px;
            font-size: 13px;
            color: var(--blue-dark);
            margin-top: 16px;
            line-height: 1.6;
        }

        .register-footer {
            text-align: center;
            margin-top: 24px;
            font-size: 14px;
            color: var(--text-muted);
        }

        .register-footer a {
            color: var(--blue);
            text-decoration: none;
            font-weight: 600;
            transition: opacity 0.2s;
        }

        .register-footer a:hover {
            opacity: 0.8;
        }

        .right-panel {
            width: 42%;
            min-height: 100vh;
            background: linear-gradient(135deg, var(--blue-dark) 0%, var(--blue) 45%, #1a8fc7 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 60px 48px;
            color: white;
        }

        .right-panel h1 {
            font-size: 36px;
            font-weight: 800;
            margin: 0;
            margin-bottom: 16px;
            line-height: 1.2;
        }

        .right-panel > p {
            font-size: 16px;
            margin: 0 0 48px 0;
            opacity: 0.8;
            line-height: 1.6;
        }

        .steps-list {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .step-item {
            display: flex;
            align-items: center;
            gap: 12px;
            background: rgba(255, 255, 255, 0.12);
            padding: 12px 16px;
            border-radius: 50px;
            font-size: 14px;
            font-weight: 500;
        }

        .step-badge {
            width: 28px;
            height: 28px;
            background: rgba(255, 255, 255, 0.25);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 700;
            flex-shrink: 0;
        }

        .confirm-overlay {
            position: fixed;
            inset: 0;
            background: rgba(13, 27, 42, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            padding: 20px;
        }

        .confirm-overlay.hidden {
            display: none;
        }

        .confirm-modal {
            width: 100%;
            max-width: 420px;
            background: #fff;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 10px 32px rgba(26, 110, 199, 0.2);
            text-align: center;
        }

        .confirm-modal h3 {
            font-size: 22px;
            color: var(--blue);
            margin-bottom: 10px;
        }

        .confirm-modal p {
            color: var(--text-muted);
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .confirm-actions {
            display: flex;
            gap: 12px;
            justify-content: center;
        }

        .confirm-btn,
        .cancel-btn {
            border: none;
            border-radius: 10px;
            padding: 10px 16px;
            font-family: inherit;
            font-weight: 700;
            cursor: pointer;
        }

        .confirm-btn {
            background: var(--blue);
            color: #fff;
        }

        .cancel-btn {
            background: #eaf4ff;
            color: var(--blue);
        }
    </style>
</head>
<body>
    <div class="left-panel">
        <div class="register-card">
            <div class="card-header">
                <h2>Create Resident Account</h2>
                <p>All fields marked <span class="required">*</span> are required</p>
            </div>

            <form method="POST" action="{{ route('register') }}" id="residentRegisterForm">
                @csrf

                <div class="form-grid">
                    <div>
                        <div class="form-group">
                            <label for="first_name">First Name <span class="required">*</span></label>
                            <input 
                                type="text" 
                                id="first_name" 
                                name="first_name"
                                value="{{ old('first_name') }}"
                                placeholder="Juan"
                                required
                                class="@error('first_name') error @enderror"
                            >
                            @error('first_name')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <div class="form-group">
                            <label for="middle_name">Middle Name</label>
                            <input 
                                type="text" 
                                id="middle_name" 
                                name="middle_name"
                                value="{{ old('middle_name') }}"
                                placeholder="Meow"
                                class="@error('middle_name') error @enderror"
                            >
                            @error('middle_name')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <div class="form-group">
                            <label for="surname">Surname <span class="required">*</span></label>
                            <input 
                                type="text" 
                                id="surname" 
                                name="surname"
                                value="{{ old('surname') }}"
                                placeholder="Cruz"
                                required
                                class="@error('surname') error @enderror"
                            >
                            @error('surname')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <div class="form-group">
                            <label for="email">Email Address <span class="required">*</span></label>
                            <input 
                                type="email" 
                                id="email" 
                                name="email"
                                value="{{ old('email') }}"
                                placeholder="your.email@example.com"
                                required
                                class="@error('email') error @enderror"
                            >
                            @error('email')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <div class="form-group">
                            <label for="phone">Phone Number <span class="required">*</span></label>
                            <input 
                                type="tel" 
                                id="phone" 
                                name="phone"
                                value="{{ old('phone') }}"
                                placeholder="+63 9XX XXX XXXX"
                                pattern="[0-9\+\-\(\)\s\.]*"
                                inputmode="numeric"
                                required
                                class="@error('phone') error @enderror"
                            >
                            @error('phone')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <div class="form-group">
                            <label for="password">Password <span class="required">*</span></label>
                            <input 
                                type="password" 
                                id="password" 
                                name="password"
                                placeholder="••••••••••••"
                                required
                                class="@error('password') error @enderror"
                            >
                            @error('password')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <div class="form-group">
                            <label for="password_confirmation">Confirm Password <span class="required">*</span></label>
                            <input 
                                type="password" 
                                id="password_confirmation" 
                                name="password_confirmation"
                                placeholder="••••••••••••"
                                required
                                class="@error('password_confirmation') error @enderror"
                            >
                            @error('password_confirmation')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="full">
                        <div class="form-group">
                            <label for="address">Address <span class="required">*</span></label>
                            <input 
                                type="text" 
                                id="address" 
                                name="address"
                                value="{{ old('address') }}"
                                placeholder="Street address, Barangay name"
                                required
                                class="@error('address') error @enderror"
                            >
                            @error('address')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <div class="form-group">
                            <label for="birthdate">Birthdate <span class="required">*</span></label>
                            <input 
                                type="date" 
                                id="birthdate" 
                                name="birthdate"
                                value="{{ old('birthdate') }}"
                                required
                                class="@error('birthdate') error @enderror"
                            >
                            @error('birthdate')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <div class="form-group">
                            <label for="gender">Gender <span class="required">*</span></label>
                            <select 
                                id="gender" 
                                name="gender"
                                required
                                class="@error('gender') error @enderror"
                            >
                                <option value="">Select Gender</option>
                                <option value="male" @selected(old('gender') === 'male')>Male</option>
                                <option value="female" @selected(old('gender') === 'female')>Female</option>
                                <option value="other" @selected(old('gender') === 'other')>Other</option>
                            </select>
                            @error('gender')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <div class="form-group">
                            <label for="marital_status">Marital Status</label>
                            <select 
                                id="marital_status" 
                                name="marital_status"
                                class="@error('marital_status') error @enderror"
                            >
                                <option value="">Select Marital Status</option>
                                <option value="single" @selected(old('marital_status') === 'single')>Single</option>
                                <option value="married" @selected(old('marital_status') === 'married')>Married</option>
                                <option value="divorced" @selected(old('marital_status') === 'divorced')>Divorced</option>
                                <option value="widowed" @selected(old('marital_status') === 'widowed')>Widowed</option>
                                <option value="separated" @selected(old('marital_status') === 'separated')>Separated</option>
                            </select>
                            @error('marital_status')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn-primary" id="submitRegistrationBtn">Submit Registration Request</button>

                <div class="info-banner">
                    ⏳ Your account will require approval from a Barangay Official before you can log in. You will be notified via email.
                </div>

                <div class="register-footer">
                    Already have an account? <a href="{{ route('login') }}">Back to login</a>
                </div>
            </form>
        </div>
    </div>

    <div class="right-panel">
        <h1>Join Our Community</h1>
        <p>Create your resident account and gain access to official Barangay services</p>
        
        <div class="steps-list">
            <div class="step-item">
                <div class="step-badge">1</div>
                <span>Fill the form</span>
            </div>
            <div class="step-item">
                <div class="step-badge">2</div>
                <span>Wait for approval</span>
            </div>
            <div class="step-item">
                <div class="step-badge">3</div>
                <span>Access your portal</span>
            </div>
        </div>
    </div>

    <div class="confirm-overlay hidden" id="registerConfirmOverlay" role="dialog" aria-modal="true" aria-labelledby="registerConfirmTitle">
        <div class="confirm-modal">
            <h3 id="registerConfirmTitle">Confirm Registration</h3>
            <p>Your account will be marked as pending. Please wait for Barangay Official approval after submitting.</p>
            <div class="confirm-actions">
                <button type="button" class="cancel-btn" id="cancelRegisterConfirm">Cancel</button>
                <button type="button" class="confirm-btn" id="confirmRegisterSubmit">Submit Request</button>
            </div>
        </div>
    </div>

    <script>
        const registerForm = document.getElementById('residentRegisterForm');
        const confirmOverlay = document.getElementById('registerConfirmOverlay');
        const cancelConfirmButton = document.getElementById('cancelRegisterConfirm');
        const confirmSubmitButton = document.getElementById('confirmRegisterSubmit');

        registerForm.addEventListener('submit', function (event) {
            if (registerForm.dataset.confirmed === 'true') {
                return;
            }

            event.preventDefault();
            confirmOverlay.classList.remove('hidden');
        });

        cancelConfirmButton.addEventListener('click', function () {
            confirmOverlay.classList.add('hidden');
        });

        confirmSubmitButton.addEventListener('click', function () {
            registerForm.dataset.confirmed = 'true';
            registerForm.submit();
        });
    </script>
</body>
</html>
