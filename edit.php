<?php
require 'includes/db.php';

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM contacts WHERE id = ?");
$stmt->execute([$id]);
$contact = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$contact) {
    die("Contact not found.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];

    $photoName = $contact["photo"];
    if (isset($_FILES["photo"]) && $_FILES["photo"]["error"] == 0) {
        $photoName = time() . "_" . $_FILES["photo"]["name"];
        move_uploaded_file($_FILES["photo"]["tmp_name"], "uploads/" . $photoName);
    }

    $stmt = $pdo->prepare("UPDATE contacts SET name=?, email=?, phone=?, photo=? WHERE id=?");
    $stmt->execute([$name, $email, $phone, $photoName, $id]);

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Contact</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container p-4">
    <h2>Edit Contact</h2>
    <form method="post" enctype="multipart/form-data">
        <input class="form-control mb-2" type="text" name="name" value="<?= htmlspecialchars($contact['name']) ?>" required>
        <input class="form-control mb-2" type="email" name="email" value="<?= htmlspecialchars($contact['email']) ?>" required>
        <input class="form-control mb-2" type="text" name="phone" value="<?= htmlspecialchars($contact['phone']) ?>" required>
        <input class="form-control mb-2" type="file" name="photo">
        <?php if ($contact['photo']): ?>
            <img src="uploads/<?= htmlspecialchars($contact['photo']) ?>" width="80" class="mb-2">
        <?php endif; ?>
        <button class="btn btn-primary">Update Contact</button>
        <a href="index.php" class="btn btn-secondary">Cancel</a>
    </form>
</body>
</html>
