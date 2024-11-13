<?php
session_start();
include("../common/db.php");

// Handle signup
if (isset($_POST['signup'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $address = $_POST['address'];

    // Hash the password before storing it
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert the user into the database
    $user = $conn->prepare("INSERT INTO `users` (`id`, `username`, `email`, `password`, `address`) 
                            VALUES (NULL, ?, ?, ?, ?)");
    $user->bind_param("ssss", $username, $email, $hashed_password, $address);

    if ($user->execute()) {
        $_SESSION["user"] = ["username" => $username, "email" => $email, "user_id" => $user->insert_id];
        header("Location: /discuss");
        exit;
    } else {
        echo "Error: New user not registered";
    }
}

// Handle login
else if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare query to fetch user by email
    $query = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $query->bind_param("s", $email);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        // Check if the password matches the hash in the database
        if (password_verify($password, $row['password'])) {
            $_SESSION["user"] = ["username" => $row['username'], "email" => $row['email'], "user_id" => $row['id']];
            header("Location: /discuss");
            exit;
        } else {
            echo "Incorrect password.";
        }
    } else {
        echo "No user found with this email.";
    }
}

// Handle logout
else if (isset($_GET['logout'])) {
    session_unset();
    header("Location: /discuss");
    exit;
}

// Handle question submission
else if (isset($_POST["ask"])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $category_id = $_POST['category'];
    $user_id = $_SESSION['user']['user_id'];

    // Insert the question into the database
    $question = $conn->prepare("INSERT INTO `questions` (`id`, `title`, `description`, `category_id`, `user_id`) 
                                VALUES (NULL, ?, ?, ?, ?)");
    $question->bind_param("ssii", $title, $description, $category_id, $user_id);

    if ($question->execute()) {
        header("Location: /discuss");
        exit;
    } else {
        echo "Error: Question not added.";
    }
}

// Handle answer submission
else if (isset($_POST["answer"])) {
    $answer = $_POST['answer'];
    $question_id = $_POST['question_id'];
    $user_id = $_SESSION['user']['user_id'];

    // Insert the answer into the database
    $query = $conn->prepare("INSERT INTO `answers` (`id`, `answer`, `question_id`, `user_id`) 
                            VALUES (NULL, ?, ?, ?)");
    $query->bind_param("sii", $answer, $question_id, $user_id);

    if ($query->execute()) {
        header("Location: /discuss?q-id=$question_id");
        exit;
    } else {
        echo "Error: Answer not submitted.";
    }
}

// Handle question deletion
else if (isset($_GET["delete"])) {
    $qid = $_GET["delete"];
    $query = $conn->prepare("DELETE FROM questions WHERE id = ?");
    $query->bind_param("i", $qid);
    if ($query->execute()) {
        header("Location: /discuss");
        exit;
    } else {
        echo "Error: Question not deleted.";
    }
}
?>
