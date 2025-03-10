<div id="alert-container" class="fixed top-6 right-6 z-50 flex flex-col gap-3">
    <div role="alert" 
         class="w-96 animate-fade-in rounded-lg border-l-4 bg-white p-4 shadow-md
         {{ $type === 'success' ? 'border-l-green-500' : 'border-l-red-500' }}">
        <div class="flex items-center gap-3">
            @if($type === 'success')
            <span class="text-green-500">
                <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
            </span>
            @elseif($type === 'error')
            <span class="text-red-500">
                <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </span>
            @endif

            <div class="flex-1">
                <p class="font-medium {{ $type === 'success' ? 'text-green-700' : 'text-red-700' }}">
                    {{ $message }}
                </p>
                @if($desc)
                <p class="text-sm text-gray-600">{{ $desc }}</p>
                @endif
            </div>

            <button onclick="dismissAlert(this)" class="text-gray-400 hover:text-gray-600">
                <span class="sr-only">Dismiss</span>
                <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>
</div>

<style>
    .animate-fade-in {
        animation: fadeIn 0.3s ease-out;
    }
    
    @keyframes fadeIn {
        from { 
            opacity: 0; 
            transform: translateX(20px); 
        }
        to { 
            opacity: 1; 
            transform: translateX(0); 
        }
    }

    @keyframes fadeOut {
        from { 
            opacity: 1; 
            transform: translateX(0); 
        }
        to { 
            opacity: 0; 
            transform: translateX(20px); 
        }
    }
</style>

<script>
    // Create container if it doesn't exist
    document.addEventListener('DOMContentLoaded', () => {
        if (!document.getElementById('alert-container')) {
            const container = document.createElement('div');
            container.id = 'alert-container';
            container.className = 'fixed top-6 right-6 z-50 flex flex-col gap-3';
            document.body.appendChild(container);
        }
    });

    function dismissAlert(button) {
        const alert = button.closest('[role="alert"]');
        alert.style.animation = 'fadeOut 0.3s ease-out forwards';
        setTimeout(() => {
            alert.remove();
            // Remove container if no alerts left
            const container = document.getElementById('alert-container');
            if (container && !container.hasChildNodes()) {
                container.remove();
            }
        }, 300);
    }

    // Auto dismiss after 5 seconds
    setTimeout(() => {
        const alert = document.querySelector('[role="alert"]');
        if (alert) {
            dismissAlert(alert.querySelector('button'));
        }
    }, 5000);
</script>


