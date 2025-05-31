<style>
    .notification {
        animation: bounceIn 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        position: relative;
        overflow: hidden;
        border-radius: 16px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    }

    .notification::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, rgba(255,255,255,0.3) 0%, rgba(255,255,255,0.8) 50%, rgba(255,255,255,0.3) 100%);
        animation: shimmer 2s infinite;
    }

    .notification.fade-out {
        animation: bounceOut 0.5s cubic-bezier(0.55, 0.085, 0.68, 0.53) forwards;
    }

    @keyframes bounceIn {
        0% {
            transform: translate(120%, -20px) rotate(5deg) scale(0.8);
            opacity: 0;
        }
        60% {
            transform: translate(-10px, 5px) rotate(-1deg) scale(1.05);
            opacity: 0.9;
        }
        100% {
            transform: translate(0, 0) rotate(0deg) scale(1);
            opacity: 1;
        }
    }

    @keyframes bounceOut {
        0% {
            transform: translate(0, 0) scale(1);
            opacity: 1;
        }
        100% {
            transform: translate(120%, -20px) scale(0.8) rotate(-5deg);
            opacity: 0;
        }
    }

    @keyframes shimmer {
        0% { transform: translateX(-100%); }
        100% { transform: translateX(100%); }
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.1); }
    }

    .notification-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.2);
        animation: pulse 2s infinite;
        flex-shrink: 0;
    }

    .notification-close {
        width: 32px;
        height: 32px;
        border: none;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        color: white;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
    }

    .notification-close:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: rotate(90deg) scale(1.1);
    }

    /* Specific notification types */
    .notification-error {
        background: linear-gradient(135deg, rgba(239, 68, 68, 0.95) 0%, rgba(220, 38, 38, 0.95) 100%);
    }

    .notification-success {
        background: linear-gradient(135deg, rgba(34, 197, 94, 0.95) 0%, rgba(21, 128, 61, 0.95) 100%);
    }

    .notification-info {
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.95) 0%, rgba(37, 99, 235, 0.95) 100%);
    }

    .notification-validation {
        background: linear-gradient(135deg, rgba(239, 68, 68, 0.95) 0%, rgba(220, 38, 38, 0.95) 100%);
    }
</style>

<div id="notification-container" class="fixed top-4 right-4 z-50 space-y-3 max-w-sm w-full">

    @if (session('error'))
        <div class="notification notification-error text-white px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="notification-icon">
                    <i class="fas fa-exclamation-triangle text-lg"></i>
                </div>
                <span class="font-medium">{{ session('error') }}</span>
            </div>
            <button onclick="closeNotification(this)" class="notification-close">
                <i class="fas fa-times text-sm"></i>
            </button>
        </div>
    @endif

    @if (session('success'))
        <div class="notification notification-success text-white px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="notification-icon">
                    <i class="fas fa-check-circle text-lg"></i>
                </div>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
            <button onclick="closeNotification(this)" class="notification-close">
                <i class="fas fa-times text-sm"></i>
            </button>
        </div>
    @endif

    @if (session('message'))
        <div class="notification notification-info text-white px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="notification-icon">
                    <i class="fas fa-info-circle text-lg"></i>
                </div>
                <span class="font-medium">{{ session('message') }}</span>
            </div>
            <button onclick="closeNotification(this)" class="notification-close">
                <i class="fas fa-times text-sm"></i>
            </button>
        </div>
    @endif

    @if ($errors->any())
        <div class="notification notification-validation text-white px-6 py-4">
            <div class="flex items-start justify-between">
                <div class="flex items-start gap-4">
                    <div class="notification-icon mt-1">
                        <i class="fas fa-exclamation-circle text-lg"></i>
                    </div>
                    <div>
                        <div class="font-semibold mb-3">Please fix the following errors:</div>
                        <ul class="space-y-2 text-sm">
                            @foreach ($errors->all() as $error)
                                <li class="flex items-start gap-2">
                                    <span class="text-red-200 mt-1">•</span>
                                    <span>{{ $error }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <button onclick="closeNotification(this)" class="notification-close flex-shrink-0 ml-4">
                    <i class="fas fa-times text-sm"></i>
                </button>
            </div>
        </div>
    @endif

</div>

<script>
function closeNotification(button) {
    const notification = button.closest('.notification');
    notification.classList.add('fade-out');
    
    setTimeout(() => {
        if (notification.parentNode) {
            notification.parentNode.removeChild(notification);
        }
    }, 500);
}

// Auto-dismiss notifications after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    const notifications = document.querySelectorAll('.notification');
    notifications.forEach(notification => {
        setTimeout(() => {
            const closeButton = notification.querySelector('.notification-close');
            if (closeButton && notification.parentNode) {
                closeNotification(closeButton);
            }
        }, 5000);
    });
});
</script>