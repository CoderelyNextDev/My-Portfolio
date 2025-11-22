<?php
session_start();
include './config/db_connect.php';
if(empty($_SESSION['user_logged_in'])){ header('Location: index.php'); exit; }

$message='';
if($_SERVER['REQUEST_METHOD']==='POST'){
    $id=$_POST['id']??'';
    $full_name=$_POST['full_name'];
    $tagline=$_POST['tagline']??'';
    $email=$_POST['email'];
    $phone=$_POST['phone_number']??'';
    $about=$_POST['about_summary']??'';
    $profile=$_POST['profile_picture_url']??'';

    if($id){
        $stmt=$pdo->prepare("UPDATE personal_info SET full_name=?, tagline=?, email=?, phone_number=?, about_summary=?, profile_picture_url=? WHERE id=?");
        $stmt->execute([$full_name,$tagline,$email,$phone,$about,$profile,$id]);
        $message="Profile updated!";
    }else{
        $stmt=$pdo->prepare("INSERT INTO personal_info (full_name, tagline, email, phone_number, about_summary, profile_picture_url) VALUES (?,?,?,?,?,?)");
        $stmt->execute([$full_name,$tagline,$email,$phone,$about,$profile]);
        $message="Profile added!";
    }
}

if(isset($_GET['delete'])){
    $stmt=$pdo->prepare("DELETE FROM personal_info WHERE id=?");
    $stmt->execute([$_GET['delete']]);
    $message="Profile deleted!";
}

$items=$pdo->query("SELECT * FROM personal_info ORDER BY id DESC")->fetchAll();
include './includes/head.php';
?>
<body class="bg-gray-50 dark:bg-gray-900 min-h-screen p-6">
<div class="max-w-6xl mx-auto">
<h1 class="text-3xl font-bold mb-6 text-gray-900 dark:text-white">Personal Info</h1>
<?php if($message):?><div class="mb-4 p-4 bg-green-100 text-green-800 rounded"><?=$message?></div><?php endif;?>
<form method="POST" class="mb-6 bg-white dark:bg-gray-800 p-6 rounded shadow space-y-4">
<input type="hidden" name="id" id="id">
<label>Full Name<input type="text" name="full_name" id="full_name" class="w-full p-2 border rounded" required></label>
<label>Tagline<input type="text" name="tagline" id="tagline" class="w-full p-2 border rounded"></label>
<label>Email<input type="email" name="email" id="email" class="w-full p-2 border rounded" required></label>
<label>Phone<input type="text" name="phone_number" id="phone_number" class="w-full p-2 border rounded"></label>
<label>About Summary<textarea name="about_summary" id="about_summary" class="w-full p-2 border rounded"></textarea></label>
<label>Profile Picture URL<input type="text" name="profile_picture_url" id="profile_picture_url" class="w-full p-2 border rounded"></label>
<button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Save</button>
</form>

<table class="min-w-full bg-white dark:bg-gray-800 rounded shadow">
<thead class="bg-gray-200 dark:bg-gray-700">
<tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Actions</th></tr>
</thead>
<tbody>
<?php foreach($items as $i):?>
<tr class="border-t border-gray-300 dark:border-gray-600">
<td><?=$i['id']?></td><td><?=htmlspecialchars($i['full_name'])?></td><td><?=htmlspecialchars($i['email'])?></td><td><?=htmlspecialchars($i['phone_number'])?></td>
<td>
<button onclick="edit(<?=$i['id']?>,'<?=addslashes($i['full_name'])?>','<?=addslashes($i['tagline'])?>','<?=addslashes($i['email'])?>','<?=addslashes($i['phone_number'])?>','<?=addslashes($i['about_summary'])?>','<?=addslashes($i['profile_picture_url'])?>')"
class="px-2 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600">Edit</button>
<a href="?delete=<?=$i['id']?>" onclick="return confirm('Delete?')" class="px-2 py-1 bg-red-600 text-white rounded hover:bg-red-700">Delete</a>
</td>
</tr>
<?php endforeach;?>
</tbody>
</table>
</div>
<script>
function edit(id,name,tagline,email,phone,about,profile){
document.getElementById('id').value=id;
document.getElementById('full_name').value=name;
document.getElementById('tagline').value=tagline;
document.getElementById('email').value=email;
document.getElementById('phone_number').value=phone;
document.getElementById('about_summary').value=about;
document.getElementById('profile_picture_url').value=profile;
window.scrollTo({top:0,behavior:'smooth'});
}
</script>
</body>
</html>
