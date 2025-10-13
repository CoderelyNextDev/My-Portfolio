<?php

    function skillLevelToLabel($level) {
        if ($level >= 90) return "Expert";
        if ($level >= 70) return "Advanced";
        if ($level >= 50) return "Intermediate";
        return "Beginner";
    }
?>
<section id="skills" class="py-28 min-h-screen px-4 relative bg-gradient-to-b from-gray-100 to-white dark:from-gray-900 dark:to-gray-800">
    <div class="container mx-auto max-w-7xl">
        <div class="text-center mb-16">
            <div class="text-center mb-16" data-aos="fade-up">
                <span class="inline-block text-blue-600 dark:text-blue-400 font-medium mb-2 tracking-wider">Skills</span>
                <h2 class="text-4xl md:text-5xl text-gray-900 dark:text-white font-bold mb-4">
                    Technical <span class="text-blue-600 dark:text-blue-400 relative">
                        Proficiency 
                        <svg class="absolute -bottom-2 left-0 w-full" viewBox="0 0 100 10" preserveAspectRatio="none">
                            <path d="M0,5 Q25,0 50,5 T100,5" stroke="currentColor" stroke-width="2" fill="none" class="text-blue-200 dark:text-blue-800"/>
                        </svg>
                    </span>
                </h2>
                <p class="text-gray-600 dark:text-gray-400 max-w-lg mx-auto">My Skills I develop within 3 years</p>
            </div>

            <div class="flex flex-wrap justify-center gap-3 mb-12 fade-in-up animate-delay-200">
                <?php foreach ($categories as $category): ?>
                    <button 
                        data-category="<?= $category['id'] ?>" 
                        class="category-btn px-6 py-2.5 rounded-full transition-all duration-300 font-medium text-sm md:text-base 
                               border border-transparent hover:border-blue-400/30
                               shadow-sm hover:shadow-blue-400/10
                               <?= $category['id'] === 'all' 
                                   ? 'category-active' 
                                   : 'bg-gray-200 text-gray-800 hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600' ?>"
                    >
                        <?= $category['label'] ?>
                    </button>
                <?php endforeach; ?>
            </div>
        </div>

        <div id="skills-container" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($skills as $index => $skill): ?>
                <div class="skill-card visible bg-white dark:bg-gray-800 p-6 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition-all duration-300 hover:border-blue-400/30"
                     data-category="<?= $skill['category'] ?>">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="font-semibold text-lg text-gray-900 dark:text-white">
                                <?= $skill['skill_name'] ?>
                            </h3>
                        </div>
                        <span class="text-blue-600 dark:text-blue-400 font-medium">
                            <?= $skill['proficiency'] ?>%
                        </span>
                    </div>

                    <div class="w-full bg-gray-200 dark:bg-gray-700 h-2.5 rounded-full overflow-hidden mb-1">
                        <div 
                            class="progress-bar bg-gradient-to-r from-blue-500 to-blue-400 dark:from-blue-600 dark:to-blue-500 h-2.5 rounded-full"
                            style="width: <?= $skill['proficiency'] ?>%"
                        ></div>
                    </div>

                    <div class="flex justify-between items-center">
                        <span class="text-xs text-gray-500 dark:text-gray-400">
                            Proficiency level
                        </span>
                        <span class="text-xs text-gray-500 dark:text-gray-400">
                            <?= skillLevelToLabel($skill['proficiency']) ?>
                        </span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

