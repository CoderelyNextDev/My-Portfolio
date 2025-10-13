<!-- NOTE:: I didn't use inline css -->
<section id="hero" class="relative mt-5 md:mt-0 min-h-screen flex flex-col items-center justify-center px-4">
  <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex flex-col lg:flex-row items-center gap-8 py-8">
      <div class="w-full md:w-1/3 flex justify-center">
        <div class="relative pt-10">
          <img
            src="  <?= $personalInfo['profile_picture_url'] ?>"
            alt="Mark Ely Calipjo"
            class="rounded-full w-70 h-70 object-cover border-4 border-white dark:border-gray-700 shadow-lg"
            onerror="this.onerror=null; this.src='/placeholder-profile.jpg';"
          />
        </div>
      </div>

      <!-- Profile Info -->
      <div class="w-full md:w-2/3 space-y-4">
        <div class="text-center md:text-left">
          <h1 class="text-4xl font-bold text-gray-900 dark:text-white opacity-0 animate-fade-in">
            <?= $personalInfo['full_name'] ?>
          </h1>
          <p class="text-xl text-gray-800 dark:text-gray-300 mt-2">
            <span class="opacity-0 animate-fade-in-delay-2">Web Developer & </span>
            <span class="text-gradient ml-2 opacity-0 animate-fade-in-delay-3">Designer</span>
          </p>
        </div>

        <!-- Social Links -->
        <div class="flex justify-center md:justify-start gap-4 mt-4 opacity-0 animate-fade-in-delay-2">
          <a href="https://github.com/CODERELY07" target="_blank" aria-label="GitHub" class="text-2xl text-gray-800 dark:text-gray-300 hover:text-blue-500 dark:hover:text-blue-400 transition-colors">
            <i class="fab fa-github"></i>
          </a>
          <a href="https://www.facebook.com/mark.ely.calipjo.2025/" target="_blank" aria-label="Facebook" class="text-2xl text-gray-800 dark:text-gray-300 hover:text-blue-500 dark:hover:text-blue-400 transition-colors">
            <i class="fab fa-facebook"></i>
          </a>
        </div>

        <!-- Personal Details -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
          <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow">
            <p class="text-sm text-gray-600 dark:text-gray-400 uppercase tracking-wider opacity-0 animate-fade-in-delay-2">Born in</p>
            <p class="font-medium text-gray-900 dark:text-gray-100 opacity-0 animate-fade-in-delay-2">Nabua, Camarines Sur</p>
          </div>
          <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow">
            <p class="text-sm text-gray-600 dark:text-gray-400 uppercase tracking-wider opacity-0 animate-fade-in-delay-3">Current Address</p>
            <p class="font-medium text-gray-900 dark:text-gray-100 opacity-0 animate-fade-in-delay-3">Nabua, Philippines</p>
          </div>
          <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow">
            <p class="text-sm text-gray-600 dark:text-gray-400 uppercase tracking-wider opacity-0 animate-fade-in-delay-3">Date Born</p>
            <p class="font-medium text-gray-900 dark:text-gray-100 opacity-0 animate-fade-in-delay-3">September 26, 2004</p>
          </div>
        </div>

        <div class="mx-auto rounded-xl mt-8">
          <blockquote class="text-left">
            <p class="text-xl italic text-gray-800 dark:text-gray-300 opacity-0 animate-fade-in">
              "I am a passionate <span class="font-semibold not-italic opacity-0 animate-fade-in-delay-3">Web Developer</span>
              and can also work in <span class="font-semibold not-italic opacity-0 animate-fade-in-delay-4">Web Design</span>."
            </p>
          </blockquote>

          <div class="flex flex-col sm:flex-row gap-4 mt-8 opacity-0 animate-fade-in">
            <a href="resume.pdf" download class="flex items-center justify-center gap-3 bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-lg shadow-md transition-all duration-200">
              <img
                src="https://storage.googleapis.com/a1aa/image/_T2_MN-qH262i1wfTYZLoFzfnWUB9NvNAgwmy9T9vjw.jpg"
                alt="Document Icon"
                class="w-5 h-5"
              />
              Download My Resume
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="hidden md:flex absolute bottom-8 left-1/2 transform -translate-x-1/2 flex-col items-center animate-bounce">
    <span class="text-sm text-gray-500 dark:text-gray-400 mb-2">Scroll</span>
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
    </svg>
  </div>
</section>
