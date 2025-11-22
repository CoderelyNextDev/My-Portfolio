<?php
session_start();
include './config/db_connect.php';

if (empty($_SESSION['user_logged_in'])) {
    header('Location: index.php');
    exit;
}
include './includes/head.php';
include './includes/menu-data.php';
?>


<body class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 min-h-screen">
    <div class="pt-10 pb-8 px-6">
        <div class="max-w-7xl mx-auto">
            <div class="flex items-center justify-between mb-2">
                <h1 class="text-4xl font-bold text-gray-900 dark:text-white">
                    Admin Dashboard
                </h1>
                <div class="flex items-center space-x-3">
                    <span class="px-4 py-2 bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300 rounded-full text-sm font-medium">
                        Online
                    </span>
                    <a href="logout.php" class="px-4 py-2 bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300 rounded-full text-sm font-medium hover:bg-red-200 dark:hover:bg-red-900/50 transition-colors">
                        Logout
                    </a>
                </div>
            </div>
            <p class="text-gray-600 dark:text-gray-400 text-lg">
                Welcome back! Manage your portfolio content from here.
            </p>
        </div>
    </div>
    <div class="px-6 pb-12">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                <?php foreach ($menuItems as $item): ?>
                    <a href="<?= $item['url'] ?>" class="group relative bg-white dark:bg-gray-800 rounded-xl shadow-md hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-200 dark:border-gray-700 hover:border-<?= $item['color'] ?>-500 dark:hover:border-<?= $item['color'] ?>-400 hover:-translate-y-1">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-<?= $item['color'] ?>-500/10 rounded-full -mr-16 -mt-16 group-hover:scale-150 transition-transform duration-500"></div>
                        <div class="relative p-6">
                            <div class="w-12 h-12 bg-<?= $item['color'] ?>-100 dark:bg-<?= $item['color'] ?>-900/30 rounded-lg flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6 text-<?= $item['color'] ?>-600 dark:text-<?= $item['color'] ?>-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?= $item['icon'] ?>"/>
                                </svg>
                            </div>
                            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-2"><?= $item['title'] ?></h2>
                            <p class="text-gray-600 dark:text-gray-400 text-sm"><?= $item['description'] ?></p>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</body>
</html>