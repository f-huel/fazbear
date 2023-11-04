<?php

include 'connection.php';

try {

    $query_events = "SELECT event_title, event_date, event_time, id FROM events";
    $result_events = $pdo->query($query_events)->fetchAll();

    $query_contact = "INSERT INTO contact (name_form, email_form, phone_form, message_form) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($query_contact);
    if (isset($_POST['send'])) {
        $stmt->execute([$_POST['name_form'], $_POST['email_form'], $_POST['phone_form'], $_POST['message_form']]);
        header("Location: index.php");
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
    <title>HOME</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <nav>
        <ul>
            <li><img src="images/fnaflogo.png" alt="" width="190" height="190"></li>
            <li><a href="#home">HOME</a></li>
            <li><a href="#events">EVENTS</a></li>
            <li><a href="#vacancies">VACANCIES</a></li>
            <li><a href="#contact">CONTACT</a></li>
        </ul>
    </nav>

    <div class="section" id="home">
        <h1>HOME</h1>
        <br>
        <h3>
            Welcome To Freddy Fazbear's Pizza. A Magical Place For Kids And Grownups Alike, Where Fantasy And Fun Come To Life.
        </h3>
    </div>

    <div class="section" id="events">
        <h1>EVENTS</h1>
        <br>
        <table>
            <tr>
                <th class="text">Event Title</th>
                <th class="text">Date</th>
                <th class="text">Time</th>
                <th class="text">Details</th>
            </tr>

            <?php

            for ($i = 0; $i < count($result_events); $i++) {
                ?>
                <tr>
                    <td class="text"><?= $result_events[$i]['event_title'] ?></td>
                    <td class="text"><?= $result_events[$i]['event_date'] ?></td>
                    <td class="text"><?= $result_events[$i]['event_time'] ?></td>
                    <td class="text"><button name="id" type="submit" value="<?= $result_events[$i]['id'] ?>">See Details</button></td>
                </tr>

                <?php
            }

            ?>

        </table>

    </div>

    <div class="section" id="vacancies">
        <h1>VACANCIES</h1>
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

    <script src="js/script.js"></script>
</body>

</html>