<!-- about.php -->
<section id="about" class="py-20 md:py-30 px-4 relative bg-gradient-to-br from-white to-blue-50/30 dark:from-gray-900 dark:to-gray-800">
  <!-- Background decorative elements -->
  <div class="absolute top-10 left-10 w-20 h-20 bg-blue-100/40 dark:bg-blue-900/30 rounded-full blur-xl"></div>
  <div class="absolute bottom-10 right-10 w-32 h-32 bg-purple-100/30 dark:bg-purple-900/30 rounded-full blur-xl"></div>
  
  <div class="container mx-auto max-w-6xl relative z-10">
    
    <!-- Section Header with Animation -->
    <div class="text-center mb-16" data-aos="fade-up">
      <span class="inline-block text-blue-600 dark:text-blue-400 font-medium mb-2 tracking-wider">ABOUT</span>
      <h2 class="text-4xl md:text-5xl text-gray-900 dark:text-white font-bold mb-4">
        About <span class="text-blue-600 dark:text-blue-400 relative">
          Me
          <svg class="absolute -bottom-2 left-0 w-full" viewBox="0 0 100 10" preserveAspectRatio="none">
            <path d="M0,5 Q25,0 50,5 T100,5" stroke="currentColor" stroke-width="2" fill="none" class="text-blue-200 dark:text-blue-800"/>
          </svg>
        </span>
      </h2>
      <p class="text-gray-600 dark:text-gray-400 max-w-lg mx-auto">Get to know more about my skills and expertise</p>
    </div>

    <!-- About Content -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
      
      <!-- Left: Description -->
      <div class="space-y-6" data-aos="fade-right">
        <h3 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white leading-tight">
          Passionate <span class="text-blue-600 dark:text-blue-400">Web Developer</span> 
        </h3>

        <div class="space-y-4 text-gray-700 dark:text-gray-300 leading-relaxed">
          <p class="flex items-start">
            <span class="inline-block w-2 h-2 bg-blue-600 rounded-full mt-2 mr-3 flex-shrink-0"></span>
            I'm a Web Developer passionate about building and managing websites. Skilled in both frontend and backend development, I specialize in creating seamless, dynamic digital experiences.
          </p>
          <p class="flex items-start">
            <span class="inline-block w-2 h-2 bg-blue-600 rounded-full mt-2 mr-3 flex-shrink-0"></span>
            Beyond coding, I thrive on problem-solving and innovation, constantly seeking ways to optimize and improve. I enjoy collaborating with like-minded professionals, sharing knowledge, and staying current with emerging technologies.
          </p>
          <p class="flex items-start">
            <span class="inline-block w-2 h-2 bg-blue-600 rounded-full mt-2 mr-3 flex-shrink-0"></span>
            With a growth mindset and passion for technology, I'm eager to take on new challenges that push my boundaries. I'm currently open to exciting opportunities where I can contribute meaningfully while continuing to learn and grow.
          </p>
        </div>

        <div class="pt-4 flex flex-wrap gap-4">
          <a 
            href="#contact" 
            class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-lg transition-all duration-300 shadow-md hover:shadow-lg hover:-translate-y-1"
          >
            <i data-lucide="message-circle" class="w-5 h-5"></i>
            Get In Touch
          </a>
          <a 
            href="#projects" 
            class="inline-flex items-center gap-2 border border-blue-600 dark:border-blue-400 text-blue-600 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 font-medium py-3 px-6 rounded-lg transition-all duration-300"
          >
            <i data-lucide="folder-open" class="w-5 h-5"></i>
            View Projects
          </a>
        </div>
      </div>

      <!-- Right: Skills Cards -->
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-6" data-aos="fade-left" data-aos-delay="200">
        
        <!-- Development -->
        <div class="group p-6 bg-white dark:bg-gray-800 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 border border-transparent hover:border-blue-200 dark:hover:border-blue-500/40 hover:-translate-y-2">
          <div class="flex items-start gap-4 mb-4">
            <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900 group-hover:bg-blue-200 dark:group-hover:bg-blue-800 transition-colors duration-300">
              <i data-lucide="code" class="w-6 h-6 text-blue-600 dark:text-blue-400"></i>
            </div>
            <div>
              <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Development</h4>
              <div class="flex mt-1">
                <div class="w-8 h-1 bg-blue-600 rounded-full mr-1"></div>
                <div class="w-8 h-1 bg-blue-600 rounded-full mr-1"></div>
                <div class="w-8 h-1 bg-blue-600 rounded-full mr-1"></div>
                <div class="w-8 h-1 bg-blue-300 dark:bg-blue-700 rounded-full"></div>
              </div>
            </div>
          </div>
          <p class="text-gray-700 dark:text-gray-300">
            Can do frontend and backend with expertise in modern frameworks and technologies.
          </p>
        </div>

        <!-- Design -->
        <div class="group p-6 bg-white dark:bg-gray-800 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 border border-transparent hover:border-purple-200 dark:hover:border-purple-500/40 hover:-translate-y-2">
          <div class="flex items-start gap-4 mb-4">
            <div class="p-3 rounded-full bg-purple-100 dark:bg-purple-900 group-hover:bg-purple-200 dark:group-hover:bg-purple-800 transition-colors duration-300">
              <i data-lucide="palette" class="w-6 h-6 text-purple-600 dark:text-purple-400"></i>
            </div>
            <div>
              <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Design</h4>
              <div class="flex mt-1">
                <div class="w-8 h-1 bg-purple-600 rounded-full mr-1"></div>
                <div class="w-8 h-1 bg-purple-600 rounded-full mr-1"></div>
                <div class="w-8 h-1 bg-purple-300 dark:bg-purple-700 rounded-full mr-1"></div>
                <div class="w-8 h-1 bg-purple-300 dark:bg-purple-700 rounded-full"></div>
              </div>
            </div>
          </div>
          <p class="text-gray-700 dark:text-gray-300">
            Creating intuitive, user-centered interfaces with attention to detail and modern aesthetics.
          </p>
        </div>

        <!-- Optimization -->
        <div class="group p-6 bg-white dark:bg-gray-800 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 border border-transparent hover:border-green-200 dark:hover:border-green-500/40 hover:-translate-y-2">
          <div class="flex items-start gap-4 mb-4">
            <div class="p-3 rounded-full bg-green-100 dark:bg-green-900 group-hover:bg-green-200 dark:group-hover:bg-green-800 transition-colors duration-300">
              <i data-lucide="cpu" class="w-6 h-6 text-green-600 dark:text-green-400"></i>
            </div>
            <div>
              <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Optimization</h4>
              <div class="flex mt-1">
                <div class="w-8 h-1 bg-green-600 rounded-full mr-1"></div>
                <div class="w-8 h-1 bg-green-600 rounded-full mr-1"></div>
                <div class="w-8 h-1 bg-green-600 rounded-full mr-1"></div>
                <div class="w-8 h-1 bg-green-300 dark:bg-green-700 rounded-full"></div>
              </div>
            </div>
          </div>
          <p class="text-gray-700 dark:text-gray-300">
            Performance tuning and efficiency improvements for better user experiences and SEO.
          </p>
        </div>

        <!-- Problem Solving -->
        <div class="group p-6 bg-white dark:bg-gray-800 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 border border-transparent hover:border-red-200 dark:hover:border-red-500/40 hover:-translate-y-2">
          <div class="flex items-start gap-4 mb-4">
            <div class="p-3 rounded-full bg-red-100 dark:bg-red-900 group-hover:bg-red-200 dark:group-hover:bg-red-800 transition-colors duration-300">
              <i data-lucide="puzzle" class="w-6 h-6 text-red-600 dark:text-red-400"></i>
            </div>
            <div>
              <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Problem Solving</h4>
              <div class="flex mt-1">
                <div class="w-8 h-1 bg-red-600 rounded-full mr-1"></div>
                <div class="w-8 h-1 bg-red-600 rounded-full mr-1"></div>
                <div class="w-8 h-1 bg-red-600 rounded-full mr-1"></div>
                <div class="w-8 h-1 bg-red-600 rounded-full"></div>
              </div>
            </div>
          </div>
          <p class="text-gray-700 dark:text-gray-300">
            Analytical approach to breaking down and solving complex technical challenges effectively.
          </p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Include AOS library for animations (add to your head section) -->
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
  // Initialize AOS
  document.addEventListener('DOMContentLoaded', function() {
    AOS.init({
      duration: 800,
      easing: 'ease-in-out',
      once: true
    });
  });
</script>
