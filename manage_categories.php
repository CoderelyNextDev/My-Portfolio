<?php
session_start();
include './config/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    header('Content-Type: application/json');
    
    $delete_id = $_POST['delete_id'];
    
    try {
        $stmt = $pdo->prepare("DELETE FROM categories WHERE id=?");
        $stmt->execute([$delete_id]);
        
        echo json_encode(['success' => true, 'message' => 'Category deleted successfully!']);
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
    $label = $_POST['label'];

    if ($id) {
        $stmt = $pdo->prepare("UPDATE categories SET label=? WHERE id=?");
        $stmt->execute([$label, $id]);
        $message = "Category updated successfully!";
    } else {
        $stmt = $pdo->prepare("INSERT INTO categories (label) VALUES (?)");
        $stmt->execute([$label]);
        $message = "Category added successfully!";
    }
}

$items = $pdo->query("SELECT * FROM categories ORDER BY id DESC")->fetchAll();
include './includes/head.php';
?>

<body class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 min-h-screen">
    <div class="pt-10 pb-8 px-6">
        <div class="max-w-5xl mx-auto">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-2">Manage Categories</h1>
                    <p class="text-gray-600 dark:text-gray-400">Organize your content with custom categories</p>
                </div>
                <a href="dashboard.php" class="px-6 py-3 bg-gradient-to-r from-gray-600 to-gray-700 text-white rounded-xl hover:from-gray-700 hover:to-gray-800 font-medium transition-all shadow-lg hover:shadow-xl">
                    ← Dashboard
                </a>
            </div>

            <?php if($message): ?>
                <div class="mb-6 p-4 bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300 border border-green-200 dark:border-green-800 rounded-xl font-medium">
                    <?= $message ?>
                </div>
            <?php endif; ?>

            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 p-8 mb-8">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Add New Category</h2>
                
                <form method="POST" class="space-y-6">
                    <input type="hidden" name="id" id="id">
                    
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Category Name *
                        </label>
                        <input type="text" name="label" id="label" 
                               class="w-full p-4 border border-gray-300 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition" 
                               placeholder="e.g., Web Development, Design, Database"
                               required>
                    </div>

                    <div class="flex gap-4 pt-4">
                        <button type="submit" class="flex-1 px-8 py-4 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white rounded-xl hover:from-indigo-700 hover:to-indigo-800 font-semibold transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            Save Category
                        </button>
                        <button type="button" onclick="resetForm()" class="px-8 py-4 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-xl hover:bg-gray-300 dark:hover:bg-gray-600 font-semibold transition-all">
                            Clear
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Your Categories</h2>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700/50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Category Name</th>
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
                                    <span class="inline-flex items-center px-4 py-2 bg-indigo-100 dark:bg-indigo-900/30 text-indigo-800 dark:text-indigo-300 rounded-lg font-semibold">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                        </svg>
                                        <?= htmlspecialchars($i['label']) ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <div class="flex gap-2">
                                        <button onclick="edit(<?= $i['id'] ?>,'<?= addslashes($i['label']) ?>')"
                                                class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 font-medium transition-all shadow hover:shadow-md">
                                            Edit
                                        </button>
                                        <button onclick="deleteCategory(<?= $i['id'] ?>)"
                                                class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 font-medium transition-all shadow hover:shadow-md">
                                            Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            
                            <?php if(empty($items)): ?>
                            <tr>
                                <td colspan="3" class="px-6 py-12 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                    </svg>
                                    <p class="text-gray-500 dark:text-gray-400 text-lg font-medium">No categories yet</p>
                                    <p class="text-gray-400 dark:text-gray-500 text-sm mt-1">Add your first category using the form above</p>
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
    function edit(id, label) {
        document.getElementById('id').value = id;
        document.getElementById('label').value = label;
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function resetForm() {
        document.getElementById('id').value = '';
        document.getElementById('label').value = '';
    }

    function deleteCategory(id) {
        if(!confirm('Are you sure you want to delete this category?')) {
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