<?php
require 'includes/db.php';

$search = "";
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $stmt = $pdo->prepare("SELECT * FROM contacts WHERE name LIKE ?");
    $stmt->execute(["%$search%"]);
} else {
    $stmt = $pdo->query("SELECT * FROM contacts");
}
$contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Contact Book</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container p-4">
    <h2>Contact Book</h2>

    <form class="d-flex mb-3" method="get">
        <input type="text" name="search" class="form-control me-2" placeholder="Search by name" value="<?= htmlspecialchars($search) ?>">
        <button class="btn btn-primary">Search</button>
    </form>

    <a href="add.php" class="btn btn-success mb-3">Add Contact</a>

    <table class="table table-bordered">
        <tr>
            <th>Photo</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($contacts as $contact): ?>
            <tr>
                <td>
                    <?php if ($contact['photo']): ?>
                        <img src="uploads/<?= htmlspecialchars($contact['photo']) ?>" width="50">
                    <?php endif; ?>
                </td>
                <td><?= htmlspecialchars($contact['name']) ?></td>
                <td><?= htmlspecialchars($contact['email']) ?></td>
                <td><?= htmlspecialchars($contact['phone']) ?></td>
                <td>
                    <a href="edit.php?id=<?= $contact['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="delete.php?id=<?= $contact['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this contact?');">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
