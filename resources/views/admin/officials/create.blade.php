@extends('layouts.app')

@section('title', 'Add Official')

@section('content')
<style>
    :root {
        --blue: #1a6fcc;
        --green: #3a8a3f;
        --blue-light: #daf0fa;
        --surface: #f0f9ff;
        --text: #0d1b2a;
        --text-muted: #5a7a9a;
        --border: #c8e4f8;
    }

    .back-link {
        color: var(--blue);
        text-decoration: none;
        font-weight: 600;
        font-size: 14px;
        margin-bottom: 20px;
        display: inline-block;
        transition: opacity 0.2s;
    }

    .back-link:hover {
        opacity: 0.8;
    }

    .form-card {
        background: white;
        border-radius: 20px;
        padding: 40px;
        max-width: 640px;
        margin: 0 auto;
        box-shadow: 0 2px 12px rgba(26, 111, 204, 0.08);
    }

    .form-title {
        font-size: 24px;
        font-weight: 700;
        color: var(--text);
        margin: 0 0 4px 0;
    }

    .form-subtitle {
        font-size: 14px;
        color: var(--text-muted);
        margin: 0 0 20px 0;
    }

    .info-box {
        background: var(--blue-light);
        border-left: 4px solid var(--blue);
        border-radius: 10px;
        padding: 14px 18px;
        margin-bottom: 28px;
        font-size: 13px;
        color: #1a4a8a;
        line-height: 1.6;
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
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: var(--text-muted);
        margin-bottom: 6px;
    }

    .form-group input {
        border: 2px solid var(--border);
        border-radius: 12px;
        padding: 14px 16px;
        width: 100%;
        box-sizing: border-box;
        font-size: 15px;
        font-family: inherit;
        color: var(--text);
        background: white;
        transition: border-color 0.2s, box-shadow 0.2s;
        outline: none;
    }

    .form-group input:focus {
        border-color: var(--blue);
        box-shadow: 0 0 0 4px rgba(26, 111, 204, 0.1);
    }

    .error-message {
        color: #dc3545;
        font-size: 12px;
        margin-top: 4px;
    }

    .submit-btn {
        width: 100%;
        background: linear-gradient(135deg, #1a6fcc, #3a8a3f);
        border: none;
        border-radius: 12px;
        padding: 15px;
        color: white;
        font-size: 16px;
        font-weight: 700;
        font-family: inherit;
        cursor: pointer;
        margin-top: 8px;
        transition: opacity 0.2s, transform 0.1s;
    }

    .submit-btn:hover {
        opacity: 0.92;
    }

    .submit-btn:active {
        transform: scale(0.99);
    }
</style>

<a href="{{ route('admin.officials.index') }}" class="back-link">← Back to Officials</a>

<div class="form-card">
    <h1 class="form-title">Add Barangay Official</h1>
    <p class="form-subtitle">Grant system administrator access to an official</p>

    <div class="info-box">
        ✉️ A welcome email with login credentials will be sent to this official.
    </div>

    <form method="POST" action="{{ route('admin.officials.store') }}">
        @csrf

        <div class="form-grid">
            <div class="full">
                <div class="form-group">
                    <label for="name">Full Name *</label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="Juan Dela Cruz"
                        required
                    >
                    @error('name')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="full">
                <div class="form-group">
                    <label for="email">Email Address *</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="official@barangay.gov.ph"
                        required
                    >
                    @error('email')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div>
                <div class="form-group">
                    <label for="password">Password *</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password"
                        placeholder="••••••••••••"
                        required
                    >
                    @error('password')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div>
                <div class="form-group">
                    <label for="password_confirmation">Confirm Password *</label>
                    <input 
                        type="password" 
                        id="password_confirmation" 
                        name="password_confirmation"
                        placeholder="••••••••••••"
                        required
                    >
                    @error('password_confirmation')
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
                        value="{{ old('phone') }}"
                        placeholder="+63 9XX XXX XXXX"
                        pattern="[0-9\+\-\(\)\s\.]*"
                        inputmode="numeric"
                    >
                    @error('phone')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <input 
                        type="text" 
                        id="address" 
                        name="address"
                        value="{{ old('address') }}"
                        placeholder="Office address"
                    >
                    @error('address')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <button type="submit" class="submit-btn">+ Create Official Account</button>
    </form>
</div>

@endsection
