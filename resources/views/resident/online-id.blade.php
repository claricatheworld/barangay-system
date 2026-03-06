@extends('layouts.resident')

@section('title', 'My Online ID')

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

    .page-wrapper {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .print-button {
        background: var(--primary);
        color: white;
        border: none;
        border-radius: 10px;
        padding: 14px 32px;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        margin-bottom: 32px;
        transition: all 0.2s;
        box-shadow: var(--shadow-sm);
    }

    .print-button:hover {
        background: var(--primary-dark);
        box-shadow: var(--shadow);
    }

    .upload-section {
        margin-bottom: 24px;
        text-align: center;
    }

    .upload-form {
        display: inline-flex;
        align-items: center;
        gap: 12px;
        background: white;
        padding: 16px 24px;
        border-radius: 12px;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--gray-200);
    }

    .file-input-wrapper {
        position: relative;
        overflow: hidden;
    }

    .file-input-wrapper input[type=file] {
        position: absolute;
        left: -9999px;
    }

    .file-input-label {
        display: inline-block;
        padding: 10px 20px;
        background: var(--gray-100);
        color: var(--gray-700);
        border: 1px solid var(--gray-300);
        border-radius: 8px;
        cursor: pointer;
        font-size: 14px;
        font-weight: 600;
        transition: all 0.2s;
    }

    .file-input-label:hover {
        background: var(--gray-200);
        border-color: var(--gray-400);
    }

    .file-name {
        font-size: 14px;
        color: var(--gray-600);
        font-style: italic;
    }

    .upload-button {
        background: var(--secondary);
        color: white;
        border: none;
        border-radius: 8px;
        padding: 10px 24px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
    }

    .upload-button:hover {
        background: var(--secondary-dark);
    }

    .upload-button:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .alert {
        padding: 12px 20px;
        border-radius: 8px;
        margin-bottom: 20px;
        font-size: 14px;
        font-weight: 500;
    }

    .alert-success {
        background: #d1fae5;
        color: #065f46;
        border: 1px solid #6ee7b7;
    }

    .alert-error {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fca5a5;
    }

    .id-card {
        width: 540px;
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: var(--shadow-xl);
        border: 1px solid var(--gray-200);
    }

    .card-header {
        background: linear-gradient(135deg, var(--secondary-dark) 0%, var(--secondary) 100%);
        padding: 20px 28px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        min-height: 80px;
    }

    .header-left {
        display: flex;
        gap: 16px;
        align-items: center;
    }

    .seal-circle {
        width: 52px;
        height: 52px;
        border: 2px solid rgba(255, 255, 255, 0.6);
        border-radius: 50%;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        background: rgba(0, 0, 0, 0.1);
        flex-shrink: 0;
    }

    .seal-circle img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .header-text {
        color: white;
    }

    .header-text p {
        margin: 0;
        font-size: 9px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .header-text .republic {
        opacity: 1;
    }

    .header-text .barangay {
        font-size: 20px;
        font-weight: 800;
        margin: 4px 0;
    }

    .header-text .official {
        opacity: 0.8;
    }

    .id-badge {
        border: 1.5px solid rgba(255, 255, 255, 0.7);
        color: white;
        font-size: 12px;
        font-weight: 700;
        padding: 6px 16px;
        border-radius: 8px;
        letter-spacing: 1px;
    }

    .card-body {
        padding: 28px;
        display: flex;
        gap: 24px;
        align-items: flex-start;
    }

    .photo-box {
        width: 120px;
        min-width: 120px;
        height: 150px;
        border: 2px solid var(--secondary);
        border-radius: 12px;
        overflow: hidden;
        background: var(--gray-50);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .photo-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .photo-placeholder {
        font-size: 40px;
        color: var(--secondary);
        opacity: 0.5;
        margin-bottom: 4px;
    }

    .photo-text {
        color: var(--secondary);
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 700;
    }

    .info-section {
        flex: 1;
    }

    .resident-name {
        font-size: 26px;
        font-weight: 800;
        color: var(--gray-900);
        margin-bottom: 12px;
    }

    .info-divider {
        border: none;
        border-top: 1px solid var(--gray-200);
        margin-bottom: 16px;
    }

    .info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px 20px;
    }

    .info-field {
        display: flex;
        flex-direction: column;
    }

    .info-field.full {
        grid-column: 1 / -1;
    }

    .info-label {
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: var(--secondary);
    }

    .info-value {
        font-size: 14px;
        color: var(--gray-900);
        margin-top: 2px;
    }

    .id-number {
        font-family: 'Courier New', monospace;
        font-size: 18px;
        font-weight: 700;
        color: var(--gray-900);
    }

    .card-footer {
        background: var(--gray-50);
        border-top: 1px solid var(--gray-200);
        padding: 14px 28px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .footer-id {
        font-family: 'Courier New', monospace;
        font-weight: 700;
        font-size: 15px;
        color: var(--primary);
    }

    .barcode {
        display: flex;
        gap: 1px;
        align-items: center;
        justify-content: center;
        height: 30px;
    }

    .barcode-bar {
        background: var(--gray-900);
    }

    .bar-2 {
        width: 2px;
    }

    .bar-3 {
        width: 3px;
    }

    .validity-badge {
        background: var(--secondary);
        color: white;
        font-size: 13px;
        font-weight: 700;
        border-radius: 20px;
        padding: 6px 18px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    @media print {
        body * {
            visibility: hidden;
        }
        .id-card, .id-card * {
            visibility: visible;
        }
        .id-card {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            box-shadow: none;
            width: 540px;
        }
        .print-button,
        .page-header,
        .upload-section,
        .alert {
            display: none;
        }
    }
</style>

<div class="page-header">
    <h1 class="page-title">🪪 My Barangay ID</h1>
    <p class="page-subtitle">View and print your official barangay identification card</p>
</div>

<div class="page-wrapper">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-error">
            @foreach($errors->all() as $error)
                {{ $error }}
            @endforeach
        </div>
    @endif

    <div class="upload-section">
        <form action="{{ route('resident.online-id.photo') }}" method="POST" enctype="multipart/form-data" class="upload-form" id="photoUploadForm">
            @csrf
            <div class="file-input-wrapper">
                <input type="file" name="profile_photo" id="profile_photo" accept="image/*" onchange="updateFileName(this)">
                <label for="profile_photo" class="file-input-label">📷 Choose Photo</label>
            </div>
            <span class="file-name" id="fileName">No file chosen</span>
            <button type="submit" class="upload-button" id="uploadBtn" disabled>Upload Photo</button>
        </form>
    </div>

    <button class="print-button" onclick="window.print()">🖨️ Print My ID</button>

    <div class="id-card">
        <div class="card-header">
            <div class="header-left">
                <div class="seal-circle">
                    <img src="{{ asset('images/city_of_general_trias_seal.png') }}" alt="City Seal">
                </div>
                <div class="header-text">
                    <p class="republic">Republic of the Philippines</p>
                    <p class="barangay">Barangay</p>
                    <p class="official">Official Identification</p>
                </div>
            </div>
            <div class="id-badge">BRGY. ID</div>
        </div>

        <div class="card-body">
            <div class="photo-box">
                @if($onlineId->user->profile_photo)
                    <img src="{{ Storage::url('photos/' . $onlineId->user->profile_photo) }}" alt="Resident Photo">
                @else
                    <div class="photo-placeholder">👤</div>
                    <div class="photo-text">Photo</div>
                @endif
            </div>

            <div class="info-section">
                <div class="resident-name">{{ $onlineId->user->getFullName() }}</div>
                <hr class="info-divider">

                <div class="info-grid">
                    <div class="info-field full">
                        <span class="info-label">Date of Birth</span>
                        <span class="info-value">{{ optional($onlineId->user)->birthdate ? \Carbon\Carbon::parse($onlineId->user->birthdate)->format('F d, Y') : 'N/A' }}</span>
                    </div>

                    <div class="info-field">
                        <span class="info-label">House No.</span>
                        <span class="info-value">{{ $onlineId->house_number ?? 'N/A' }}</span>
                    </div>

                    <div class="info-field">
                        <span class="info-label">Address/Location</span>
                        <span class="info-value">{{ optional($onlineId->user)->address ?? 'N/A' }}</span>
                    </div>

                    <div class="info-field full">
                        <span class="info-label">ID Number</span>
                        <span class="info-value id-number">{{ $onlineId->id_number }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer">
            <div class="footer-id">{{ $onlineId->id_number }}</div>

            <div class="barcode">
                @for($i = 0; $i < 30; $i++)
                    <div class="barcode-bar {{ $i % 2 == 0 ? 'bar-2' : 'bar-3' }}"></div>
                @endfor
            </div>

            <div class="validity-badge">● VALID</div>
        </div>
    </div>
</div>

<script>
function updateFileName(input) {
    const fileName = document.getElementById('fileName');
    const uploadBtn = document.getElementById('uploadBtn');
    
    if (input.files && input.files[0]) {
        fileName.textContent = input.files[0].name;
        uploadBtn.disabled = false;
    } else {
        fileName.textContent = 'No file chosen';
        uploadBtn.disabled = true;
    }
}
</script>

@endsection
