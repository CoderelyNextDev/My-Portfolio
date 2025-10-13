<section id="experience" class="py-24 min-h-screen px-4 relative bg-white dark:bg-gray-900">
  <div class="container mx-auto max-w-7xl">
    <div class="text-center mb-16" data-aos="fade-up">
      <span class="inline-block text-blue-600 dark:text-blue-400 font-medium mb-2 tracking-wider">Experience & Education</span>
      <h2 class="text-4xl md:text-5xl text-gray-900 dark:text-white font-bold mb-4">
        My <span class="text-blue-600 dark:text-blue-400 relative">
          Journey
          <svg class="absolute -bottom-2 left-0 w-full" viewBox="0 0 100 10" preserveAspectRatio="none">
            <path d="M0,5 Q25,0 50,5 T100,5" stroke="currentColor" stroke-width="2" fill="none" class="text-blue-200 dark:text-blue-800"/>
          </svg>
        </span>
      </h2>
      <p class="text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
        My professional experience and educational background.
      </p>
    </div>

    <div class="relative border-l-2 border-blue-600 dark:border-blue-400 ml-6 space-y-12">
      <?php foreach ($experience as $entry): ?>
        <div class="relative pl-8">
          <span class="absolute -left-4 top-2 w-6 h-6 rounded-full bg-blue-600 dark:bg-blue-400 border-4 border-white dark:border-gray-900"></span>
          <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
            <?php echo htmlspecialchars($entry['title']); ?>
          </h3>
          <p class="text-blue-600 dark:text-blue-400 font-medium mb-1">
            <?php echo htmlspecialchars($entry['institution']); ?>
          </p>
          <p class="text-sm text-gray-500 dark:text-gray-400 mb-4 italic">
            <?php echo htmlspecialchars($entry['start_date']) . ' - ' . ($entry['end_date'] ?? 'Present'); ?>
          </p>
          <p class="text-gray-700 dark:text-gray-300 leading-relaxed whitespace-pre-line">
            <?php echo htmlspecialchars($entry['description']); ?>
          </p>
        </div>
      <?php endforeach; ?>
        <div class="relative pl-8">
           <p class="text-gray-700 dark:text-gray-300 leading-relaxed whitespace-pre-line">
            Journey is On Going...
          </p>
        </div>
    </div>
  </div>
</section>
