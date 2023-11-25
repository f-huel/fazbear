<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newTitle = $_POST['new_title'];
    $newDate = $_POST['new_date'];
    $newTime = $_POST['new_time'];
    $newDescription = $_POST['new_description'];
    $id = $_POST['id'];

    try {
        $updateQuery = "UPDATE events SET event_title = ?, event_date = ?, event_time = ?, event_description = ? WHERE id = ?";
        $stmt = $pdo->prepare($updateQuery);
        $stmt->execute([$newTitle, $newDate, $newTime, $newDescription, $id]);

        header("Location: index.php?id=$id");
        exit();
    } catch (PDOException $e) {
        echo "Update failed: " . $e->getMessage();
        exit();
    }
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        $query = "SELECT * FROM events WHERE id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$id]);
        $events = $stmt->fetch();
    } catch (PDOException $e) {
        echo "Failed to retrieve event: " . $e->getMessage();
        exit();
    }
} else {
    echo "Invalid request.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="Images/fnaflogo.png">
    <title>FAZBEAR EDIT</title>
    <link rel="stylesheet" href="css/edit.css">
</head>
<body>

    <nav>
        <ul>
        <li><a class="navbar-brand" href="index.php"><img src="Images/fnaflogo.png" alt="logo" width="150" height="150"></a></li>
        </ul>
    </nav>

    <div class="section" id="edit">
        <h1 class="text">Edit Event</h1>

    <div style="text-align: center;">
        <form action="index.php" method="get">
            <input type="hidden" name="id" value="<?= $events['id'] ?>">
            <button type="submit" class="button">
                < GO BACK</button>
        </form>
    </div>

    <h2 class="text"><?= $events['event_title'] ?></h2>

    <form method="post" class="form">
        <input type="hidden" name="id" value="<?= $id ?>">

        <label for="new_title" class="label">Title:</label>
        <input type="text" name="new_title" value="<?= htmlspecialchars($events['event_title']) ?>" class="input"><br>

        <label for="new_date" class="label">Date:</label>
        <input type="date" name="new_date" value="<?= htmlspecialchars($events['event_date']) ?>" class="input"><br>

        <label for="new_time" class="label">Time:</label>
        <input type="time" name="new_time" value="<?= htmlspecialchars($events['event_time']) ?>" class="input"><br>

        <label for="new_description" class="label">Description:</label>
        <textarea name="new_description" id="new_description" cols="30" rows="10" class="input"><?= htmlspecialchars($events['event_description']) ?></textarea><br>

        <input type="submit" value="SAVE" class="button">
    </form>
    </div>

</body>
</html>
