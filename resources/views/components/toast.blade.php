<div id="toast-container" class="fixed top-2 right-2 md:top-4 md:right-4 z-[9998] flex flex-col gap-2 md:gap-3 max-w-[280px] md:max-w-sm w-full pointer-events-none px-2 md:px-0">
    
</div>

@unless(View::shared('disableAutoToast', false))
    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                showToast(@json(session('success')), 'success');
            });
        </script>
    @endif

    @if(session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                showToast(@json(session('error')), 'error');
            });
        </script>
    @endif

    @if(session('warning'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                showToast(@json(session('warning')), 'warning');
            });
        </script>
    @endif

    @if(session('info'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                showToast(@json(session('info')), 'info');
            });
        </script>
    @endif

    @if($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                @foreach($errors->all() as $error)
                    showToast(@json($error), 'error');
                @endforeach
            });
        </script>
    @endif
@endunless

<style>
    .toast-notification {
        animation: slideIn 0.3s ease-out forwards;
        pointer-events: auto;
    }
    
    .toast-notification.removing {
        animation: slideOut 0.3s ease-in forwards;
    }
    
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(100%);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
    
    @keyframes slideOut {
        from {
            opacity: 1;
            transform: translateX(0);
        }
        to {
            opacity: 0;
            transform: translateX(100%);
        }
    }
    
    .toast-progress {
        animation: progress linear forwards;
    }
    
    @keyframes progress {
        from {
            width: 100%;
        }
        to {
            width: 0%;
        }
    }
</style>

<script>
    const toastIcons = {
        success: `<svg class="w-5 h-5 md:w-6 md:h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>`,
        error: `<svg class="w-5 h-5 md:w-6 md:h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>`,
        warning: `<svg class="w-5 h-5 md:w-6 md:h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
        </svg>`,
        info: `<svg class="w-5 h-5 md:w-6 md:h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>`
    };
    
    const toastStyles = {
        success: {
            bg: 'bg-gradient-to-r from-[#2d7e37] to-[#18471d]',
            icon: 'text-white',
            text: 'text-white',
            progress: 'bg-white/40'
        },
        error: {
            bg: 'bg-gradient-to-r from-red-500 to-red-700',
            icon: 'text-white',
            text: 'text-white',
            progress: 'bg-white/40'
        },
        warning: {
            bg: 'bg-gradient-to-r from-amber-400 to-amber-600',
            icon: 'text-white',
            text: 'text-white',
            progress: 'bg-white/40'
        },
        info: {
            bg: 'bg-gradient-to-r from-blue-500 to-blue-700',
            icon: 'text-white',
            text: 'text-white',
            progress: 'bg-white/40'
        }
    };
    
    const toastTitles = {
        success: 'Berhasil!',
        error: 'Error!',
        warning: 'Peringatan!',
        info: 'Informasi'
    };
    
    function showToast(message, type = 'info', duration = 5000) {
        const container = document.getElementById('toast-container');
        const style = toastStyles[type] || toastStyles.info;
        const icon = toastIcons[type] || toastIcons.info;
        const title = toastTitles[type] || toastTitles.info;
        
        const toastId = 'toast-' + Date.now();
        
        const toastHtml = `
            <div id="${toastId}" class="toast-notification ${style.bg} rounded-lg md:rounded-xl shadow-2xl overflow-hidden backdrop-blur-sm border border-white/10">
                <div class="p-2.5 md:p-4">
                    <div class="flex items-start gap-2 md:gap-3">
                        <!-- Icon -->
                        <div class="${style.icon} flex-shrink-0 mt-0.5">
                            ${icon}
                        </div>
                        
                        <!-- Content -->
                        <div class="flex-1 min-w-0">
                            <h4 class="${style.text} font-bold text-xs md:text-sm">${title}</h4>
                            <p class="${style.text}/90 text-xs md:text-sm mt-0.5">${message}</p>
                        </div>
                        
                        <!-- Close Button -->
                        <button onclick="removeToast('${toastId}')" class="${style.text}/70 hover:${style.text} transition-colors flex-shrink-0">
                            <svg class="w-4 h-4 md:w-5 md:h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>
                
                <!-- Progress Bar -->
                <div class="h-0.5 md:h-1 ${style.progress} toast-progress" style="animation-duration: ${duration}ms"></div>
            </div>
        `;
        
        container.insertAdjacentHTML('beforeend', toastHtml);
        
        setTimeout(() => {
            removeToast(toastId);
        }, duration);
        
        return toastId;
    }
    
    function removeToast(toastId) {
        const toast = document.getElementById(toastId);
        if (toast) {
            toast.classList.add('removing');
            setTimeout(() => {
                toast.remove();
            }, 300);
        }
    }
    
    window.originalAlert = window.alert;
    window.alert = function(message) {
        showToast(message, 'info');
    };
    
    function showConfirm(message, onConfirm, onCancel = null, options = {}) {
        const {
            title = 'Konfirmasi',
            confirmText = 'Ya, Lanjutkan',
            cancelText = 'Batal',
            type = 'warning'
        } = options;
        
        const style = toastStyles[type] || toastStyles.warning;
        
        const overlayId = 'confirm-overlay-' + Date.now();
        const overlayHtml = `
            <div id="${overlayId}" class="fixed inset-0 z-[9999] flex items-center justify-center p-3 md:p-4 bg-black/50 backdrop-blur-sm opacity-0 transition-opacity duration-300">
                <div class="bg-white rounded-xl md:rounded-2xl shadow-2xl max-w-[320px] md:max-w-md w-full transform scale-95 transition-transform duration-300 overflow-hidden" id="${overlayId}-dialog">
                    <!-- Header -->
                    <div class="${style.bg} px-4 md:px-6 py-3 md:py-4">
                        <div class="flex items-center gap-2 md:gap-3">
                            <div class="${style.icon}">
                                ${toastIcons[type]}
                            </div>
                            <h3 class="${style.text} font-bold text-base md:text-lg">${title}</h3>
                        </div>
                    </div>
                    
                    <!-- Content -->
                    <div class="px-4 md:px-6 py-4 md:py-5">
                        <p class="text-gray-700 text-sm md:text-base">${message}</p>
                    </div>
                    
                    <!-- Actions -->
                    <div class="px-4 md:px-6 py-3 md:py-4 bg-gray-50 flex justify-end gap-2 md:gap-3">
                        <button onclick="closeConfirm('${overlayId}', false)" class="px-3 md:px-4 py-1.5 md:py-2 rounded-lg border border-gray-300 text-gray-700 text-sm md:text-base font-medium hover:bg-gray-100 transition-colors">
                            ${cancelText}
                        </button>
                        <button onclick="closeConfirm('${overlayId}', true)" class="px-3 md:px-4 py-1.5 md:py-2 rounded-lg ${style.bg} text-white text-sm md:text-base font-medium hover:opacity-90 transition-opacity">
                            ${confirmText}
                        </button>
                    </div>
                </div>
            </div>
        `;
        
        document.body.insertAdjacentHTML('beforeend', overlayHtml);
        
        const overlay = document.getElementById(overlayId);
        const dialog = document.getElementById(overlayId + '-dialog');
        
        overlay._onConfirm = onConfirm;
        overlay._onCancel = onCancel;
        
        requestAnimationFrame(() => {
            overlay.classList.remove('opacity-0');
            overlay.classList.add('opacity-100');
            dialog.classList.remove('scale-95');
            dialog.classList.add('scale-100');
        });
        
        overlay.addEventListener('click', function(e) {
            if (e.target === overlay) {
                closeConfirm(overlayId, false);
            }
        });
        
        const escHandler = function(e) {
            if (e.key === 'Escape') {
                closeConfirm(overlayId, false);
                document.removeEventListener('keydown', escHandler);
            }
        };
        document.addEventListener('keydown', escHandler);
    }
    
    function closeConfirm(overlayId, confirmed) {
        const overlay = document.getElementById(overlayId);
        if (!overlay) return;
        
        const dialog = document.getElementById(overlayId + '-dialog');
        
        overlay.classList.remove('opacity-100');
        overlay.classList.add('opacity-0');
        dialog.classList.remove('scale-100');
        dialog.classList.add('scale-95');
        
        setTimeout(() => {
            if (confirmed && overlay._onConfirm) {
                overlay._onConfirm();
            } else if (!confirmed && overlay._onCancel) {
                overlay._onCancel();
            }
            overlay.remove();
        }, 300);
    }
</script>
