<?php
include('./header.php');
echo "<h2>Sign Up</h2>";
$username = trim(htmlspecialchars($_POST['username'] ?? "", ENT_QUOTES));
$password = trim(htmlspecialchars($_POST['password'] ?? "", ENT_QUOTES));
$cpassword = trim(htmlspecialchars($_POST['c-password'] ?? "", ENT_QUOTES));
if (isset($_POST['submit']) && $_POST['submit'] === "signup") {
    $formComplete = true;
    $errors = [];
    if ($username === "" || strlen($username) > 64) {
        $formComplete = false;
        array_push($errors, "Please enter a username no greater than 64 characters.");
    } else {
        $stmt = sprintf(
            "SELECT * FROM users WHERE username = '%s'",
            $conn->real_escape_string($username)
        );
        $result = $conn->query($stmt);
        $resultCheck = mysqli_num_rows($result);
        if ($resultCheck > 0) {
            $formComplete = false;
            array_push($errors, "Username already taken. Please choose a new username.");
        }
    }
    if ($password === "") {
        $formComplete = false;
        array_push($errors, "Please enter a password.");
    } elseif ($password !== $cpassword) {
        $formComplete = false;
        array_push($errors, "Passwords do not match.");
    }

    if ($formComplete) {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?);");
        $stmt->bind_param("ss", $username, $hashed);
        $stmt->execute();
        $stmt->close();
        $conn->close();
        echo "<div><p>Sign up successful! Please log in to continue.</p></div>";
    } else {
        echo "<div class=\"errors\"><ul>";
        foreach ($errors as $error) {
            echo "<li>$error</li>";
        }
        echo "</ul></div>";
    }

}
?>

<form class="entry-form" method="post">
    <label>Username</label>
    <input type="text" name="username" placeholder="Username" value="<?= $username ?>" />
    <label>Password</label>
    <input type="password" name="password" placeholder="Password"/>
    <label>Confirm Password</label>
    <input type="password" name="c-password" placeholder="Confirm Password"/>
    <button type="submit" name="submit" value="signup">Sign Up</button>
    <a class="button back-button" href="/">Back</a>
</form>