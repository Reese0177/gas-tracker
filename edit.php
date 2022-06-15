<?php
include_once('./header.php');
$state = trim(htmlspecialchars($_POST['state'] ?? "", ENT_QUOTES));
if (isset($_POST['submit']) && $_POST['submit'] === 'delete') {
    $id = trim(htmlspecialchars($_POST['id'] ?? "", ENT_QUOTES));
    $servername = "127.0.0.1";
    $username = "root";
    $password = "password";
    $dbname = "gas-tracker";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("SQL Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("DELETE FROM stations WHERE id = ?;");
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $stmt->close();
    $conn->close();
    echo "<p>Deleted!</p><a href='/index.php?state=$state'>Back</a>";
} else {

    $price = trim(htmlspecialchars($_POST['price'] ?? "", ENT_QUOTES));
    $city = trim(htmlspecialchars($_POST['city'] ?? "", ENT_QUOTES));
    $location = trim(htmlspecialchars($_POST['location'] ?? "", ENT_QUOTES));
    $brand = trim(htmlspecialchars($_POST['brand'] ?? "", ENT_QUOTES));
    $id = trim(htmlspecialchars($_GET['station'] ?? "", ENT_QUOTES));

    if (isset($_POST['submit']) && $_POST['submit'] === 'update') {
        $formComplete = true;
        $errors = [];
        if (preg_match('/^\d{1,2}(\.\d{0,2})?$/', $price) === 0) {
            $formComplete = false;
            array_push($errors, "Please enter a valid price");
        }
        if ($city === "" || strlen($city) > 20) {
            $formComplete = false;
            array_push($errors, "Please enter a valid city no greater than 20 characters");
        }
        if ($location === "" || strlen($location) > 50) {
            $formComplete = false;
            array_push($errors, "Please enter a location (e.g. street address or cross streets) no greater than 50 characters");
        }
        if ($brand === "" || strlen($brand) > 20) {
            $formComplete = false;
            array_push($errors, "Please enter a brand no greater than 20 characters");
        }
        $statesArray = [
            'AL', 'AK', 'AZ', 'AR', 'CA', 'CO', 'CT', 'DE', 'DC', 'FL', 'GA', 'HI',
            'ID', 'IL', 'IN', 'IA', 'KS', 'KY', 'LA', 'ME', 'MD', 'MA', 'MI', 'MN', 'MS', 'MO', 'MT',
            'NE', 'NV', 'NH', 'NJ', 'NM', 'NY', 'NC', 'ND', 'OH', 'OK', 'OR', 'PA', 'RI', 'SC', 'SD',
            'TN', 'TX', 'UT', 'VT', 'VA', 'WA', 'WV', 'WI', 'WY'
        ];
        if (!in_array($state, $statesArray)) {
            $formComplete = false;
            array_push($errors, "Please select a valid state");
        }

        if ($formComplete) {

            $servername = "127.0.0.1";
            $username = "root";
            $password = "password";
            $dbname = "gas-tracker";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("SQL Connection failed: " . $conn->connect_error);
            }

            $stmt = $conn->prepare("UPDATE stations SET price = ?, city = ?, street = ?, brand = ?, state = ? WHERE id = ?;");
            $stmt->bind_param("sssssd", $price, $city, $location, $brand, $state, $id);
            $stmt->execute();
            $stmt->close();
            $conn->close();
?>
            <div>
                <p>Updated!</p>
            </div>
    <?php
        } else {
            echo "<div class=\"errors\"><ul>";
            foreach ($errors as $error) {
                echo "<li>$error</li>";
            }
            echo "</ul></div>";
        }
    }
    ?>

    <h2>Record a Price</h2>
    <form method="post">
        <label>Price</label>
        <input type="text" name="price" placeholder="0.00" value="<?= $price ?>" />
        <label>City</label>
        <input type="text" name="city" placeholder="City" value="<?= $city ?>" />
        <label>Location</label>
        <input type="text" name="location" placeholder="Location" value="<?= $location ?>" />
        <label>Brand</label>
        <input type="text" name="brand" placeholder="Brand" value="<?= $brand ?>" />
        <select name="state">
            <option value="">--Select a State--</option>
            <option value="AL" <?= ($state === "AL" ? "selected" : "") ?>>Alabama</option>
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
        <button type="submit" name="submit" value="update">Submit</button>
        <a href="/?state=<?= $state ?>">Back</a>
        <br />
        <p>WARNING: The following button will <span>PERMANENTLY DELETE</span> this record.</p>
        <form method="post">
            <input type="hidden" name="id" value="<?= $id ?>"/>
            <input type="hidden" name="state" value="<?= $state ?>"/>
            <button type="submit" name="submit" value="delete">DELETE</button>
        </form>
    </form>
<?php } ?>