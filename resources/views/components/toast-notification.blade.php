<div x-data="{
    show: false,
    message: '',
    type: 'success',
    timeout: null,
    showNotification(event) {
        this.message = event.detail.message || event.detail[0]?.message || 'Success';
        this.type = event.detail.type || event.detail[0]?.type || 'success';
        this.show = true;
        
        clearTimeout(this.timeout);
        this.timeout = setTimeout(() => {
            this.show = false;
        }, 3000);
    }
}" 
@notify.window="showNotification($event)"
x-show="show"
x-transition:enter="transform ease-out duration-300 transition"
x-transition:enter-start="translate-y-2 opacity-0"
x-transition:enter-end="translate-y-0 opacity-100"
x-transition:leave="transition ease-in duration-200"
x-transition:leave-start="opacity-100"
x-transition:leave-end="opacity-0"
class="pointer-events-none fixed inset-x-0 bottom-0 z-50 flex items-end justify-center px-4 py-6 sm:items-start sm:justify-end sm:p-6"
style="display: none;">
    <div class="pointer-events-auto w-full max-w-sm overflow-hidden rounded-lg shadow-lg ring-1"
         :class="{
            'bg-emerald-50 ring-emerald-500 dark:bg-emerald-900/50': type === 'success',
            'bg-red-50 ring-red-500 dark:bg-red-900/50': type === 'error',
            'bg-blue-50 ring-blue-500 dark:bg-blue-900/50': type === 'info',
            'bg-amber-50 ring-amber-500 dark:bg-amber-900/50': type === 'warning'
         }">
        <div class="p-4">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <!-- Success Icon -->
                    <svg x-show="type === 'success'" class="h-6 w-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <!-- Error Icon -->
                    <svg x-show="type === 'error'" class="h-6 w-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <!-- Info Icon -->
                    <svg x-show="type === 'info'" class="h-6 w-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <!-- Warning Icon -->
                    <svg x-show="type === 'warning'" class="h-6 w-6 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div class="ml-3 w-0 flex-1 pt-0.5">
                    <p class="text-sm font-medium"
                       :class="{
                           'text-emerald-800 dark:text-emerald-200': type === 'success',
                           'text-red-800 dark:text-red-200': type === 'error',
                           'text-blue-800 dark:text-blue-200': type === 'info',
                           'text-amber-800 dark:text-amber-200': type === 'warning'
                       }"
                       x-text="message"></p>
                </div>
                <div class="ml-4 flex flex-shrink-0">
                    <button @click="show = false" class="inline-flex rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2"
                            :class="{
                                'text-emerald-400 hover:text-emerald-500 focus:ring-emerald-500': type === 'success',
                                'text-red-400 hover:text-red-500 focus:ring-red-500': type === 'error',
                                'text-blue-400 hover:text-blue-500 focus:ring-blue-500': type === 'info',
                                'text-amber-400 hover:text-amber-500 focus:ring-amber-500': type === 'warning'
                            }">
                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

