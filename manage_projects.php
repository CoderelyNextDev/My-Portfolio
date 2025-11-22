<?php
session_start();
include './config/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    header('Content-Type: application/json');
    
    $delete_id = $_POST['delete_id'];
    
    try {
        $stmt = $pdo->prepare("SELECT image FROM projects WHERE id=?");
        $stmt->execute([$delete_id]);
        $project = $stmt->fetch();
        
        $stmt = $pdo->prepare("DELETE FROM projects WHERE id=?");
        $stmt->execute([$delete_id]);
        
        if ($project && $project['image'] && file_exists($project['image'])) {
            unlink($project['image']);
        }
        
        echo json_encode(['success' => true, 'message' => 'Project deleted successfully!']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }
    exit;
}

if (empty($_SESSION['user_logged_in'])) { 
    header('Location: index.php'); 
    exit; 
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['action'])) {
    $id = $_POST['id'] ?? '';
    $title = $_POST['title'];
    $description = $_POST['description'];
    $demo_url = $_POST['demo_url'] ?? '';
    $github_url = $_POST['github_url'] ?? '';
    $image = $_POST['existing_image'] ?? '';

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = './assets/images/projects/';
        
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        $file_extension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        
        if (in_array($file_extension, $allowed_extensions)) {
            $new_filename = uniqid() . '_' . time() . '.' . $file_extension;
            $upload_path = $upload_dir . $new_filename;
            
            if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) {
                if ($id && $image && file_exists($image)) {
                    unlink($image);
                }
                $image = $upload_path;
            } else {
                $message = "Failed to upload image!";
            }
        } else {
            $message = "Invalid file type. Only JPG, JPEG, PNG, GIF, and WEBP allowed!";
        }
    }

    if (!$message) {
        if ($id) {
            $stmt = $pdo->prepare("UPDATE projects SET title=?, description=?, image=?, demo_url=?, github_url=? WHERE id=?");
            $stmt->execute([$title, $description, $image, $demo_url, $github_url, $id]);
            $message = "Project updated!";
        } else {
            $stmt = $pdo->prepare("INSERT INTO projects (title, description, image, demo_url, github_url) VALUES (?,?,?,?,?)");
            $stmt->execute([$title, $description, $image, $demo_url, $github_url]);
            $message = "Project added!";
        }
    }
}

$items = $pdo->query("SELECT * FROM projects ORDER BY id DESC")->fetchAll();
include './includes/head.php';
?>

<body class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 min-h-screen">
    <div class="pt-10 pb-8 px-6">
        <div class="max-w-7xl mx-auto">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-2">Manage Projects</h1>
                    <p class="text-gray-600 dark:text-gray-400">Add, edit, and organize your portfolio projects</p>
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

            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 p-8 mb-8">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Add New Project</h2>
                
                <form method="POST" enctype="multipart/form-data" class="space-y-6">
                    <input type="hidden" name="id" id="id">
                    <input type="hidden" name="existing_image" id="existing_image">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Project Title *
                            </label>
                            <input type="text" name="title" id="title" 
                                   class="w-full p-4 border border-gray-300 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" 
                                   placeholder="Enter project title"
                                   required>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Description
                            </label>
                            <textarea name="description" id="description" rows="4"
                                      class="w-full p-4 border border-gray-300 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                      placeholder="Describe your project..."></textarea>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Project Image
                            </label>
                            <div class="flex items-center justify-center w-full">
                                <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-xl cursor-pointer bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 transition">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <svg class="w-10 h-10 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                        </svg>
                                        <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">PNG, JPG, GIF or WEBP</p>
                                    </div>
                                    <input type="file" name="image" id="image_upload" accept="image/*" class="hidden">
                                </label>
                            </div>
                            <div id="current_image_preview" class="mt-4"></div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Demo URL
                            </label>
                            <input type="url" name="demo_url" id="demo_url" 
                                   class="w-full p-4 border border-gray-300 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                   placeholder="https://demo.example.com">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                GitHub URL
                            </label>
                            <input type="url" name="github_url" id="github_url" 
                                   class="w-full p-4 border border-gray-300 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                   placeholder="https://github.com/username/repo">
                        </div>
                    </div>

                    <div class="flex gap-4 pt-4">
                        <button type="submit" class="flex-1 px-8 py-4 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl hover:from-blue-700 hover:to-blue-800 font-semibold transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            Save Project
                        </button>
                        <button type="button" onclick="resetForm()" class="px-8 py-4 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-xl hover:bg-gray-300 dark:hover:bg-gray-600 font-semibold transition-all">
                            Clear Form
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Your Projects</h2>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700/50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Title</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Image</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Demo</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">GitHub</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            <?php foreach($items as $i): ?>
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-300">
                                    #<?= $i['id'] ?>
                                </td>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-gray-300">
                                    <?= htmlspecialchars($i['title']) ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php if($i['image']): ?>
                                        <img src="<?= htmlspecialchars($i['image']) ?>" class="h-16 w-16 object-cover rounded-lg shadow-md border-2 border-gray-200 dark:border-gray-600">
                                    <?php else: ?>
                                        <span class="text-gray-400 text-sm italic">No image</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <?php if($i['demo_url']): ?>
                                        <a href="<?= htmlspecialchars($i['demo_url']) ?>" target="_blank" 
                                           class="inline-flex items-center text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 font-medium">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                            </svg>
                                            View
                                        </a>
                                    <?php else: ?>
                                        <span class="text-gray-400">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <?php if($i['github_url']): ?>
                                        <a href="<?= htmlspecialchars($i['github_url']) ?>" target="_blank" 
                                           class="inline-flex items-center text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 font-medium">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                            </svg>
                                            Code
                                        </a>
                                    <?php else: ?>
                                        <span class="text-gray-400">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <div class="flex gap-2">
                                        <button onclick='edit(<?= $i['id'] ?>,"<?= addslashes($i['title']) ?>","<?= addslashes($i['description']) ?>","<?= addslashes($i['image']) ?>","<?= addslashes($i['demo_url']) ?>","<?= addslashes($i['github_url']) ?>")'
                                                class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 font-medium transition-all shadow hover:shadow-md">
                                            Edit
                                        </button>
                                        <button onclick='deleteProject(<?= $i['id'] ?>)'
                                                class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 font-medium transition-all shadow hover:shadow-md">
                                            Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            
                            <?php if(empty($items)): ?>
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                    </svg>
                                    <p class="text-gray-500 dark:text-gray-400 text-lg font-medium">No projects yet</p>
                                    <p class="text-gray-400 dark:text-gray-500 text-sm mt-1">Add your first project using the form above</p>
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
    function edit(id, title, desc, image, demo, github) {
        document.getElementById('id').value = id;
        document.getElementById('title').value = title;
        document.getElementById('description').value = desc;
        document.getElementById('existing_image').value = image;
        document.getElementById('demo_url').value = demo;
        document.getElementById('github_url').value = github;
        
        if(image) {
            document.getElementById('current_image_preview').innerHTML = 
                '<div class="p-4 bg-blue-50 dark:bg-blue-900/20 border-2 border-blue-200 dark:border-blue-800 rounded-xl">' +
                '<p class="text-sm font-semibold text-blue-900 dark:text-blue-300 mb-3">Current Image:</p>' +
                '<img src="' + image + '" class="h-40 rounded-lg shadow-lg border-2 border-white dark:border-gray-700">' +
                '<p class="text-xs text-blue-700 dark:text-blue-400 mt-3">Upload a new image to replace this one</p>' +
                '</div>';
        } else {
            document.getElementById('current_image_preview').innerHTML = '';
        }
        
        window.scrollTo({top: 0, behavior: 'smooth'});
    }

    function resetForm() {
        document.getElementById('id').value = '';
        document.getElementById('title').value = '';
        document.getElementById('description').value = '';
        document.getElementById('existing_image').value = '';
        document.getElementById('image_upload').value = '';
        document.getElementById('demo_url').value = '';
        document.getElementById('github_url').value = '';
        document.getElementById('current_image_preview').innerHTML = '';
    }

    function deleteProject(id) {
        if(!confirm('Are you sure you want to delete this project?')) {
            return;
        }
        
        const formData = new FormData();
        formData.append('action', 'delete');
        formData.append('delete_id', id);
        
        fetch(window.location.pathname, {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(text => {
            try {
                const data = JSON.parse(text);
                if(data.success) {
                    location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            } catch(e) {
                console.error('JSON parse error:', e);
                alert('Server error - check console');
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
            alert('Network error');
        });
    }
    </script>
</body>
</html>