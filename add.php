<?php
require 'includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $photoName = "";

    if (isset($_FILES["photo"]) && $_FILES["photo"]["error"] == 0) {
        $photoName = time() . "_" . $_FILES["photo"]["name"];
        move_uploaded_file($_FILES["photo"]["tmp_name"], "uploads/" . $photoName);
    }

    $stmt = $pdo->prepare("INSERT INTO contacts (name, email, phone, photo) VALUES (?, ?, ?, ?)");
    $stmt->execute([$name, $email, $phone, $photoName]);

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Contact</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container p-4">
    <h2>Add Contact</h2>
    <form method="post" enctype="multipart/form-data">
        <input class="form-control mb-2" type="text" name="name" placeholder="Name" required>
        <input class="form-control mb-2" type="email" name="email" placeholder="Email" required>
        <input class="form-control mb-2" type="text" name="phone" placeholder="Phone" required>
        <input class="form-control mb-2" type="file" name="photo">
        <button class="btn btn-success">Add Contact</button>
        <a href="index.php" class="btn btn-secondary">Cancel</a>
    </form>
</body>
</html>
