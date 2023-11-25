<?php
include 'connection.php';

session_start();

$isLoggedIn = isset($_SESSION['user_id']);

try {
    $query_events = "SELECT event_title, event_date, event_time, event_description, id FROM events";
    $stmt_events = $pdo->query($query_events);
    $result_events = $stmt_events->fetchAll();

    $query_vacancies = "SELECT job_title, job_payment, job_description, job_availability, id FROM vacancies";
    $stmt_vacancies = $pdo->query($query_vacancies);
    $result_vacancies = $stmt_vacancies->fetchAll();

    $query_contact = "INSERT INTO contact (name_form, email_form, phone_form, message_form) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($query_contact);
    if (isset($_POST['send'])) {
        $stmt->execute([$_POST['name_form'], $_POST['email_form'], $_POST['phone_form'], $_POST['message_form']]);
        header("Location: index.php");
        exit();
    }

    if (isset($_GET['delete_event'])) {
        $deleteEventId = $_GET['delete_event'];
        $query_delete_event = "DELETE FROM events WHERE id = ?";
        $stmt_delete_event = $pdo->prepare($query_delete_event);
        $stmt_delete_event->execute([$deleteEventId]);
        header("Location: index.php");
        exit();
    }

    if (isset($_GET['logout'])) {
        header("Location: logout.php");
        exit();
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="Images/fnaflogo.png">
    <title>FAZBEAR</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body class="body">

    <audio muted autoplay loop>
        <source src="Sounds/main.mp3" type="audio/mp3">
    </audio>

    <nav class="stroke navbar">
        <div class="container-fluid">
                <ul>
                    <li><a class="navbar-brand" href="index.php"><img src="Images/fnaflogo.png" alt="logo" width="150" height="150"></a></li>
                    <li class="nav-item"><a class="nav-link" href="#home">HOME</a></li>
                    <li class="nav-item"><a class="nav-link" href="#events">EVENTS</a></li>
                    <li class="nav-item"><a class="nav-link" href="#vacancies">VACANCIES</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contact">CONTACT</a></li>
                    <li class="nav-item"><a class="nav-link" href="login.php">LOGIN</a></li>
                    <?php if ($isLoggedIn) : ?>
                        <li class="nav-item"><a class="nav-link" href="?logout=true">LOGOUT</a></li>
                    <?php endif; ?>

                </ul>
        </div>
    </nav>


    <div class="section" id="home">
        <h1>HOME</h1>
        <br>
        <a href="location.php"><img src="images/pizzeria.png" alt="pizzeria logo" href="" width="250" height="250" class="image"></a>
    </div>

    <div class="section" id="events">
        <h1>EVENTS</h1>
        <br>
        <table class="table">
            <tr>
                <th class="text th">Event Title</th>
                <th class="text th">Date</th>
                <th class="text th">Time</th>
                <th class="text th">Details</th>
            <?php if ($isLoggedIn) : ?>
                <th class="text th">Edit</th>
                <th class="text th">Delete</th>
            <?php endif; ?>
            </tr>

            <?php
            for ($i = 0; $i < count($result_events); $i++) {
                $eventId = $result_events[$i]['id'];
            ?>
                <tr>
                    <td class="text td"><?= $result_events[$i]['event_title'] ?></td>
                    <td class="text td"><?= $result_events[$i]['event_date'] ?></td>
                    <td class="text td"><?= $result_events[$i]['event_time'] ?></td>
                    <td class="text td"><?= $result_events[$i]['event_description'] ?></td>
                <?php if ($isLoggedIn) : ?>
                    <td class="text td"><a href="edit.php?id=<?= $result_events[$i]['id'] ?>" class="button-edit">EDIT</a></td>
                    <td class="text td">
                        <form action="index.php" method="get" onsubmit="return confirm('Are you sure you want to delete this event?')">
                            <input type="hidden" name="delete_event" value="<?= $eventId ?>">
                            <button type="submit" class="button-delete">DELETE</button>
                        </form>
                    </td>
                <?php endif; ?>
                </tr>
            <?php
            }
            ?>
        </table>

    <?php if ($isLoggedIn) : ?>
        <div style="text-align: center;">
            <form action="add.php" method="get">
                <input type="hidden">
                <button type="submit" class="button">ADD EVENT</button>
            </form>
        </div>
    <?php endif; ?>

        <br>

    </div>

    <div class="section" id="vacancies">
        <h1>VACANCIES</h1>
        <br>

        <div class="card-container">
            <div class="card-row">
                <?php
                $i = 0;
                foreach ($result_vacancies as $vacancy) {
                    $jobTitle = htmlspecialchars($vacancy['job_title']);
                    $availibility = $vacancy['job_availability'];
                    $vacancyId = $vacancy['id'];

                ?>
                    <div class="vacancy-card">
                        <h4 class="home"><?= $jobTitle ?></h4>
                        <p class="home">$<?= $vacancy['job_payment'] ?> per hour</p>
                        <p class="home"><?= $vacancy['job_description'] ?></p>
                        <?php

                        if ($availibility == true) {
                            if ($isLoggedIn) {
                                echo '<a href="apply.php?vacancy_id=' . urlencode($vacancyId) . '" class="apply-button">View Applications</a>';
                            } else {
                                echo '<a href="apply.php?vacancy_id=' . urlencode($vacancyId) . '" class="apply-button">Apply</a>';
                            }
                        } else {
                            echo '<button class="disabled-button" disabled>NOT AVAILABLE</button>';
                        }

                        ?>
                    </div>
                <?php
                    $i++;
                    if ($i % 2 == 0) {
                        echo '</div><div class="card-row">';
                    }
                }
                ?>
            </div>
        </div>
    </div>



    <div class="section" id="contact">
        <h1>CONTACT</h1>
        <br>
        <div class="contact-form">
            <form method="post">
                <label for="name_form">Name:</label>
                <input type="text" name="name_form" placeholder="Name" required>
                <label for="email_form">Email:</label>
                <input type="email" name="email_form" placeholder="Email" required>
                <label for="phone_form">Phone:</label>
                <input type="tel" name="phone_form" placeholder="Phone" required>
                <label for="message_form">Message:</label>
                <textarea name="message_form" placeholder="Message" required></textarea>
                <input type="submit" value="SEND" name="send">
            </form>
        </div>
    </div>
</body>

</html>