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
        $query_applications = "SELECT id, applicant_name, applicant_email, motivation_letter, application_date FROM applications WHERE vacancy_id = ?";
        $stmt_applications = $pdo->prepare($query_applications);
        $stmt_applications->execute([$vacancyId]);
        $applications = $stmt_applications->fetchAll();
    } catch (PDOException $e) {
        echo "Failed to retrieve applications: " . $e->getMessage();
    }
}

if (isset($_GET['delete_applications'])) {
    $deleteapplicationsId = $_GET['delete_applications'];
    $query_delete_applications = "DELETE FROM applications WHERE id = ?";
    $stmt_delete_applications = $pdo->prepare($query_delete_applications);
    $stmt_delete_applications->execute([$deleteapplicationsId]);
    header("Location: apply.php");
    exit();
}

function getJobTitle($vacancyId) {
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
            <ul>
                <?php foreach ($applications as $application) : ?>
                    <div>
                        <strong><?= $application['applicant_name'] ?></strong>
                        <p>Email: <?= $application['applicant_email'] ?></p>
                        <p>Motivation Letter: <?= $application['motivation_letter'] ?></p>
                        <p>Application Date: <?= $application['application_date'] ?></p>

                        <form action="index.php" method="get" onsubmit="return confirm('Are you sure you want to delete this application?')">
                            <input type="hidden" name="delete_applications" value="<?= $application['id'] ?>">
                            <button type="submit" class="button-delete">DELETE</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            </ul>
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