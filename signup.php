<?php
include('./header.php');
echo "<h2>Sign Up</h2>";
$username = trim(htmlspecialchars($_POST['username'] ?? "", ENT_QUOTES)); //Escape XSS
$password = trim(htmlspecialchars($_POST['password'] ?? "", ENT_QUOTES));
$cpassword = trim(htmlspecialchars($_POST['c-password'] ?? "", ENT_QUOTES));
$state = trim(htmlspecialchars($_POST['state'] ?? "", ENT_QUOTES));
if (isset($_POST['submit']) && $_POST['submit'] === "signup") { //If clicked sign up...
    $formComplete = true;
    $errors = [];
    if ($username === "" || strlen($username) > 64) { //Make sure username entered
        $formComplete = false;
        array_push($errors, "Please enter a username no greater than 64 characters.");
    } else { //If username entered...
        $stmt = sprintf(
            "SELECT * FROM users WHERE username = '%s'",
            $conn->real_escape_string($username) //Escape SQL injection and make sure username available
        );
        $result = $conn->query($stmt);
        $resultCheck = mysqli_num_rows($result);
        if ($resultCheck > 0) { //If username taken, say so
            $formComplete = false;
            array_push($errors, "Username already taken. Please choose a new username.");
        }
    }
    if ($password === "") { //Make sure password entered
        $formComplete = false;
        array_push($errors, "Please enter a password.");
    } elseif ($password !== $cpassword) { //Make sure passwords match
        $formComplete = false;
        array_push($errors, "Passwords do not match.");
    }
    if (!in_array($state, $statesArray)) { //Make sure state valid
        $formComplete = false;
        array_push($errors, "Please select a valid state");
    }

    if ($formComplete) { //If all valid...
        $hashed = password_hash($password, PASSWORD_DEFAULT); //Hash password
        $stmt = $conn->prepare("INSERT INTO users (username, password, state) VALUES (?, ?, ?);");
        $stmt->bind_param("sss", $username, $hashed, $state);
        $stmt->execute(); //Escape SQL injection and insert user to database
        $stmt->close();
        $conn->close();
        echo "<div><p>Sign up successful! Please log in to continue.</p></div>";
    } else { //If not all valid...
        echo "<div class=\"errors\"><ul>";
        foreach ($errors as $error) { //Tell user why
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
    <label>State</label>
    <select name="state">
        <option value="">--Select a State--</option>
        <option value="AL" <?= ($state === "AL" ? "selected" : "") //Select the previously selected state if available?>>Alabama</option>
        <option value="AK" <?= ($state === "AK" ? "selected" : "") ?>>Alaska</option>
        <option value="AZ" <?= ($state === "AZ" ? "selected" : "") ?>>Arizona</option>
        <option value="AR" <?= ($state === "AR" ? "selected" : "") ?>>Arkansas</option>
        <option value="CA" <?= ($state === "CA" ? "selected" : "") ?>>California</option>
        <option value="CO" <?= ($state === "CO" ? "selected" : "") ?>>Colorado</option>
        <option value="CT" <?= ($state === "CT" ? "selected" : "") ?>>Connecticut</option>
        <option value="DE" <?= ($state === "DE" ? "selected" : "") ?>>Delaware</option>
        <option value="DC" <?= ($state === "DC" ? "selected" : "") ?>>District Of Columbia</option>
        <option value="FL" <?= ($state === "FL" ? "selected" : "") ?>>Florida</option>
        <option value="GA" <?= ($state === "GA" ? "selected" : "") ?>>Georgia</option>
        <option value="HI" <?= ($state === "HI" ? "selected" : "") ?>>Hawaii</option>
        <option value="ID" <?= ($state === "ID" ? "selected" : "") ?>>Idaho</option>
        <option value="IL" <?= ($state === "IL" ? "selected" : "") ?>>Illinois</option>
        <option value="IN" <?= ($state === "IN" ? "selected" : "") ?>>Indiana</option>
        <option value="IA" <?= ($state === "IA" ? "selected" : "") ?>>Iowa</option>
        <option value="KS" <?= ($state === "KS" ? "selected" : "") ?>>Kansas</option>
        <option value="KY" <?= ($state === "KY" ? "selected" : "") ?>>Kentucky</option>
        <option value="LA" <?= ($state === "LA" ? "selected" : "") ?>>Louisiana</option>
        <option value="ME" <?= ($state === "ME" ? "selected" : "") ?>>Maine</option>
        <option value="MD" <?= ($state === "MD" ? "selected" : "") ?>>Maryland</option>
        <option value="MA" <?= ($state === "MA" ? "selected" : "") ?>>Massachusetts</option>
        <option value="MI" <?= ($state === "MI" ? "selected" : "") ?>>Michigan</option>
        <option value="MN" <?= ($state === "MN" ? "selected" : "") ?>>Minnesota</option>
        <option value="MS" <?= ($state === "MS" ? "selected" : "") ?>>Mississippi</option>
        <option value="MO" <?= ($state === "MO" ? "selected" : "") ?>>Missouri</option>
        <option value="MT" <?= ($state === "MT" ? "selected" : "") ?>>Montana</option>
        <option value="NE" <?= ($state === "NE" ? "selected" : "") ?>>Nebraska</option>
        <option value="NV" <?= ($state === "NV" ? "selected" : "") ?>>Nevada</option>
        <option value="NH" <?= ($state === "NH" ? "selected" : "") ?>>New Hampshire</option>
        <option value="NJ" <?= ($state === "NJ" ? "selected" : "") ?>>New Jersey</option>
        <option value="NM" <?= ($state === "NM" ? "selected" : "") ?>>New Mexico</option>
        <option value="NY" <?= ($state === "NY" ? "selected" : "") ?>>New York</option>
        <option value="NC" <?= ($state === "NC" ? "selected" : "") ?>>North Carolina</option>
        <option value="ND" <?= ($state === "ND" ? "selected" : "") ?>>North Dakota</option>
        <option value="OH" <?= ($state === "OH" ? "selected" : "") ?>>Ohio</option>
        <option value="OK" <?= ($state === "OK" ? "selected" : "") ?>>Oklahoma</option>
        <option value="OR" <?= ($state === "OR" ? "selected" : "") ?>>Oregon</option>
        <option value="PA" <?= ($state === "PA" ? "selected" : "") ?>>Pennsylvania</option>
        <option value="RI" <?= ($state === "RI" ? "selected" : "") ?>>Rhode Island</option>
        <option value="SC" <?= ($state === "SC" ? "selected" : "") ?>>South Carolina</option>
        <option value="SD" <?= ($state === "SD" ? "selected" : "") ?>>South Dakota</option>
        <option value="TN" <?= ($state === "TN" ? "selected" : "") ?>>Tennessee</option>
        <option value="TX" <?= ($state === "TX" ? "selected" : "") ?>>Texas</option>
        <option value="UT" <?= ($state === "UT" ? "selected" : "") ?>>Utah</option>
        <option value="VT" <?= ($state === "VT" ? "selected" : "") ?>>Vermont</option>
        <option value="VA" <?= ($state === "VA" ? "selected" : "") ?>>Virginia</option>
        <option value="WA" <?= ($state === "WA" ? "selected" : "") ?>>Washington</option>
        <option value="WV" <?= ($state === "WV" ? "selected" : "") ?>>West Virginia</option>
        <option value="WI" <?= ($state === "WI" ? "selected" : "") ?>>Wisconsin</option>
        <option value="WY" <?= ($state === "WY" ? "selected" : "") ?>>Wyoming</option>
    </select>
    <button type="submit" name="submit" value="signup">Sign Up</button>
    <a class="button back-button" href="/">Back</a>
</form>