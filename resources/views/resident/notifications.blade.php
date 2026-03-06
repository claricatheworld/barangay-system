@extends('layouts.resident')

@section('title', 'Announcements')

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

    .stats-bar {
        display: flex;
        gap: 16px;
        margin-bottom: 24px;
    }

    .stat-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 16px;
        background: white;
        border: 1px solid var(--gray-200);
        border-radius: 12px;
        font-size: 14px;
        font-weight: 600;
        color: var(--gray-700);
    }

    .stat-badge.unread {
        background: var(--primary-light);
        border-color: var(--primary);
        color: var(--primary);
    }

    .notif-card {
        background: white;
        border-radius: 16px;
        padding: 24px;
        box-shadow: var(--shadow-sm);
        margin-bottom: 16px;
        border: 1px solid var(--gray-200);
        transition: all 0.3s;
    }

    .notif-card:hover {
        box-shadow: var(--shadow);
        border-color: var(--primary);
    }

    .notif-card.unread {
        border-left: 4px solid var(--primary);
    }

    .notif-card.read {
        opacity: 0.8;
    }

    .notif-header {
        display: flex;
        align-items: flex-start;
        gap: 16px;
        margin-bottom: 12px;
    }

    .notif-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        background: var(--primary-light);
        color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        flex-shrink: 0;
    }

    .notif-card.read .notif-icon {
        background: var(--gray-100);
        color: var(--gray-400);
    }

    .notif-content {
        flex: 1;
    }

    .notif-title {
        font-size: 18px;
        font-weight: 700;
        color: var(--gray-900);
        margin-bottom: 4px;
    }

    .notif-meta {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 13px;
        color: var(--gray-500);
        margin-bottom: 12px;
    }

    .notif-message {
        font-size: 15px;
        color: var(--gray-700);
        line-height: 1.6;
        margin-bottom: 16px;
    }

    .notif-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .sender-tag {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: var(--gray-100);
        color: var(--gray-700);
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 500;
    }

    .mark-read-btn {
        border: none;
        background: var(--primary);
        color: white;
        border-radius: 8px;
        padding: 8px 16px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
    }

    .mark-read-btn:hover {
        background: var(--primary-dark);
    }

    .mark-all-btn {
        background: var(--primary);
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
    }

    .mark-all-btn:hover {
        background: var(--primary-dark);
    }

    .empty-state {
        text-align: center;
        padding: 80px 20px;
        background: white;
        border-radius: 16px;
        border: 1px solid var(--gray-200);
    }

    .empty-icon {
        font-size: 80px;
        margin-bottom: 20px;
        opacity: 0.3;
    }

    .empty-title {
        font-size: 20px;
        font-weight: 700;
        color: var(--gray-900);
        margin-bottom: 8px;
    }

    .empty-subtitle {
        font-size: 14px;
        color: var(--gray-500);
    }

    .pagination {
        display: flex;
        justify-content: center;
        gap: 8px;
        margin-top: 32px;
    }

    .pagination a,
    .pagination span {
        padding: 10px 16px;
        border: 1px solid var(--gray-200);
        border-radius: 8px;
        text-decoration: none;
        font-size: 14px;
        color: var(--gray-700);
        background: white;
        cursor: pointer;
        transition: all 0.2s;
    }

    .pagination a:hover {
        background: var(--primary);
        color: white;
        border-color: var(--primary);
    }

    .pagination .active span {
        background: var(--primary);
        color: white;
        border-color: var(--primary);
    }
</style>

<div class="page-header">
    <h1 class="page-title">📢 Community Announcements</h1>
    <p class="page-subtitle">Stay updated with important barangay announcements and notifications</p>
</div>

<div class="stats-bar">
    <div class="stat-badge">
        <span>📬</span>
        <span>{{ $notifications->total() }} Total</span>
    </div>
    @if(($unread ?? 0) > 0)
        <div class="stat-badge unread">
            <span>🔔</span>
            <span>{{ $unread }} Unread</span>
        </div>
        <button class="mark-all-btn" onclick="markAllAsRead()">Mark All as Read</button>
    @endif
</div>

@if($notifications->count() > 0)
    @foreach($notifications as $notification)
        <div class="notif-card @if(!$notification->is_read) unread @else read @endif" data-id="{{ $notification->id }}">
            <div class="notif-header">
                <div class="notif-icon">📣</div>
                <div class="notif-content">
                    <h3 class="notif-title">{{ $notification->title }}</h3>
                    <div class="notif-meta">
                        <span>📅 {{ $notification->created_at->format('F d, Y') }}</span>
                        <span>•</span>
                        <span>🕐 {{ $notification->created_at->format('g:i A') }}</span>
                    </div>
                    <p class="notif-message">{{ $notification->message }}</p>
                    <div class="notif-footer">
                        @if($notification->sender_id)
                            <span class="sender-tag">
                                <span>👤</span>
                                <span>{{ ($notification->sender ? $notification->sender->getFullName() : 'Barangay Official') }}</span>
                            </span>
                        @else
                            <span></span>
                        @endif
                        @if(!$notification->is_read)
                            <button class="mark-read-btn" data-id="{{ $notification->id }}" onclick="markAsRead(this)">
                                Mark as Read
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endforeach>

    <div class="pagination">
        {{ $notifications->links() }}
    </div>
@else
    <div class="empty-state">
        <div class="empty-icon">📭</div>
        <p class="empty-title">No announcements yet</p>
        <p class="empty-subtitle">Check back later for important community updates</p>
    </div>
@endif

<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
    function markAsRead(button) {
        const id = button.dataset.id;
        const card = button.closest('.notif-card');
        
        fetch(`/resident/notifications/${id}/read`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json'
            }
        })
        .then(r => r.json())
        .then(data => {
            if(data.success) {
                card.classList.remove('unread');
                card.classList.add('read');
                button.remove();
                
                // Update icon styling
                const icon = card.querySelector('.notif-icon');
                if(icon) {
                    icon.style.background = 'var(--gray-100)';
                    icon.style.color = 'var(--gray-400)';
                }
                
                // Reload to update unread count
                setTimeout(() => location.reload(), 500);
            }
        })
        .catch(err => console.error('Error:', err));
    }

    function markAllAsRead() {
        const buttons = document.querySelectorAll('.mark-read-btn');
        buttons.forEach(btn => {
            markAsRead(btn);
        });
    }
</script>

@endsection
