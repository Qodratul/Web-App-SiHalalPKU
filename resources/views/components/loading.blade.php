{{-- Loading Overlay Component --}}
{{-- 
    Usage: 
    - Include @include('components.loading') in your layout
    - Call showLoading() / hideLoading() from JavaScript
    - Or use data-loading attribute on forms/links for auto loading
--}}

<div id="loading-overlay" class="fixed inset-0 z-[9999] flex items-center justify-center bg-gradient-to-br from-[#2d7e37]/95 to-[#18471d]/95 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300">
    <div class="flex flex-col items-center gap-6">
        {{-- Logo dengan animasi --}}
        <div class="relative">
            {{-- Outer ring --}}
            <div class="absolute inset-0 w-28 h-28 rounded-full border-4 border-white/20 animate-ping"></div>
            
            {{-- Spinner ring --}}
            <div class="w-28 h-28 rounded-full border-4 border-transparent border-t-white border-r-white/50 animate-spin"></div>
            
            {{-- Center icon - Halal themed --}}
            <div class="absolute inset-0 flex items-center justify-center">
                <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center shadow-lg animate-pulse">
                    {{-- Mosque/Halal icon --}}
                    <svg class="w-9 h-9 text-[#2d7e37]" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2C9.5 4 7 6.5 7 9c0 2.5 2 4.5 4.5 4.5h1c2.5 0 4.5-2 4.5-4.5 0-2.5-2.5-5-5-7z"/>
                        <path d="M6 13v8h2v-5h8v5h2v-8c-1.5 1-3.5 1.5-6 1.5s-4.5-.5-6-1.5z"/>
                        <path d="M11 16h2v5h-2z"/>
                    </svg>
                </div>
            </div>
        </div>
        
        {{-- Loading text --}}
        <div class="text-center">
            <h3 class="text-white text-xl font-bold mb-2">SiHalalPKU</h3>
            <div class="flex items-center gap-1 text-white/80">
                <span class="loading-text">Memuat</span>
                <span class="loading-dots">
                    <span class="dot animate-bounce" style="animation-delay: 0ms">.</span>
                    <span class="dot animate-bounce" style="animation-delay: 150ms">.</span>
                    <span class="dot animate-bounce" style="animation-delay: 300ms">.</span>
                </span>
            </div>
        </div>
        
        {{-- Progress bar --}}
        <div class="w-48 h-1.5 bg-white/20 rounded-full overflow-hidden">
            <div class="h-full bg-white rounded-full animate-loading-bar"></div>
        </div>
    </div>
</div>

<style>
    @keyframes loading-bar {
        0% {
            width: 0%;
            margin-left: 0%;
        }
        50% {
            width: 60%;
            margin-left: 20%;
        }
        100% {
            width: 0%;
            margin-left: 100%;
        }
    }
    
    .animate-loading-bar {
        animation: loading-bar 1.5s ease-in-out infinite;
    }
    
    .loading-dots .dot {
        display: inline-block;
    }
    
    #loading-overlay.show {
        opacity: 1;
        pointer-events: auto;
    }
    
    /* Page transition effect */
    .page-transitioning {
        overflow: hidden;
    }
</style>

<script>
    // Loading overlay functions
    function showLoading(text = 'Memuat') {
        const overlay = document.getElementById('loading-overlay');
        const loadingText = overlay.querySelector('.loading-text');
        if (loadingText) loadingText.textContent = text;
        overlay.classList.add('show');
        document.body.classList.add('page-transitioning');
    }
    
    function hideLoading() {
        const overlay = document.getElementById('loading-overlay');
        overlay.classList.remove('show');
        document.body.classList.remove('page-transitioning');
    }
    
    // Auto-attach to forms with data-loading attribute
    document.addEventListener('DOMContentLoaded', function() {
        // Forms with data-loading
        document.querySelectorAll('form[data-loading]').forEach(form => {
            form.addEventListener('submit', function(e) {
                const loadingText = this.dataset.loading || 'Menyimpan';
                showLoading(loadingText);
            });
        });
        
        // Links with data-loading
        document.querySelectorAll('a[data-loading]').forEach(link => {
            link.addEventListener('click', function(e) {
                const loadingText = this.dataset.loading || 'Memuat';
                showLoading(loadingText);
            });
        });
    });
    
    // Show loading on page navigation (back/forward)
    window.addEventListener('pageshow', function(e) {
        hideLoading();
    });
    
    // Show loading before page unload (navigation)
    window.addEventListener('beforeunload', function(e) {
        // Only show if not already showing (prevents double trigger)
        const overlay = document.getElementById('loading-overlay');
        if (!overlay.classList.contains('show')) {
            showLoading('Memuat');
        }
    });
</script>
