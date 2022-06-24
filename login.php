<?php
include('./header.php');
echo '<h2>Log In</h2>';
$username = trim(htmlspecialchars($_POST['username'] ?? "", ENT_QUOTES)); //Escape XSS
$password = trim(htmlspecialchars($_POST['password'] ?? "", ENT_QUOTES));
if (isset($_POST['submit']) && $_POST['submit'] === "login") { //If clicked log in...
    $formComplete = true;
    if ($username === "" || strlen($username) > 64) { //Make sure username entered
        $formComplete = false;
    } else { //If entered, verify existence, escaping SQL injection
        $stmt = sprintf(
            "SELECT * FROM users WHERE username = '%s'",
            $conn->real_escape_string($username)
        );
        $result = $conn->query($stmt);
        $resultCheck = mysqli_num_rows($result);
        if ($resultCheck < 0) { //If not exist, set flag false
            $formComplete = false;
        } else {
            if ($row = mysqli_fetch_assoc($result)) { //If username exists, pull row from table
                $hashedCheck = password_verify($password, $row['password']); //Check if password matches
                if ($hashedCheck) { //If so, set session data
                    $_SESSION['uid'] = $row['id'];
                    $_SESSION['username'] = $username;
                    $_SESSION['state'] = $row['state'];
                    echo "<div><p>Log in successful! Welcome, $username!</p></div>";
                } else { //If not match, set flag false
                    $formComplete = false;
                }
            }
        }
    }
    if (!$formComplete) { //if flag false, tell user data incorrect
        echo "<div class=\"errors\"><ul>";
        echo "<li>Username and/or password incorrect.</li>";
        echo "</ul></div>";
    }
}
?>

<form class="entry-form" method="post">
    <label>Username</label>
    <input type="text" name="username" placeholder="Username" value="<?= $username ?>" />
    <label>Password</label>
    <input type="password" name="password" placeholder="Password" />
    <button type="submit" name="submit" value="login">Log In</button>
    <a class="button back-button" href="/">Back</a>
</form>