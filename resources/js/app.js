import './bootstrap';

window.addEventListener('livewire:initialized', () => {
    Livewire.on('notify', (data) => {
        const event = Array.isArray(data) ? data[0] : data;
        showToast(event.message, event.type || 'info');
    });
});

function showToast(message, type = 'info') {
    const existing = document.querySelectorAll('.toast-notification');
    existing.forEach(t => t.remove());

    const typeClasses = {
        success: 'bg-[#34C759]',
        error: 'bg-[#FF3B30]',
        warning: 'bg-[#FF9500]',
        info: 'bg-[#007AFF]',
    };

    const icons = {
        success: '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>',
        error: '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>',
        warning: '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.07 16.5c-.77.833.192 2.5 1.732 2.5z" /></svg>',
        info: '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>',
    };

    const toast = document.createElement('div');
    toast.className = `toast-notification fixed bottom-6 right-6 z-50 flex items-center gap-3 px-5 py-3.5 rounded-xl shadow-lg text-sm font-medium text-white min-w-[280px] animate-toast-in ${typeClasses[type] || typeClasses.info}`;
    toast.innerHTML = `<span class="flex-shrink-0">${icons[type] || icons.info}</span><span>${message}</span>`;

    document.body.appendChild(toast);

    setTimeout(() => {
        toast.style.animation = 'toastOut 0.2s ease-in forwards';
        setTimeout(() => toast.remove(), 200);
    }, 3500);
}
