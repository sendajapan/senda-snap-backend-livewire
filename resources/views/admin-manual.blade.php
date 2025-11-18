<x-layouts.public>
    <div class="flex h-full w-full flex-1 flex-col gap-4">
        <!-- Main Header -->
        <x-page-header
            :title="__('Admin Manual')"
            :description="__('Complete guide for managing the web application. Please refer to this manual for detailed instructions.')"
            variant="violet">
            <x-slot:icon>
                <svg class="h-7 w-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </x-slot:icon>
        </x-page-header>

        <!-- Dashboard Section -->
        <x-table-card variant="violet">
            <div class="space-y-6">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-violet-500 to-purple-600 shadow-lg">
                        <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ __('Dashboard') }}</h2>
                </div>

                <div class="space-y-4">
                    <p class="text-sm text-gray-700 dark:text-gray-300">
                        {{ __('The dashboard provides an overview of your application with key statistics, charts, and upcoming tasks. This is the main landing page after logging into the system.') }}
                    </p>

                    <!-- Screenshot Placeholder -->
                    <div class="rounded-xl border-2 border-dashed border-gray-300 bg-gray-100 p-12 text-center dark:border-gray-700 dark:bg-gray-800">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <p class="mt-4 text-sm font-medium text-gray-600 dark:text-gray-400">{{ __('Screenshot will be added here') }}</p>
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-500">{{ __('Kindly add screenshot image here') }}</p>
                    </div>

                    <div class="space-y-3">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ __('Dashboard Features') }}</h3>
                        <ul class="list-disc space-y-2 pl-6 text-sm text-gray-700 dark:text-gray-300">
                            <li>{{ __('Welcome card displaying personalised greeting with user name') }}</li>
                            <li>{{ __('Date and time card showing current date, time, and next upcoming task') }}</li>
                            <li>{{ __('Statistics cards displaying total users, tasks, vehicles, and notifications') }}</li>
                            <li>{{ __('Task status chart showing distribution of tasks by status (Pending, Running, Completed, Cancelled)') }}</li>
                            <li>{{ __('Upcoming tasks table displaying the next 3 tasks sorted by work date and time') }}</li>
                            <li>{{ __('Members table showing team members with role counts') }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </x-table-card>

        <!-- User Management Section -->
        <x-table-card variant="blue">
            <div class="space-y-6">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-blue-500 to-cyan-600 shadow-lg">
                        <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ __('User Management') }}</h2>
                </div>

                <div class="space-y-4">
                    <p class="text-sm text-gray-700 dark:text-gray-300">
                        {{ __('The user management section allows administrators to view, create, edit, and manage all users in the system. You can assign roles, update user information, and manage user access permissions.') }}
                    </p>

                    <!-- Screenshot Placeholder -->
                    <div class="rounded-xl border-2 border-dashed border-gray-300 bg-gray-100 p-12 text-center dark:border-gray-700 dark:bg-gray-800">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <p class="mt-4 text-sm font-medium text-gray-600 dark:text-gray-400">{{ __('Screenshot will be added here') }}</p>
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-500">{{ __('Kindly add screenshot image here') }}</p>
                    </div>

                    <div class="space-y-3">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ __('User Management Features') }}</h3>
                        <ul class="list-disc space-y-2 pl-6 text-sm text-gray-700 dark:text-gray-300">
                            <li>{{ __('View all users in a searchable and filterable table') }}</li>
                            <li>{{ __('Create new users with role assignment') }}</li>
                            <li>{{ __('Edit existing user information and roles') }}</li>
                            <li>{{ __('View user details including avatar, email, phone number, and role') }}</li>
                            <li>{{ __('Filter users by role (Admin, Manager, Employee, Client)') }}</li>
                        </ul>
                    </div>

                    <div class="space-y-3">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ __('User Form Input Fields') }}</h3>
                        <ul class="list-disc space-y-2 pl-6 text-sm text-gray-700 dark:text-gray-300">
                            <li><strong>{{ __('Name') }}:</strong> {{ __('Full name of the user (mandatory field)') }}</li>
                            <li><strong>{{ __('Email') }}:</strong> {{ __('Email address used for login (mandatory field, must be unique)') }}</li>
                            <li><strong>{{ __('Password') }}:</strong> {{ __('Secure password for account access (mandatory field, minimum 8 characters required)') }}</li>
                            <li><strong>{{ __('Phone') }}:</strong> {{ __('Contact phone number (optional field)') }}</li>
                            <li><strong>{{ __('Role') }}:</strong> {{ __('User role selection: Admin, Manager, Employee, or Client (mandatory field)') }}</li>
                            <li><strong>{{ __('Avatar') }}:</strong> {{ __('Profile picture upload (optional field, supports image files)') }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </x-table-card>

        <!-- Task Management Section -->
        <x-table-card variant="emerald">
            <div class="space-y-6">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 shadow-lg">
                        <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ __('Task Management') }}</h2>
                </div>

                <div class="space-y-4">
                    <p class="text-sm text-gray-700 dark:text-gray-300">
                        {{ __('The task management section allows you to create, assign, track, and manage tasks throughout their lifecycle. Tasks can be assigned to multiple users and include work dates and times for scheduling purposes.') }}
                    </p>

                    <!-- Screenshot Placeholder -->
                    <div class="rounded-xl border-2 border-dashed border-gray-300 bg-gray-100 p-12 text-center dark:border-gray-700 dark:bg-gray-800">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <p class="mt-4 text-sm font-medium text-gray-600 dark:text-gray-400">{{ __('Screenshot will be added here') }}</p>
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-500">{{ __('Kindly add screenshot image here') }}</p>
                    </div>

                    <div class="space-y-3">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ __('Task Management Features') }}</h3>
                        <ul class="list-disc space-y-2 pl-6 text-sm text-gray-700 dark:text-gray-300">
                            <li>{{ __('View all tasks in a searchable and filterable table') }}</li>
                            <li>{{ __('Filter tasks by status (Pending, Running, Completed, Cancelled)') }}</li>
                            <li>{{ __('Filter tasks by priority (Low, Medium, High, Urgent)') }}</li>
                            <li>{{ __('Filter tasks by date range using from and to date filters') }}</li>
                            <li>{{ __('Create new tasks with detailed information and assignments') }}</li>
                            <li>{{ __('Edit existing tasks to update status, priority, or other details') }}</li>
                            <li>{{ __('Assign tasks to one or multiple users') }}</li>
                            <li>{{ __('Attach files to tasks for additional documentation purposes') }}</li>
                            <li>{{ __('View task details including description, assigned users, and attachments') }}</li>
                        </ul>
                    </div>

                    <div class="space-y-3">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ __('Task Form Input Fields') }}</h3>
                        <ul class="list-disc space-y-2 pl-6 text-sm text-gray-700 dark:text-gray-300">
                            <li><strong>{{ __('Title') }}:</strong> {{ __('Task title or name (mandatory field, maximum 255 characters)') }}</li>
                            <li><strong>{{ __('Description') }}:</strong> {{ __('Detailed description of the task (optional field, supports multi-line text)') }}</li>
                            <li><strong>{{ __('Status') }}:</strong> {{ __('Current task status: Pending, Running, Completed, or Cancelled (mandatory field)') }}</li>
                            <li><strong>{{ __('Priority') }}:</strong> {{ __('Task priority level: Low, Medium, High, or Urgent (mandatory field)') }}</li>
                            <li><strong>{{ __('Work Date') }}:</strong> {{ __('Scheduled date for task completion (mandatory field, date picker)') }}</li>
                            <li><strong>{{ __('Work Time') }}:</strong> {{ __('Scheduled time for task completion (optional field, time picker)') }}</li>
                            <li><strong>{{ __('Assigned Users') }}:</strong> {{ __('Select one or multiple users to assign the task to (optional field, multi-select)') }}</li>
                            <li><strong>{{ __('File Attachments') }}:</strong> {{ __('Upload files related to the task (optional field, supports multiple files, maximum 10MB per file)') }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </x-table-card>
    </div>

    @push('scripts')
        <script>
            (function() {
                const canvas = document.getElementById('particle-canvas');
                if (!canvas) return;
                
                const ctx = canvas.getContext('2d');
                let particles = [];
                let animationId;
                
                // Set canvas size
                function resizeCanvas() {
                    canvas.width = window.innerWidth;
                    canvas.height = window.innerHeight;
                }
                resizeCanvas();
                window.addEventListener('resize', resizeCanvas);
                
                // Color palette matching design system
                const colorPalettes = {
                    light: {
                        violet: '124, 58, 237',
                        blue: '59, 130, 246',
                        emerald: '16, 185, 129',
                        amber: '245, 158, 11',
                        purple: '168, 85, 247',
                        cyan: '6, 182, 212',
                        teal: '20, 184, 166',
                        orange: '249, 115, 22'
                    },
                    dark: {
                        violet: '139, 92, 246',
                        blue: '96, 165, 250',
                        emerald: '52, 211, 153',
                        amber: '251, 191, 36',
                        purple: '192, 132, 252',
                        cyan: '34, 211, 238',
                        teal: '45, 212, 191',
                        orange: '251, 146, 60'
                    }
                };
                
                // Particle class
                class Particle {
                    constructor() {
                        this.x = Math.random() * canvas.width;
                        this.y = Math.random() * canvas.height;
                        this.size = Math.random() * 2 + 0.5;
                        this.speedX = (Math.random() - 0.5) * 0.5;
                        this.speedY = (Math.random() - 0.5) * 0.5;
                        this.opacity = Math.random() * 0.5 + 0.2;
                        
                        // Randomly assign a color from the palette
                        const isDark = document.documentElement.classList.contains('dark');
                        const palette = isDark ? colorPalettes.dark : colorPalettes.light;
                        const colors = Object.values(palette);
                        this.color = colors[Math.floor(Math.random() * colors.length)];
                    }
                    
                    update() {
                        this.x += this.speedX;
                        this.y += this.speedY;
                        
                        if (this.x > canvas.width) this.x = 0;
                        if (this.x < 0) this.x = canvas.width;
                        if (this.y > canvas.height) this.y = 0;
                        if (this.y < 0) this.y = canvas.height;
                    }
                    
                    draw() {
                        ctx.beginPath();
                        ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
                        ctx.fillStyle = `rgba(${this.color}, ${this.opacity})`;
                        ctx.fill();
                    }
                }
                
                // Create particles
                function initParticles() {
                    particles = [];
                    const particleCount = Math.floor((canvas.width * canvas.height) / 15000);
                    for (let i = 0; i < particleCount; i++) {
                        particles.push(new Particle());
                    }
                }
                
                // Draw connections
                function drawConnections() {
                    for (let i = 0; i < particles.length; i++) {
                        for (let j = i + 1; j < particles.length; j++) {
                            const dx = particles[i].x - particles[j].x;
                            const dy = particles[i].y - particles[j].y;
                            const distance = Math.sqrt(dx * dx + dy * dy);
                    
                            if (distance < 120) {
                                ctx.beginPath();
                                // Use gradient between two particle colors
                                const gradient = ctx.createLinearGradient(
                                    particles[i].x, particles[i].y,
                                    particles[j].x, particles[j].y
                                );
                                gradient.addColorStop(0, `rgba(${particles[i].color}, ${0.3 * (1 - distance / 120)})`);
                                gradient.addColorStop(1, `rgba(${particles[j].color}, ${0.3 * (1 - distance / 120)})`);
                                ctx.strokeStyle = gradient;
                                ctx.lineWidth = 0.5;
                                ctx.moveTo(particles[i].x, particles[i].y);
                                ctx.lineTo(particles[j].x, particles[j].y);
                                ctx.stroke();
                            }
                        }
                    }
                }
                
                // Animation loop
                function animate() {
                    ctx.clearRect(0, 0, canvas.width, canvas.height);
                    
                    particles.forEach(particle => {
                        particle.update();
                        particle.draw();
                    });
                    
                    drawConnections();
                    
                    animationId = requestAnimationFrame(animate);
                }
                
                // Initialize and start
                initParticles();
                animate();
                
                // Cleanup on page unload
                window.addEventListener('beforeunload', () => {
                    if (animationId) {
                        cancelAnimationFrame(animationId);
                    }
                });
            })();
        </script>
    @endpush
</x-layouts.public>

