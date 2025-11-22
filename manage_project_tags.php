<?php
session_start();
include './config/db_connect.php';
if(empty($_SESSION['user_logged_in'])){ header('Location: index.php'); exit; }

$message='';
$projects=$pdo->query("SELECT id,title FROM projects ORDER BY title ASC")->fetchAll();

if($_SERVER['REQUEST_METHOD']==='POST'){
    $id=$_POST['id']??'';
    $project_id=$_POST['project_id'];
    $tag=$_POST['tag'];
    if($id){
        $stmt=$pdo->prepare("UPDATE project_tags SET project_id=?, tag=? WHERE id=?");
        $stmt->execute([$project_id,$tag,$id]);
        $message="Tag updated!";
    }else{
        $stmt=$pdo->prepare("INSERT INTO project_tags (project_id,tag) VALUES (?,?)");
        $stmt->execute([$project_id,$tag]);
        $message="Tag added!";
    }
}
if(isset($_GET['delete'])){
    $stmt=$pdo->prepare("DELETE FROM project_tags WHERE id=?");
    $stmt->execute([$_GET['delete']]);
    $message="Tag deleted!";
}

$items=$pdo->query("SELECT t.*, p.title as project_title FROM project_tags t LEFT JOIN projects p ON t.project_id=p.id ORDER BY t.id DESC")->fetchAll();
include './includes/head.php';
?>
<body class="bg-gray-50 dark:bg-gray-900 min-h-screen p-6">
<div class="max-w-6xl mx-auto">
<h1 class="text-3xl font-bold mb-6 text-gray-900 dark:text-white">Project Tags</h1>
<?php if($message):?><div class="mb-4 p-4 bg-green-100 text-green-800 rounded"><?=$message?></div><?php endif;?>
<form method="POST" class="mb-6 bg-white dark:bg-gray-800 p-6 rounded shadow space-y-4">
<input type="hidden" name="id" id="id">
<label>Project
<select name="project_id" id="project_id" class="w-full p-2 border rounded">
<?php foreach($projects as $p):?><option value="<?=$p['id']?>"><?=$p['title']?></option><?php endforeach;?>
</select></label>
<label>Tag<input type="text" name="tag" id="tag" class="w-full p-2 border rounded" required></label>
<button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Save</button>
</form>

<table class="min-w-full bg-white dark:bg-gray-800 rounded shadow">
<thead class="bg-gray-200 dark:bg-gray-700">
<tr><th>ID</th><th>Project</th><th>Tag</th><th>Actions</th></tr>
</thead>
<tbody>
<?php foreach($items as $i):?>
<tr class="border-t border-gray-300 dark:border-gray-600">
<td><?=$i['id']?></td>
<td><?=htmlspecialchars($i['project_title'])?></td>
<td><?=htmlspecialchars($i['tag'])?></td>
<td>
<button onclick="edit(<?=$i['id']?>,'<?=$i['project_id']?>','<?=addslashes($i['tag'])?>')" class="px-2 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600">Edit</button>
<a href="?delete=<?=$i['id']?>" onclick="return confirm('Delete?')" class="px-2 py-1 bg-red-600 text-white rounded hover:bg-red-700">Delete</a>
</td>
</tr>
<?php endforeach;?>
</tbody>
</table>
</div>
<script>
function edit(id,project,tag){
document.getElementById('id').value=id;
document.getElementById('project_id').value=project;
document.getElementById('tag').value=tag;
window.scrollTo({top:0,behavior:'smooth'});
}
</script>
</body>
</html>
