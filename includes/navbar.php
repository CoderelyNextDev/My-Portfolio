<!-- Navbar -->
<nav id="navbar" class="fixed top-0 left-0 w-full z-40 py-5 bg-transparent dark:bg-transparent transition-all duration-300">
    <div class="container mx-auto flex items-center justify-between px-4">
        <a href="#hero" class="text-xl font-bold text-blue-500 dark:text-blue-400 flex items-center">
            <span class="relative z-10">
                <span class="text-glow text-gray-900 dark:text-white">Mark Ely</span> Portfolio
            </span>
        </a>

        <div class="hidden md:flex space-x-8">
            <a href="#hero" class="text-gray-700 dark:text-gray-300 hover:text-blue-500 dark:hover:text-blue-400 transition-colors duration-300">Home</a>
            <a href="#about" class="text-gray-700 dark:text-gray-300 hover:text-blue-500 dark:hover:text-blue-400 transition-colors duration-300">About</a>
            <a href="#skills" class="text-gray-700 dark:text-gray-300 hover:text-blue-500 dark:hover:text-blue-400 transition-colors duration-300">Skills</a>
            <a href="#projects" class="text-gray-700 dark:text-gray-300 hover:text-blue-500 dark:hover:text-blue-400 transition-colors duration-300">Projects</a>
            <a href="#contact" class="text-gray-700 dark:text-gray-300 hover:text-blue-500 dark:hover:text-blue-400 transition-colors duration-300">Contact</a>
        </div>

        <div class="flex items-center space-x-4">
            <!-- Theme Toggle -->
            <button id="theme-toggle" class="w-10 h-10 flex items-center justify-center rounded-full focus:outline-none transition-colors duration-300">
                <svg id="sun-icon" class="h-6 w-6 text-yellow-300 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <svg id="moon-icon" class="h-6 w-6 text-blue-900" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                </svg>
            </button>

            <button id="mobile-toggle" class="md:hidden p-2 text-gray-800 dark:text-gray-200 z-[60]">
                <svg id="menu-icon" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                <svg id="close-icon" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 hidden" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>

    <div id="mobile-overlay" class="fixed inset-0 md:hidden z-50 h-[100dvh] pt-[env(safe-area-inset-top)] pb-[env(safe-area-inset-bottom)] transition-opacity duration-300 opacity-0 pointer-events-none">
        <div class="absolute inset-0 bg-white/95 dark:bg-gray-900/95 backdrop-blur-lg"></div>

        <div class="relative z-10 h-full flex flex-col items-center justify-center gap-8 text-xl">
            <a href="#hero" class="text-gray-800 dark:text-gray-200 hover:text-blue-500 dark:hover:text-blue-400 transition-colors duration-300">Home</a>
            <a href="#about" class="text-gray-800 dark:text-gray-200 hover:text-blue-500 dark:hover:text-blue-400 transition-colors duration-300">About</a>
            <a href="#skills" class="text-gray-800 dark:text-gray-200 hover:text-blue-500 dark:hover:text-blue-400 transition-colors duration-300">Skills</a>
            <a href="#projects" class="text-gray-800 dark:text-gray-200 hover:text-blue-500 dark:hover:text-blue-400 transition-colors duration-300">Projects</a>
            <a href="#contact" class="text-gray-800 dark:text-gray-200 hover:text-blue-500 dark:hover:text-blue-400 transition-colors duration-300">Contact</a>
        </div>
    </div>
</nav>


