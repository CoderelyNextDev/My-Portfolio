<?php
session_start();
include './config/db_connect.php';

if (empty($_SESSION['user_logged_in'])) { 
    header('Location: index.php'); 
    exit; 
}

$message = '';
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $full_name = $_POST['full_name'];
    $tagline = $_POST['tagline'] ?? '';
    $email = $_POST['email'];
    $phone = $_POST['phone_number'] ?? '';
    $about = $_POST['about_summary'] ?? '';
    $profile = $_POST['existing_profile'] ?? '';

    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = './assets/images/profile/';
        
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        $file_extension = strtolower(pathinfo($_FILES['profile_picture']['name'], PATHINFO_EXTENSION));
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        
        if (in_array($file_extension, $allowed_extensions)) {
            $new_filename = 'profile_' . uniqid() . '.' . $file_extension;
            $upload_path = $upload_dir . $new_filename;
            
            if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $upload_path)) {
                if ($profile && file_exists($profile)) {
                    unlink($profile);
                }
                $profile = $upload_path;
            } else {
                $_SESSION['message'] = 'Failed to upload profile picture!';
            }
        } else {
            $_SESSION['message'] = "Invalid file type. Only JPG, PNG, GIF, and WEBP allowed!";
        }
    }

    if (!$message) {
        $stmt = $pdo->prepare("UPDATE personal_info SET full_name=?, tagline=?, email=?, phone_number=?, about_summary=?, profile_picture_url=? WHERE id=?");
        $stmt->execute([$full_name, $tagline, $email, $phone, $about, $profile, $id]);
        $_SESSION['message'] = "Profile updated successfully!";
    }

    header('Location: manage_personal_info.php');
    exit;
}

// Fetch the first (and only) profile record
$stmt = $pdo->query("SELECT * FROM personal_info LIMIT 1");
$profile_data = $stmt->fetch();

include './includes/head.php';
?>

<body class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 min-h-screen">
    <div class="pt-10 pb-8 px-6">
        <div class="max-w-4xl mx-auto">
          <div class="flex items-center justify-between mb-6 flex-col gap-3 md:flex-row">
                <div>
                    <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-2">Personal Information</h1>
                    <p class="text-gray-600 dark:text-gray-400">Update your profile details and contact information</p>
                </div>
                <a href="dashboard.php" class="px-6 py-3 bg-gradient-to-r from-gray-600 to-gray-700 text-white rounded-xl hover:from-gray-700 hover:to-gray-800 font-medium transition-all shadow-lg hover:shadow-xl">
                    ← Dashboard
                </a>
            </div>

            <?php if($message): ?>
                <div class="mb-6 p-4 <?= strpos($message, 'Failed') !== false || strpos($message, 'Invalid') !== false ? 'bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300 border border-red-200 dark:border-red-800' : 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300 border border-green-200 dark:border-green-800' ?> rounded-xl font-medium">
                    <?= $message ?>
                </div>
            <?php endif; ?>

            <?php if($profile_data): ?>
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 p-8">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Edit Your Profile</h2>
                
                <form method="POST" enctype="multipart/form-data" class="space-y-6">
                    <input type="hidden" name="id" value="<?= $profile_data['id'] ?>">
                    <input type="hidden" name="existing_profile" value="<?= htmlspecialchars($profile_data['profile_picture_url']) ?>">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Profile Picture
                            </label>
                            <div class="flex items-center space-x-6">
                                <div class="shrink-0">
                                    <div id="profile_preview" class="h-24 w-24 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center overflow-hidden border-4 border-gray-300 dark:border-gray-600">
                                        <?php if($profile_data['profile_picture_url']): ?>
                                            <img src="<?= htmlspecialchars($profile_data['profile_picture_url']) ?>" alt="Profile" class="h-full w-full object-cover">
                                        <?php else: ?>
                                            <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <label class="block">
                                    <span class="sr-only">Choose profile photo</span>
                                    <input type="file" name="profile_picture" id="profile_picture" accept="image/*"
                                           class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100 dark:file:bg-red-900/30 dark:file:text-red-300"
                                           onchange="previewImage(this)">
                                    <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Leave empty to keep current picture</p>
                                </label>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Full Name *
                            </label>
                            <input type="text" name="full_name" id="full_name" 
                                   value="<?= htmlspecialchars($profile_data['full_name']) ?>"
                                   class="w-full p-4 border border-gray-300 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-red-500 focus:border-transparent transition" 
                                   placeholder="John Doe"
                                   required>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Professional Tagline
                            </label>
                            <input type="text" name="tagline" id="tagline" 
                                   value="<?= htmlspecialchars($profile_data['tagline']) ?>"
                                   class="w-full p-4 border border-gray-300 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-red-500 focus:border-transparent transition" 
                                   placeholder="Full Stack Developer">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Email Address *
                            </label>
                            <input type="email" name="email" id="email" 
                                   value="<?= htmlspecialchars($profile_data['email']) ?>"
                                   class="w-full p-4 border border-gray-300 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-red-500 focus:border-transparent transition" 
                                   placeholder="john@example.com"
                                   required>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Phone Number
                            </label>
                            <input type="text" name="phone_number" id="phone_number" 
                                   value="<?= htmlspecialchars($profile_data['phone_number']) ?>"
                                   class="w-full p-4 border border-gray-300 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-red-500 focus:border-transparent transition" 
                                   placeholder="+1 (555) 123-4567" required>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                About / Bio
                            </label>
                            <textarea name="about_summary" id="about_summary" rows="5"
                                      class="w-full p-4 border border-gray-300 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-red-500 focus:border-transparent transition"
                                      placeholder="Tell us about yourself, your experience, and what you do..."><?= htmlspecialchars($profile_data['about_summary']) ?></textarea required>
                        </div>
                    </div>

                    <div class="flex gap-4 pt-4">
                        <button type="submit" class="flex-1 px-8 py-4 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-xl hover:from-red-700 hover:to-red-800 font-semibold transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                             Update Profile
                        </button>
                    </div>
                </form>
            </div>
            <?php else: ?>
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 p-12 text-center">
                <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">No Profile Found</h3>
                <p class="text-gray-600 dark:text-gray-400">Please contact administrator to create your profile.</p>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
    function previewImage(input) {
        const preview = document.getElementById('profile_preview');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.innerHTML = '<img src="' + e.target.result + '" class="h-full w-full object-cover">';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    </script>
</body>
</html>