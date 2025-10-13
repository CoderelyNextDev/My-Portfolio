<script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>

<section id='projects' class='py-24 min-h-screen px-4 relative bg-white dark:bg-gray-900'>
    <div class='container mx-auto max-w-7xl'>
        <div class="text-center mb-16" data-aos="fade-up">
            <span class="inline-block text-blue-600 dark:text-blue-400 font-medium mb-2 tracking-wider">Projects</span>
            <h2 class="text-4xl md:text-5xl text-gray-900 dark:text-white font-bold mb-4">
                My <span class="text-blue-600 dark:text-blue-400 relative">
                    Projects 
                    <svg class="absolute -bottom-2 left-0 w-full" viewBox="0 0 100 10" preserveAspectRatio="none">
                        <path d="M0,5 Q25,0 50,5 T100,5" stroke="currentColor" stroke-width="2" fill="none" class="text-blue-200 dark:text-blue-800"/>
                    </svg>
                </span>
            </h2>
            <p class="text-gray-600 dark:text-gray-400 max-w-lg mx-auto">
                Here are some of my projects, created to showcase my full-stack development skills...
            </p>
        </div>

        <div class='grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8'>
            <?php foreach ($projects as $project): ?>
                <div class='group bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-300 flex flex-col h-full border border-gray-200 dark:border-gray-700'>
                    <a href="<?= $project['demo_url'] ? $project['demo_url'] : '/project/' . $project['id'] ?>" class='block'>
                        <div class='h-48 overflow-hidden relative'>
                            <img
                                src="<?= $project['image'] ?>"
                                alt="<?= htmlspecialchars($project['title']) ?>"
                                class='w-full h-full object-cover transition-transform duration-500 group-hover:scale-110'
                                onerror="this.src='https://picsum.photos/400/200?random=<?= $project['id'] ?>'"
                            />
                            <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <span class="text-white text-lg font-semibold">VISIT</span>
                            </div>
                        </div>
                    </a>

                    <div class='p-6 flex-1 flex flex-col'>
                        <a href="<?= $project['demo_url'] ? $project['demo_url'] : '/project/' . $project['id'] ?>" class='block flex-1'>
                            <h3 class='text-xl font-semibold mb-2 text-gray-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400 transition-colors'>
                                <?= htmlspecialchars($project['title']) ?>
                            </h3>
                            <p class='text-gray-600 dark:text-gray-400 mb-4 line-clamp-3'>
                                <?= htmlspecialchars($project['description']) ?>
                            </p>
                        </a>
                        
                        <div class='flex flex-wrap gap-2 mb-4'>
                            <?php foreach ($project['tags'] as $tag): ?>
                                <span class="px-3 py-1 text-xs font-medium rounded-full border bg-gray-100 text-gray-700 border-gray-200 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600">
                                    <?= htmlspecialchars($tag) ?>
                                </span>
                            <?php endforeach; ?>
                        </div>
                        
                        <div class='flex gap-3 mt-auto'>
                            <?php if (!empty($project['github_url'])): ?>
                                <a href="<?= $project['github_url'] ?>" class='text-gray-900 dark:text-gray-200 hover:text-blue-600 dark:hover:text-blue-400 transition-colors flex items-center gap-1' target='_blank' rel="noopener noreferrer">
                                    <i data-lucide="github" width="18" height="18"></i>
                                    <span class="text-sm">Code</span>
                                </a>
                            <?php endif; ?>
                            
                            <?php if (!empty($project['demo_url'])): ?>
                                <a href="<?= $project['demo_url'] ?>" class='text-gray-900 dark:text-gray-200 hover:text-blue-600 dark:hover:text-blue-400 transition-colors flex items-center gap-1 ml-auto' target='_blank' rel="noopener noreferrer">
                                    <span class="text-sm">Live Demo</span>
                                    <i data-lucide="external-link" width="16" height="16"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="text-center mt-12">
            <a class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-500 to-indigo-500 text-white font-semibold rounded-full shadow-lg transition-transform duration-300 hover:scale-105 hover:from-blue-400 hover:to-indigo-400"
               href="https://github.com/CODERELY07"
               target="_blank"
               rel="noopener noreferrer">
                Check My GitHub <i data-lucide="arrow-right" width="16" height="16"></i>
            </a>
        </div>
    </div>
</section>

<script>
    lucide.createIcons();
</script>
