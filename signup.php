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
        array_push($errors, "Please enter a username no greater than 64 characters");
    } else {
        
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
    <a class="button back-button" href="/">Cancel</a>
</form>