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
            <a href="login.php" target="_blank" class="inline-flex items-center gap-1 text-gray-700 dark:text-gray-300 hover:text-blue-500 dark:hover:text-blue-400 transition-colors duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
                    <polyline points="10 17 15 12 10 7"></polyline>
                    <line x1="15" y1="12" x2="3" y2="12"></line>
                </svg>
                Login
            </a>
        </div>

        <?php include 'themeToggle.php'?>
    </div>

    <div id="mobile-overlay" class="fixed inset-0 md:hidden z-50 h-[100dvh] pt-[env(safe-area-inset-top)] pb-[env(safe-area-inset-bottom)] transition-opacity duration-300 opacity-0 pointer-events-none">
        <div class="absolute inset-0 bg-white/95 dark:bg-gray-900/95 backdrop-blur-lg"></div>

        <div class="relative z-10 h-full flex flex-col items-center justify-center gap-8 text-xl">
            <a href="#hero" class="text-gray-800 dark:text-gray-200 hover:text-blue-500 dark:hover:text-blue-400 transition-colors duration-300">Home</a>
            <a href="#about" class="text-gray-800 dark:text-gray-200 hover:text-blue-500 dark:hover:text-blue-400 transition-colors duration-300">About</a>
            <a href="#skills" class="text-gray-800 dark:text-gray-200 hover:text-blue-500 dark:hover:text-blue-400 transition-colors duration-300">Skills</a>
            <a href="#projects" class="text-gray-800 dark:text-gray-200 hover:text-blue-500 dark:hover:text-blue-400 transition-colors duration-300">Projects</a>
            <a href="#contact" class="text-gray-800 dark:text-gray-200 hover:text-blue-500 dark:hover:text-blue-400 transition-colors duration-300">Contact</a>
            <a href="login.php" target="_blank" class="inline-flex items-center gap-1 text-gray-700 dark:text-gray-300 hover:text-blue-500 dark:hover:text-blue-400 transition-colors duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
                    <polyline points="10 17 15 12 10 7"></polyline>
                    <line x1="15" y1="12" x2="3" y2="12"></line>
                </svg>
                Login
            </a>
        </div>
    </div>
</nav>


