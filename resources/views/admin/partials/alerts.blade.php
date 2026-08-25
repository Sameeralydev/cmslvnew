{{-- Toast Notification matching user screenshot --}}
<div id="toastContainer" style="position: fixed; top: 15px; right: 20px; z-index: 999999; display: flex; flex-direction: column; gap: 10px; pointer-events: none;">
    @php
        $successMessage = session('success') ?? session('status') ?? ($success_msg ?? null);
        $errorMessage = session('error') ?? ($error_msg ?? null);
    @endphp

    @if ($successMessage)
        <div class="custom-toast-alert custom-toast-success" style="pointer-events: auto; background: #ffffff; border-radius: 4px; box-shadow: 0 4px 15px rgba(0,0,0,0.18); display: flex; align-items: stretch; overflow: hidden; border: 1px solid #e5e7eb; min-height: 42px; animation: toastSlideIn 0.3s ease-out;">
            <div style="background-color: #5cb85c; color: #ffffff; display: flex; align-items: center; justify-content: center; padding: 0 14px; font-size: 16px;">
                <i class="fa fa-check"></i>
            </div>
            <div style="padding: 10px 18px; font-size: 14px; font-weight: 500; color: #111827; display: flex; align-items: center; white-space: nowrap;">
                {{ $successMessage }}
            </div>
            <div onclick="this.closest('.custom-toast-alert').remove()" style="padding: 0 14px; display: flex; align-items: center; justify-content: center; cursor: pointer; color: #111827; font-size: 16px; font-weight: bold; transition: color 0.15s;" onmouseover="this.style.color='#ef4444'" onmouseout="this.style.color='#111827'">
                <i class="fa fa-times"></i>
            </div>
        </div>
    @endif

    @if ($errorMessage)
        <div class="custom-toast-alert custom-toast-error" style="pointer-events: auto; background: #ffffff; border-radius: 4px; box-shadow: 0 4px 15px rgba(0,0,0,0.18); display: flex; align-items: stretch; overflow: hidden; border: 1px solid #fecaca; min-height: 42px; animation: toastSlideIn 0.3s ease-out;">
            <div style="background-color: #ef4444; color: #ffffff; display: flex; align-items: center; justify-content: center; padding: 0 14px; font-size: 16px;">
                <i class="fa fa-exclamation-triangle"></i>
            </div>
            <div style="padding: 10px 18px; font-size: 14px; font-weight: 500; color: #991b1b; display: flex; align-items: center; white-space: nowrap;">
                {{ $errorMessage }}
            </div>
            <div onclick="this.closest('.custom-toast-alert').remove()" style="padding: 0 14px; display: flex; align-items: center; justify-content: center; cursor: pointer; color: #991b1b; font-size: 16px; font-weight: bold;">
                <i class="fa fa-times"></i>
            </div>
        </div>
    @endif
</div>

@if ($errors->any())
    <div class="mb-4 rounded border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800" style="margin-bottom: 15px; border-radius: 4px; border: 1px solid #fecaca; background: #fef2f2; padding: 12px 16px; color: #991b1b;">
        <p style="font-weight: 600; margin: 0 0 5px 0;">Please correct the highlighted fields:</p>
        <ul style="margin: 0; padding-left: 20px;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<style>
    @keyframes toastSlideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    @keyframes toastFadeOut {
        from {
            opacity: 1;
            transform: translateY(0);
        }
        to {
            opacity: 0;
            transform: translateY(-10px);
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var toasts = document.querySelectorAll('.custom-toast-alert');
        toasts.forEach(function(toast) {
            setTimeout(function() {
                if (toast && toast.parentNode) {
                    toast.style.animation = 'toastFadeOut 0.4s ease-out forwards';
                    setTimeout(function() {
                        if (toast && toast.parentNode) toast.remove();
                    }, 400);
                }
            }, 4000);
        });
    });

    window.showToastMessage = function(message, type) {
        type = type || 'success';
        var container = document.getElementById('toastContainer');
        if (!container) {
            container = document.createElement('div');
            container.id = 'toastContainer';
            container.style.cssText = 'position: fixed; top: 15px; right: 20px; z-index: 999999; display: flex; flex-direction: column; gap: 10px; pointer-events: none;';
            document.body.appendChild(container);
        }

        var toast = document.createElement('div');
        toast.className = 'custom-toast-alert';
        toast.style.cssText = 'pointer-events: auto; background: #ffffff; border-radius: 4px; box-shadow: 0 4px 15px rgba(0,0,0,0.18); display: flex; align-items: stretch; overflow: hidden; border: 1px solid #e5e7eb; min-height: 42px; animation: toastSlideIn 0.3s ease-out;';

        var iconBg = type === 'error' ? '#ef4444' : '#5cb85c';
        var iconClass = type === 'error' ? 'fa-exclamation-triangle' : 'fa-check';
        var textColor = type === 'error' ? '#991b1b' : '#111827';

        toast.innerHTML = '<div style="background-color: ' + iconBg + '; color: #ffffff; display: flex; align-items: center; justify-content: center; padding: 0 14px; font-size: 16px;"><i class="fa ' + iconClass + '"></i></div>' +
            '<div style="padding: 10px 18px; font-size: 14px; font-weight: 500; color: ' + textColor + '; display: flex; align-items: center; white-space: nowrap;">' + message + '</div>' +
            '<div onclick="this.closest(\'.custom-toast-alert\').remove()" style="padding: 0 14px; display: flex; align-items: center; justify-content: center; cursor: pointer; color: #111827; font-size: 16px; font-weight: bold;"><i class="fa fa-times"></i></div>';

        container.appendChild(toast);

        setTimeout(function() {
            if (toast && toast.parentNode) {
                toast.style.animation = 'toastFadeOut 0.4s ease-out forwards';
                setTimeout(function() {
                    if (toast && toast.parentNode) toast.remove();
                }, 400);
            }
        }, 4000);
    };
</script>
