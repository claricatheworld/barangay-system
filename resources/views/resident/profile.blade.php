@extends('layouts.resident')

@section('title', 'My Profile')

@section('content')
<style>
    .page-header {
        margin-bottom: 32px;
    }

    .page-title {
        font-size: 32px;
        font-weight: 800;
        color: var(--gray-900);
        margin-bottom: 8px;
    }

    .page-subtitle {
        font-size: 16px;
        color: var(--gray-600);
    }

    .profile-grid {
        display: grid;
        grid-template-columns: 1fr 2fr;
        gap: 24px;
    }

    .left-card {
        background: white;
        border-radius: 16px;
        padding: 32px;
        text-align: center;
        box-shadow: var(--shadow);
        border: 1px solid var(--gray-200);
        height: fit-content;
    }

    .avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        overflow: hidden;
        margin: 0 auto 20px;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 42px;
        color: white;
        font-weight: 800;
        box-shadow: var(--shadow-lg);
    }

    .avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .user-name {
        font-size: 22px;
        font-weight: 700;
        color: var(--gray-900);
        margin: 0 0 8px 0;
    }

    .role-badge {
        display: inline-block;
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 24px;
        background: var(--secondary-light);
        color: var(--secondary-dark);
    }

    .divider {
        border: none;
        border-top: 1px solid var(--gray-200);
        margin: 24px 0;
    }

    .change-photo-label {
        display: inline-block;
        background: var(--primary);
        color: white;
        border-radius: 10px;
        padding: 12px 24px;
        cursor: pointer;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.2s;
        margin-bottom: 12px;
    }

    .change-photo-label:hover {
        background: var(--primary-dark);
    }

    .photo-note {
        font-size: 12px;
        color: var(--gray-500);
        margin-top: 8px;
    }

    .right-card {
        background: white;
        border-radius: 16px;
        padding: 32px;
        box-shadow: var(--shadow);
        border: 1px solid var(--gray-200);
    }

    .section-header {
        font-size: 20px;
        font-weight: 700;
        color: var(--gray-900);
        margin: 0 0 28px 0;
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

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-group label {
        font-size: 13px;
        font-weight: 600;
        color: var(--gray-700);
        margin-bottom: 8px;
    }

    .form-group input,
    .form-group select {
        border: 1px solid var(--gray-300);
        border-radius: 10px;
        padding: 12px 16px;
        width: 100%;
        box-sizing: border-box;
        font-size: 15px;
        font-family: inherit;
        color: var(--gray-900);
        background: white;
        transition: all 0.2s;
        outline: none;
    }

    .form-group input:focus,
    .form-group select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .form-group input:readonly {
        background: var(--gray-100);
        color: var(--gray-600);
        cursor: not-allowed;
    }

    .readonly-note {
        font-size: 12px;
        color: var(--gray-500);
        margin-top: 6px;
    }

    .form-group select {
        appearance: none;
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 12px center;
        background-size: 20px;
        padding-right: 40px;
    }

    .error-message {
        color: #dc2626;
        font-size: 12px;
        margin-top: 6px;
    }

    .form-footer {
        display: flex;
        justify-content: flex-end;
        margin-top: 32px;
    }

    .save-btn {
        background: var(--primary);
        border: none;
        border-radius: 10px;
        padding: 14px 32px;
        color: white;
        font-weight: 700;
        font-size: 15px;
        font-family: inherit;
        cursor: pointer;
        transition: all 0.2s;
        box-shadow: var(--shadow-sm);
    }

    .save-btn:hover {
        background: var(--primary-dark);
        box-shadow: var(--shadow);
    }

    .save-btn:active {
        transform: scale(0.98);
    }

    .success-message {
        background: var(--secondary-light);
        border: 1px solid var(--secondary);
        border-radius: 12px;
        padding: 16px 20px;
        margin-bottom: 24px;
        font-size: 14px;
        font-weight: 500;
        color: var(--secondary-dark);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    @media (max-width: 1024px) {
        .profile-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="page-header">
    <h1 class="page-title">👤 My Profile</h1>
    <p class="page-subtitle">Manage your personal information and account settings</p>
</div>

@if(session('success'))
    <div class="success-message">
        <span style="font-size: 20px;">✓</span>
        <span>{{ session('success') }}</span>
    </div>
@endif

<div class="profile-grid">
    <div class="left-card">
        <div class="avatar" id="avatarPreview">
            {{ strtoupper(substr(auth()->user()->getFullName() ?? 'User', 0, 1)) }}
        </div>
        <h2 class="user-name">{{ auth()->user()->getFullName() }}</h2>
        <span class="role-badge">✓ Verified Resident</span>
        
        <hr class="divider">
        
        <input type="file" id="photoInput" name="profile_photo" accept="image/*" style="display: none" onchange="previewPhoto(this)">
        <label for="photoInput" class="change-photo-label">📷 Change Photo</label>
        <p class="photo-note">JPG or PNG, max 2MB</p>
    </div>

    <div class="right-card">
        <h2 class="section-header">Personal Information</h2>

        <form method="POST" action="{{ route('resident.profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-grid">
                <div>
                    <div class="form-group">
                        <label for="first_name">First Name *</label>
                        <input 
                            type="text" 
                            id="first_name" 
                            name="first_name"
                            value="{{ old('first_name', auth()->user()->first_name) }}"
                            required
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
                            value="{{ old('middle_name', auth()->user()->middle_name) }}"
                        >
                        @error('middle_name')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div>
                    <div class="form-group">
                        <label for="surname">Surname *</label>
                        <input 
                            type="text" 
                            id="surname" 
                            name="surname"
                            value="{{ old('surname', auth()->user()->surname) }}"
                            required
                        >
                        @error('surname')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div>
                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input 
                            type="tel" 
                            id="phone" 
                            name="phone"
                            value="{{ old('phone', auth()->user()->phone) }}"
                            pattern="[0-9\+\-\(\)\s\.]*"
                            inputmode="numeric"
                        >
                        @error('phone')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="full">
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input 
                            type="email" 
                            id="email" 
                            value="{{ auth()->user()->email }}"
                            readonly
                        >
                        <p class="readonly-note">📧 Email address cannot be changed</p>
                    </div>
                </div>

                <div class="full">
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input 
                            type="text" 
                            id="address" 
                            name="address"
                            value="{{ old('address', auth()->user()->address) }}"
                        >
                        @error('address')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div>
                    <div class="form-group">
                        <label for="birthdate">Birthdate</label>
                        <input 
                            type="date" 
                            id="birthdate" 
                            name="birthdate"
                            value="{{ old('birthdate', auth()->user()->birthdate) }}"
                        >
                        @error('birthdate')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div>
                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <select id="gender" name="gender">
                            <option value="">Select Gender</option>
                            <option value="male" @selected(old('gender', auth()->user()->gender) === 'male')>Male</option>
                            <option value="female" @selected(old('gender', auth()->user()->gender) === 'female')>Female</option>
                            <option value="other" @selected(old('gender', auth()->user()->gender) === 'other')>Other</option>
                        </select>
                        @error('gender')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div>
                    <div class="form-group">
                        <label for="marital_status">Marital Status</label>
                        <select id="marital_status" name="marital_status">
                            <option value="">Select Marital Status</option>
                            <option value="single" @selected(old('marital_status', auth()->user()->marital_status) === 'single')>Single</option>
                            <option value="married" @selected(old('marital_status', auth()->user()->marital_status) === 'married')>Married</option>
                            <option value="divorced" @selected(old('marital_status', auth()->user()->marital_status) === 'divorced')>Divorced</option>
                            <option value="widowed" @selected(old('marital_status', auth()->user()->marital_status) === 'widowed')>Widowed</option>
                            <option value="separated" @selected(old('marital_status', auth()->user()->marital_status) === 'separated')>Separated</option>
                        </select>
                        @error('marital_status')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-footer">
                <button type="submit" class="save-btn">💾 Update Profile</button>
            </div>
        </form>
    </div>
</div>

<script>
    function previewPhoto(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('avatarPreview');
                preview.style.backgroundImage = 'url(' + e.target.result + ')';
                preview.style.backgroundSize = 'cover';
                preview.style.backgroundPosition = 'center';
                preview.innerHTML = '';
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

@endsection
