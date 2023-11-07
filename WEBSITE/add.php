<?php

include 'connection.php';

$query_add = "INSERT INTO events (event_title, event_date, event_time, event_description) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($query_add);
    if (isset($_POST['add'])) {
        $stmt->execute([$_POST['event_title'], $_POST['event_date'], $_POST['event_time'], $_POST['event_description']]);
        header("Location: index.php");
        exit();
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAZBEAR ADD</title>
    <link rel="stylesheet" href="css/edit.css">
</head>
<body>

<nav>
        <ul>
            <li><img src="images/fnaflogo.png" alt="" width="190" height="190"></li>
        </ul>
    </nav>

    <div class="section">
        <h1 class="text">New Event</h1>

    <div style="text-align: center;">
        <form action="index.php" method="get">
            <input type="hidden">
            <button type="submit" class="button">
                < GO BACK</button>
        </form>
    </div>

    <br>

    <form method="post" class="form">

        <label for="event_title" class="label">Title:</label>
        <input type="text" name="event_title" class="input">

        <label for="event_date" class="label">Date:</label>
        <input type="date" name="event_date" class="input">

        <label for="event_time" class="label">Time:</label>
        <input type="time" name="event_time" class="input">

        <label for="event_description" class="label">Description:</label>
        <textarea name="event_description" class="input" cols="30" rows="10"></textarea>

        <input type="submit" value="ADD" name="add" class="button">

    </form>
</div>
    
</body>
</html>