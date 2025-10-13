<footer class="bg-gray-100 dark:bg-gray-900 py-8">
  <div class="container mx-auto max-w-7xl px-4 text-center text-gray-600 dark:text-gray-400">
    <p class="mb-2">
      Email: <a href="mailto:<?php echo htmlspecialchars($personalInfo['email']); ?>" class="underline hover:text-blue-600"><?php echo htmlspecialchars($personalInfo['email']); ?></a>
      &nbsp;|&nbsp;
      Phone: <a href="tel:<?php echo htmlspecialchars($personalInfo['phone_number']); ?>" class="underline hover:text-blue-600"><?php echo htmlspecialchars($personalInfo['phone_number']); ?></a>
    </p>
    <p class="text-gray-500 text-center dark:text-gray-400 text-lg">
      &copy; <?php echo date('Y'); ?> Mark Ely Calipjo. All rights reserved.
    </p>
  </div>
</footer>

<script src="./assets/js/main.js?<?php echo time(); ?>"></script>
</body>
</html>
