// navbar
const navbar = document.getElementById('navbar');
const mobileToggle = document.getElementById('mobile-toggle');
const mobileOverlay = document.getElementById('mobile-overlay');
const menuIcon = document.getElementById('menu-icon');
const closeIcon = document.getElementById('close-icon');
const mobileLinks = mobileOverlay.querySelectorAll('a');
const themeToggle = document.getElementById('theme-toggle');
const sunIcon = document.getElementById('sun-icon');
const moonIcon = document.getElementById('moon-icon');

let isScrolled = false;
let isMenuOpen = false;
let isDarkMode = false;

function initTheme() {
    const storedTheme = localStorage.getItem("theme");
    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

    if (storedTheme === "dark" || (!storedTheme && prefersDark)) {
        document.documentElement.classList.add("dark");
        isDarkMode = true;
        sunIcon.classList.remove("hidden");
        moonIcon.classList.add("hidden");
    } else {
        document.documentElement.classList.remove("dark");
        isDarkMode = false;
        sunIcon.classList.add("hidden");
        moonIcon.classList.remove("hidden");
    }
}

function toggleTheme() {
    isDarkMode = !isDarkMode;
    document.documentElement.classList.toggle("dark", isDarkMode);
    localStorage.setItem("theme", isDarkMode ? "dark" : "light");

    sunIcon.classList.toggle("hidden", !isDarkMode);
    moonIcon.classList.toggle("hidden", isDarkMode);
}

function handleScroll() {
    isScrolled = window.scrollY > 10;
    updateNavbarStyles();
}

function updateNavbarStyles() {
    if (isMenuOpen) {
        navbar.className = 'fixed top-0 left-0 w-full z-40 py-5 bg-white/95 dark:bg-gray-900/95 backdrop-blur-lg shadow-md transition-all duration-300';
    } else if (isScrolled) {
        navbar.className = 'fixed top-0 left-0 w-full z-40 py-3 bg-white/80 dark:bg-gray-900/80 backdrop-blur-lg shadow-md transition-all duration-300';
    } else {
        navbar.className = 'fixed top-0 left-0 w-full z-40 py-5 bg-transparent dark:bg-transparent transition-all duration-300';
    }
}

function toggleMobileMenu() {
    isMenuOpen = !isMenuOpen;
    mobileOverlay.classList.toggle('opacity-100', isMenuOpen);
    mobileOverlay.classList.toggle('opacity-0', !isMenuOpen);
    mobileOverlay.classList.toggle('pointer-events-auto', isMenuOpen);
    mobileOverlay.classList.toggle('pointer-events-none', !isMenuOpen);
    menuIcon.classList.toggle('hidden', isMenuOpen);
    closeIcon.classList.toggle('hidden', !isMenuOpen);
    updateNavbarStyles();
}

function handleResize() {
    if (window.innerWidth >= 768 && isMenuOpen) toggleMobileMenu();
}

function handleOverlayClick(e) {
    if (e.target === mobileOverlay || e.target === mobileOverlay.querySelector('div')) toggleMobileMenu();
}

function init() {
    initTheme();
    handleScroll();
    window.addEventListener('scroll', handleScroll);
    window.addEventListener('resize', handleResize);
    mobileToggle.addEventListener('click', toggleMobileMenu);
    mobileOverlay.addEventListener('click', handleOverlayClick);
    themeToggle.addEventListener('click', toggleTheme);
    mobileLinks.forEach(link => link.addEventListener('click', toggleMobileMenu));
}

document.addEventListener('DOMContentLoaded', init);
// Modal
function openModal(index) {
    const certificate = certificatesData[index];
    document.getElementById('modalImage').src = certificate.image;
    document.getElementById('modalTitle').textContent = certificate.title;
    document.getElementById('modalDescription').textContent = certificate.description;
    document.getElementById('certificateModal').classList.remove('hidden');
    document.getElementById('certificateModal').classList.add('flex');
    document.body.style.overflow = 'hidden';
}

function closeModal() {
    document.getElementById('certificateModal').classList.add('hidden');
    document.getElementById('certificateModal').classList.remove('flex');
    document.body.style.overflow = 'auto';
}


document.getElementById('certificateModal').addEventListener('click', function(e) {
    if (e.target === this) closeModal();
});


document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeModal();
});

// skills
document.addEventListener('DOMContentLoaded', function() {
    // Initialize progress bar animations
    const progressBars = document.querySelectorAll('.progress-bar');
    
    progressBars.forEach(bar => {
        const level = bar.style.width;
        bar.style.width = '0%';
        
        setTimeout(() => {
            bar.style.width = level;
        }, 300);
    });
    
    // Category filtering functionality
    const categoryButtons = document.querySelectorAll('.category-btn');
    const skillCards = document.querySelectorAll('.skill-card');
    
    categoryButtons.forEach(button => {
        button.addEventListener('click', function() {
            const selectedCategory = this.getAttribute('data-category');
            
            // Update active button styling
            categoryButtons.forEach(btn => {
                if (btn === this) {
                    btn.classList.add('category-active');
                    btn.classList.remove('bg-gray-200', 'text-gray-800', 'hover:bg-gray-300', 'dark:bg-gray-700', 'dark:text-gray-200', 'dark:hover:bg-gray-600');
                } else {
                    btn.classList.remove('category-active');
                    btn.classList.add('bg-gray-200', 'text-gray-800', 'hover:bg-gray-300', 'dark:bg-gray-700', 'dark:text-gray-200', 'dark:hover:bg-gray-600');
                }
            });
            
            // Filter skills
            skillCards.forEach(card => {
                const cardCategory = card.getAttribute('data-category');
                if (selectedCategory === 'all' || cardCategory === selectedCategory) {
                    card.classList.remove('hidden');
                    setTimeout(() => card.classList.add('visible'), 10);
                } else {
                    card.classList.remove('visible');
                    setTimeout(() => card.classList.add('hidden'), 10);
                }
            });
        });
    });
});