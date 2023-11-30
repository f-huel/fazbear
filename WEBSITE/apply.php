<?php

include 'connection.php';

session_start();

$isLoggedIn = isset($_SESSION['user_id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $vacancyId = filter_input(INPUT_POST, 'vacancy_id', FILTER_SANITIZE_NUMBER_INT);
    $applicantName = filter_input(INPUT_POST, 'applicant_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $applicantEmail = filter_input(INPUT_POST, 'applicant_email', FILTER_VALIDATE_EMAIL);
    $motivationLetter = filter_input(INPUT_POST, 'motivation_letter', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $applicationDate = date('Y-m-d');

    if ($vacancyId && $applicantName && $applicantEmail && $motivationLetter) {
        try {
            $query_apply = "INSERT INTO applications (vacancy_id, applicant_name, applicant_email, motivation_letter, application_date) VALUES (?, ?, ?, ?, ?)";
            $stmt_apply = $pdo->prepare($query_apply);
            $stmt_apply->execute([$vacancyId, $applicantName, $applicantEmail, $motivationLetter, $applicationDate]);

            header("Location: index.php");
            exit();
        } catch (PDOException $e) {
            error_log("Application failed: " . $e->getMessage(), 0);
            echo "Application failed. Please try again later.";
        }
    } else {
        echo "Invalid data submitted.";
    }
}

if ($isLoggedIn && isset($_GET['vacancy_id'])) {
    $vacancyId = $_GET['vacancy_id'];

    try {
        $query_applications = "SELECT * FROM applications WHERE vacancy_id = ?";
        $stmt_applications = $pdo->prepare($query_applications);
        $stmt_applications->execute([$vacancyId]);
        $applications = $stmt_applications->fetchAll();
    } catch (PDOException $e) {
        echo "Failed to retrieve applications: " . $e->getMessage();
    }
}

if (isset($_GET['delete_app'])) {
    $deleteAppId = $_GET['delete_app'];
    try {
        $query_delete_app = "DELETE FROM applications WHERE id = ?";
        $stmt_delete_app = $pdo->prepare($query_delete_app);
        $stmt_delete_app->execute([$deleteAppId]);
        header("Location: index.php");
        exit();
    } catch (PDOException $e) {
        echo "Failed to delete application: " . $e->getMessage();
    }
}


function getJobTitle($vacancyId)
{
    global $pdo;
    $query_title = "SELECT job_title FROM vacancies WHERE id = ?";
    $stmt_title = $pdo->prepare($query_title);
    $stmt_title->execute([$vacancyId]);
    $title = $stmt_title->fetchColumn();
    return $title ? $title : 'Job';
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="Images/fnaflogo.png">
    <title>FAZBEAR APPLY</title>
    <link rel="stylesheet" href="css/apply.css">
</head>

<body>
    <nav>
        <ul>
            <li><a class="navbar-brand" href="index.php"><img src="Images/fnaflogo.png" alt="logo" width="150" height="150"></a></li>
        </ul>
    </nav>

    <?php if ($isLoggedIn && isset($applications)) : ?>
        <div class="applications-list">
            <h1>Applications for <?= isset($applications) ? htmlspecialchars(getJobTitle($_GET['vacancy_id'])) : 'Vacancy' ?></h1>

            <table class="table" style="align-items: center;">
                <tr>
                    <th class="text th">Name</th>
                    <th class="text th">Email</th>
                    <th class="text th">Motivation</th>
                    <th class="text th">Date</th>
                    <?php if ($isLoggedIn) : ?>
                        <th class="text th">Delete</th>
                    <?php endif; ?>
                </tr>

                <?php for ($i = 0; $i < count($applications); $i++) : ?>
                    <?php
                    $appId = $applications[$i]['id'];
                    $application = $applications[$i];
                    ?>
                    <tr>
                        <td class="text td"><?= $application['applicant_name'] ?></td>
                        <td class="text td"><?= $application['applicant_email'] ?></td>
                        <td class="text td"><?= $application['motivation_letter'] ?></td>
                        <td class="text td"><?= $application['application_date'] ?></td>
                        <?php if ($isLoggedIn) : ?>
                            <td class="text td">
                                <form action="apply.php" method="get" onsubmit="return confirm('Are you sure you want to delete this application?')">
                                    <input type="hidden" name="delete_app" value="<?= $appId ?>">
                                    <button type="submit" class="button-delete">DELETE</button>
                                </form>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endfor; ?>
            </table>
        </div>

    <?php else : ?>
        <div class="apply-form">
            <h1>Apply for <?= isset($_GET['vacancy_id']) ? htmlspecialchars(getJobTitle($_GET['vacancy_id'])) : 'Job' ?></h1>

            <form method="post" class="form">
                <input type="hidden" name="vacancy_id" value="<?= isset($_GET['vacancy_id']) ? htmlspecialchars($_GET['vacancy_id']) : '' ?>">

                <label for="applicant_name" class="label">Your Name:</label>
                <input type="text" name="applicant_name" placeholder="NAME" class="input" required>

                <label for="applicant_email" class="label">Your Email:</label>
                <input type="email" name="applicant_email" placeholder="EMAIL" class="input" required>

                <label for="motivation_letter" class="label">Motivation Letter:</label>
                <textarea name="motivation_letter" placeholder="MOTIVATION" class="input" required></textarea>

                <button type="submit" class="button">SUBMIT</button>
            </form>
        </div>
    <?php endif; ?>

</body>

</html>