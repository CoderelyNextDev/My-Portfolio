<?php
session_start();
include './config/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    header('Content-Type: application/json');
    
    $delete_id = $_POST['delete_id'];
    
    try {
        $stmt = $pdo->prepare("SELECT image FROM certificates WHERE id=?");
        $stmt->execute([$delete_id]);
        $cert = $stmt->fetch();
        
        $stmt = $pdo->prepare("DELETE FROM certificates WHERE id=?");
        $stmt->execute([$delete_id]);
        
        if ($cert && $cert['image'] && file_exists($cert['image'])) {
            unlink($cert['image']);
        }
        
        echo json_encode(['success' => true, 'message' => 'Certificate deleted successfully!']);
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
    $description = $_POST['description'] ?? '';
    $image = $_POST['existing_image'] ?? '';

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = './assets/images/certificates/';
        
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        $file_extension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'pdf'];
        
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
            $message = "Invalid file type. Only JPG, PNG, GIF, WEBP, and PDF allowed!";
        }
    }

    if (!$message) {
        if ($id) {
            $stmt = $pdo->prepare("UPDATE certificates SET title=?, image=?, description=? WHERE id=?");
            $stmt->execute([$title, $image, $description, $id]);
            $message = "Certificate updated successfully!";
        } else {
            $stmt = $pdo->prepare("INSERT INTO certificates (title,image,description) VALUES (?,?,?)");
            $stmt->execute([$title, $image, $description]);
            $message = "Certificate added successfully!";
        }
    }
}

$items = $pdo->query("SELECT * FROM certificates ORDER BY id DESC")->fetchAll();
include './includes/head.php';
?>

<body class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 min-h-screen">
    <div class="pt-10 pb-8 px-6">
        <div class="max-w-7xl mx-auto">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-2">Manage Certificates</h1>
                    <p class="text-gray-600 dark:text-gray-400">Add and showcase your professional certifications</p>
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
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Add New Certificate</h2>
                
                <form method="POST" enctype="multipart/form-data" class="space-y-6">
                    <input type="hidden" name="id" id="id">
                    <input type="hidden" name="existing_image" id="existing_image">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Certificate Title *
                            </label>
                            <input type="text" name="title" id="title" 
                                   class="w-full p-4 border border-gray-300 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition" 
                                   placeholder="e.g., AWS Certified Developer, Google Cloud Associate"
                                   required>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Certificate Image/PDF
                            </label>
                            <div class="flex items-center justify-center w-full">
                                <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-xl cursor-pointer bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 transition">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <svg class="w-10 h-10 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                                        </svg>
                                        <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">PNG, JPG, PDF (MAX. 5MB)</p>
                                    </div>
                                    <input type="file" name="image" id="image_upload" accept="image/*,.pdf" class="hidden">
                                </label>
                            </div>
                            <div id="current_image_preview" class="mt-4"></div>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Description
                            </label>
                            <textarea name="description" id="description" rows="4"
                                      class="w-full p-4 border border-gray-300 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition"
                                      placeholder="Add details about the certification, issuing organization, etc..."></textarea>
                        </div>
                    </div>

                    <div class="flex gap-4 pt-4">
                        <button type="submit" class="flex-1 px-8 py-4 bg-gradient-to-r from-yellow-600 to-yellow-700 text-white rounded-xl hover:from-yellow-700 hover:to-yellow-800 font-semibold transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            Save Certificate
                        </button>
                        <button type="button" onclick="resetForm()" class="px-8 py-4 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-xl hover:bg-gray-300 dark:hover:bg-gray-600 font-semibold transition-all">
                            Clear Form
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Your Certificates</h2>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700/50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Certificate</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Image</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Description</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            <?php foreach($items as $i): ?>
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-300">
                                    #<?= $i['id'] ?>
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-yellow-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                        <span class="font-semibold text-gray-900 dark:text-gray-300">
                                            <?= htmlspecialchars($i['title']) ?>
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php if($i['image']): ?>
                                        <?php if(pathinfo($i['image'], PATHINFO_EXTENSION) === 'pdf'): ?>
                                            <a href="<?= htmlspecialchars($i['image']) ?>" target="_blank" class="inline-flex items-center px-3 py-1 bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300 rounded-lg text-xs font-semibold">
                                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"></path>
                                                </svg>
                                                PDF
                                            </a>
                                        <?php else: ?>
                                            <img src="<?= htmlspecialchars($i['image']) ?>" class="h-16 w-16 object-cover rounded-lg shadow-md border-2 border-gray-200 dark:border-gray-600">
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <span class="text-gray-400 text-sm italic">No file</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                                    <?php if($i['description']): ?>
                                        <div class="max-w-xs truncate">
                                            <?= htmlspecialchars($i['description']) ?>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-gray-400">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <div class="flex gap-2">
                                        <button onclick='edit(<?= $i['id'] ?>,"<?= addslashes($i['title']) ?>","<?= addslashes($i['image']) ?>","<?= addslashes($i['description']) ?>")'
                                                class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 font-medium transition-all shadow hover:shadow-md">
                                            Edit
                                        </button>
                                        <button onclick="deleteCertificate(<?= $i['id'] ?>)"
                                                class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 font-medium transition-all shadow hover:shadow-md">
                                            Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            
                            <?php if(empty($items)): ?>
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                                    </svg>
                                    <p class="text-gray-500 dark:text-gray-400 text-lg font-medium">No certificates yet</p>
                                    <p class="text-gray-400 dark:text-gray-500 text-sm mt-1">Add your first certificate using the form above</p>
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
    function edit(id, title, image, desc) {
        document.getElementById('id').value = id;
        document.getElementById('title').value = title;
        document.getElementById('existing_image').value = image;
        document.getElementById('description').value = desc;
        
        if(image) {
            const isPdf = image.toLowerCase().endsWith('.pdf');
            document.getElementById('current_image_preview').innerHTML = 
                '<div class="p-4 bg-yellow-50 dark:bg-yellow-900/20 border-2 border-yellow-200 dark:border-yellow-800 rounded-xl">' +
                '<p class="text-sm font-semibold text-yellow-900 dark:text-yellow-300 mb-3">Current File:</p>' +
                (isPdf 
                    ? '<a href="' + image + '" target="_blank" class="inline-flex items-center px-4 py-2 bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300 rounded-lg font-semibold"><svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"></path></svg>View PDF</a>'
                    : '<img src="' + image + '" class="h-40 rounded-lg shadow-lg border-2 border-white dark:border-gray-700">'
                ) +
                '<p class="text-xs text-yellow-700 dark:text-yellow-400 mt-3">Upload a new file to replace this one</p>' +
                '</div>';
        } else {
            document.getElementById('current_image_preview').innerHTML = '';
        }
        
        window.scrollTo({top: 0, behavior: 'smooth'});
    }

    function resetForm() {
        document.getElementById('id').value = '';
        document.getElementById('title').value = '';
        document.getElementById('existing_image').value = '';
        document.getElementById('image_upload').value = '';
        document.getElementById('description').value = '';
        document.getElementById('current_image_preview').innerHTML = '';
    }

    function deleteCertificate(id) {
        if(!confirm('Are you sure you want to delete this certificate?')) {
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