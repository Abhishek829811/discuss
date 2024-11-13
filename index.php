<?php
// Only start the session if it's not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Include the header (Make sure the header.php file exists in the 'client' folder)
include('./client/header.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discuss</title>
    <!-- Link to your CSS file (Adjust the path as necessary) -->
    <link rel="stylesheet" href="public/style.css">
</head>
<body>

<?php
// Handle different page requests based on query parameters
if (isset($_GET['signup']) && (!isset($_SESSION['user']) || !$_SESSION['user']['username'])) {
    include('./client/signup.php'); // Include signup page
} else if (isset($_GET['login']) && (!isset($_SESSION['user']) || !$_SESSION['user']['username'])) {
    include('./client/login.php'); // Include login page
} else if (isset($_GET['ask'])) {
    include('./client/ask.php'); // Include ask question page
} else if (isset($_GET['q-id'])) {
    $qid = $_GET['q-id'];
    include('./client/question-details.php'); // Include question details page
} else if (isset($_GET['c-id'])) {
    $cid = $_GET['c-id'];
    include('./client/questions.php'); // Include category-based question list
} else if (isset($_GET['u-id'])) {
    $uid = $_GET['u-id'];
    include('./client/questions.php'); // Include user-specific questions list
} else if (isset($_GET['latest'])) {
    include('./client/questions.php'); // Include latest questions
} else if (isset($_GET['search'])) {
    $search = $_GET['search'];
    include('./client/questions.php'); // Include search results
} else {
    include('./client/questions.php'); // Default, show all questions
}
?>

</body>
</html>
