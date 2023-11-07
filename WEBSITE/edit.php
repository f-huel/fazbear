<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newTitle = $_POST['new_title'];
    $newDate = $_POST['new_date'];
    $newTime = $_POST['new_time'];
    $newDescription = $_POST['new_description'];
    $id = $_POST['id'];

    $updateQuery = "UPDATE events SET event_title = ?, event_date = ?, event_time = ?, event_description = ? WHERE id = ?";
    $stmt = $pdo->prepare($updateQuery);
    $stmt->execute([$newTitle, $newDate, $newTime, $newDescription, $id]);

    header("Location: index.php?id=$id");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $events = $pdo->query("SELECT * FROM events WHERE id = $id")->fetch();
} else {
    echo "Connection failed: ";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAZBEAR EDIT</title>
    <link rel="stylesheet" href="css/edit.css">
</head>
<body>

    <nav>
        <ul>
            <li><img src="images/fnaflogo.png" alt="" width="190" height="190"></li>
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
        <input type="text" name="new_title" value="<?= $events['event_title'] ?>" class="input"><br>

        <label for="new_date" class="label">Date:</label>
        <input type="date" name="new_date" value="<?= $events['event_date'] ?>" class="input"><br>

        <label for="new_time" class="label">Time:</label>
        <input type="time" name="new_time" value="<?= $events['event_time'] ?>" class="input"><br>

        <label for="new_description" class="label">Description:</label>
        <textarea name="new_description" id="new_description" cols="30" rows="10" class="input"><?= $events['event_description'] ?></textarea><br>

        <input type="submit" value="Save" class="button">
    </form>
    </div>

</body>
</html>