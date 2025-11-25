<?php
session_start();
include './config/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    header('Content-Type: application/json');
    
    $delete_id = $_POST['delete_id'];
    
    try {
        $stmt = $pdo->prepare("DELETE FROM skills WHERE id=?");
        $stmt->execute([$delete_id]);
        
        echo json_encode(['success' => true, 'message' => 'Skill deleted successfully!']);
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
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['action'])) {
    $id = $_POST['id'] ?? '';
    $skill_name = $_POST['skill_name'];
    $proficiency = $_POST['proficiency'] ?? 0;
    $category = $_POST['category'] ?? '';
    $years = $_POST['years'] ?? 0;

    if ($id) {
        $stmt = $pdo->prepare("UPDATE skills SET skill_name=?, proficiency=?, category=?, years=? WHERE id=?");
        $stmt->execute([$skill_name, $proficiency, $category, $years, $id]);
        $_SESSION['message'] = 'Skill updated successfully!';
    } else {
        $stmt = $pdo->prepare("INSERT INTO skills (skill_name, proficiency, category, years) VALUES (?, ?, ?, ?)");
        $stmt->execute([$skill_name, $proficiency, $category, $years]);
        $_SESSION['message'] = 'Skill added successfully!';
    }
    
    header('Location: manage_skills.php');
    exit;
}

$skills = $pdo->query("SELECT * FROM skills ORDER BY id DESC")->fetchAll();
include './includes/head.php';
?>

<body class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 min-h-screen">
    <div class="pt-10 pb-8 px-6">
        <div class="max-w-7xl mx-auto">
            <div class="flex items-center justify-between mb-6 flex-col gap-3 md:flex-row">
                <div>
                    <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-2">Manage Skills</h1>
                    <p class="text-gray-600 dark:text-gray-400">Add and organize your technical skills</p>
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
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Add New Skill</h2>
                
                <form method="POST" class="space-y-6">
                    <input type="hidden" name="id" id="skill_id">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Skill Name *
                            </label>
                            <input type="text" name="skill_name" id="skill_name" 
                                   class="w-full p-4 border border-gray-300 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" 
                                   placeholder="e.g., JavaScript, React, Python"
                                   required>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Proficiency Level (%)
                            </label>
                            <input type="number" name="proficiency" id="skill_proficiency" 
                                   class="w-full p-4 border border-gray-300 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" 
                                   min="0" max="100" placeholder="0-100" required>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Years of Experience
                            </label>
                            <input type="number" step="0.1" name="years" id="skill_years" 
                                   class="w-full p-4 border border-gray-300 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" 
                                   placeholder="e.g., 2.5" required>
                        </div>

                       <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Category
                            </label>
                            <select name="category" id="skill_category"
                                class="w-full p-4 border border-gray-300 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                required>
                                <option value="" disabled selected>Select Category</option>
                                <option value="frontend">Frontend</option>
                                <option value="backend">Backend</option>
                                <option value="tools">Tools</option>
                            </select>
                        </div>

                    </div>

                    <div class="flex gap-4 pt-4">
                        <button type="submit" class="flex-1 px-8 py-4 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl hover:from-blue-700 hover:to-blue-800 font-semibold transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            Save Skill
                        </button>
                        <button type="button" onclick="resetForm()" class="px-8 py-4 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-xl hover:bg-gray-300 dark:hover:bg-gray-600 font-semibold transition-all">
                            Clear Form
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Your Skills</h2>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700/50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Skill Name</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Proficiency</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Category</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Years</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            <?php foreach($skills as $s): ?>
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-300">
                                    #<?= $s['id'] ?>
                                </td>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-gray-300">
                                    <?= htmlspecialchars($s['skill_name']) ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-24 bg-gray-200 dark:bg-gray-700 rounded-full h-2.5 mr-3">
                                            <div class="bg-gradient-to-r from-blue-500 to-purple-500 h-2.5 rounded-full" style="width: <?= $s['proficiency'] ?>%"></div>
                                        </div>
                                        <span class="text-sm font-semibold text-gray-700 dark:text-gray-300"><?= $s['proficiency'] ?>%</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-300">
                                    <?php if($s['category']): ?>
                                        <span class="px-3 py-1 bg-purple-100 dark:bg-purple-900/30 text-purple-800 dark:text-purple-300 rounded-full text-xs font-semibold">
                                            <?= htmlspecialchars($s['category']) ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="text-gray-400">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-300">
                                    <?= $s['years'] ? $s['years'] . ' years' : '-' ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <div class="flex gap-2">
                                        <button onclick="editSkill(<?= $s['id'] ?>,'<?= addslashes($s['skill_name']) ?>','<?= $s['proficiency'] ?>','<?= addslashes($s['category']) ?>','<?= $s['years'] ?>')"
                                                class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 font-medium transition-all shadow hover:shadow-md">
                                            Edit
                                        </button>
                                        <button onclick="deleteSkill(<?= $s['id'] ?>)"
                                                class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 font-medium transition-all shadow hover:shadow-md">
                                            Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            
                            <?php if(empty($skills)): ?>
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                    </svg>
                                    <p class="text-gray-500 dark:text-gray-400 text-lg font-medium">No skills yet</p>
                                    <p class="text-gray-400 dark:text-gray-500 text-sm mt-1">Add your first skill using the form above</p>
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
    function editSkill(id, name, proficiency, category, years) {
        document.getElementById('skill_id').value = id;
        document.getElementById('skill_name').value = name;
        document.getElementById('skill_proficiency').value = proficiency;
        document.getElementById('skill_category').value = category;
        document.getElementById('skill_years').value = years;
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function resetForm() {
        document.getElementById('skill_id').value = '';
        document.getElementById('skill_name').value = '';
        document.getElementById('skill_proficiency').value = '';
        document.getElementById('skill_category').value = '';
        document.getElementById('skill_years').value = '';
    }

    function deleteSkill(id) {
        if(!confirm('Are you sure you want to delete this skill?')) {
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