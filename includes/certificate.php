<section id="certificates" class="py-24 min-h-screen px-4 relative bg-white dark:bg-gray-900">
  <div class="container mx-auto max-w-7xl">
    <div class="text-center mb-16" data-aos="fade-up">
      <span class="inline-block text-blue-600 dark:text-blue-400 font-medium mb-2 tracking-wider">Certificates</span>
      <h2 class="text-4xl md:text-5xl text-gray-900 dark:text-white font-bold mb-4">
        My <span class="text-blue-600 dark:text-blue-400 relative">
          Certificates
          <svg class="absolute -bottom-2 left-0 w-full" viewBox="0 0 100 10" preserveAspectRatio="none">
            <path d="M0,5 Q25,0 50,5 T100,5" stroke="currentColor" stroke-width="2" fill="none" class="text-blue-200 dark:text-blue-800"/>
          </svg>
        </span>
      </h2>
      <p class="text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
        Here are some of my certificates, showcasing my dedication and achievements in technology and development.
      </p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
      <?php foreach ($certificates as $index => $certificate): ?>
        <div
          class="cursor-pointer group bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow-sm card-hover border border-gray-200 dark:border-gray-700 transition-all duration-300"
          onclick="openModal(<?php echo $index; ?>)"
        >
          <div class="h-48 overflow-hidden">
            <img
              src="<?php echo $certificate['image']; ?>"
              alt="<?php echo $certificate['title']; ?>"
              class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
            />
          </div>
          <div class="p-6">
            <h3 class="text-xl font-semibold mb-2 text-gray-900 dark:text-white">
              <?php echo $certificate['title']; ?>
            </h3>
            <p class="text-gray-600 dark:text-gray-400 mb-4">
              <?php echo $certificate['description']; ?>
            </p>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- Modal -->
  <div id="certificateModal" class="fixed inset-0 bg-black bg-opacity-80 hidden items-center justify-center z-50 modal-fade-in">
    <div class="relative max-w-4xl max-h-[90vh] flex flex-col items-center">
      <!-- Close Button -->
      <button
        onclick="closeModal()"
        class="absolute -top-12 right-0 bg-white dark:bg-gray-800 px-3 py-1 rounded-full shadow-lg text-gray-800 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors"
      >
        ✕ Close
      </button>

      <img
        id="modalImage"
        src=""
        alt="Certificate"
        class="max-h-[80vh] rounded-lg shadow-2xl modal-content-scale"
      />
      <div class="mt-4 text-white text-center">
        <h3 id="modalTitle" class="text-xl font-bold"></h3>
        <p id="modalDescription" class="text-gray-300 mt-2"></p>
      </div>
    </div>
  </div>
</section>

<script>
    const certificatesData = <?php echo json_encode($certificates); ?>;
</script>