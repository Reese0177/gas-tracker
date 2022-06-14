<?php
include_once('./header.php');
?>
<form>
    <select name="state">
        <option value="AL" <?php if ($_GET['state'] === "AL") echo "selected"; ?>>Alabama</option>
        <option value="AK" <?php if ($_GET['state'] === "AK") echo "selected"; ?>>Alaska</option>
        <option value="AZ" <?php if ($_GET['state'] === "AZ") echo "selected"; ?>>Arizona</option>
        <option value="AR" <?php if ($_GET['state'] === "AR") echo "selected"; ?>>Arkansas</option>
        <option value="CA" <?php if ($_GET['state'] === "CA") echo "selected"; ?>>California</option>
        <option value="CO" <?php if ($_GET['state'] === "CO") echo "selected"; ?>>Colorado</option>
        <option value="CT" <?php if ($_GET['state'] === "CT") echo "selected"; ?>>Connecticut</option>
        <option value="DE" <?php if ($_GET['state'] === "DE") echo "selected"; ?>>Delaware</option>
        <option value="DC" <?php if ($_GET['state'] === "DC") echo "selected"; ?>>District Of Columbia</option>
        <option value="FL" <?php if ($_GET['state'] === "FL") echo "selected"; ?>>Florida</option>
        <option value="GA" <?php if ($_GET['state'] === "GA") echo "selected"; ?>>Georgia</option>
        <option value="HI" <?php if ($_GET['state'] === "HI") echo "selected"; ?>>Hawaii</option>
        <option value="ID" <?php if ($_GET['state'] === "ID") echo "selected"; ?>>Idaho</option>
        <option value="IL" <?php if ($_GET['state'] === "IL") echo "selected"; ?>>Illinois</option>
        <option value="IN" <?php if ($_GET['state'] === "IN") echo "selected"; ?>>Indiana</option>
        <option value="IA" <?php if ($_GET['state'] === "IA") echo "selected"; ?>>Iowa</option>
        <option value="KS" <?php if ($_GET['state'] === "KS") echo "selected"; ?>>Kansas</option>
        <option value="KY" <?php if ($_GET['state'] === "KY") echo "selected"; ?>>Kentucky</option>
        <option value="LA" <?php if ($_GET['state'] === "LA") echo "selected"; ?>>Louisiana</option>
        <option value="ME" <?php if ($_GET['state'] === "ME") echo "selected"; ?>>Maine</option>
        <option value="MD" <?php if ($_GET['state'] === "MD") echo "selected"; ?>>Maryland</option>
        <option value="MA" <?php if ($_GET['state'] === "MA") echo "selected"; ?>>Massachusetts</option>
        <option value="MI" <?php if ($_GET['state'] === "MI") echo "selected"; ?>>Michigan</option>
        <option value="MN" <?php if ($_GET['state'] === "MN") echo "selected"; ?>>Minnesota</option>
        <option value="MS" <?php if ($_GET['state'] === "MS") echo "selected"; ?>>Mississippi</option>
        <option value="MO" <?php if ($_GET['state'] === "MO") echo "selected"; ?>>Missouri</option>
        <option value="MT" <?php if ($_GET['state'] === "MT") echo "selected"; ?>>Montana</option>
        <option value="NE" <?php if ($_GET['state'] === "NE") echo "selected"; ?>>Nebraska</option>
        <option value="NV" <?php if ($_GET['state'] === "NV") echo "selected"; ?>>Nevada</option>
        <option value="NH" <?php if ($_GET['state'] === "NH") echo "selected"; ?>>New Hampshire</option>
        <option value="NJ" <?php if ($_GET['state'] === "NJ") echo "selected"; ?>>New Jersey</option>
        <option value="NM" <?php if ($_GET['state'] === "NM") echo "selected"; ?>>New Mexico</option>
        <option value="NY" <?php if ($_GET['state'] === "NY") echo "selected"; ?>>New York</option>
        <option value="NC" <?php if ($_GET['state'] === "NC") echo "selected"; ?>>North Carolina</option>
        <option value="ND" <?php if ($_GET['state'] === "ND") echo "selected"; ?>>North Dakota</option>
        <option value="OH" <?php if ($_GET['state'] === "OH") echo "selected"; ?>>Ohio</option>
        <option value="OK" <?php if ($_GET['state'] === "OK") echo "selected"; ?>>Oklahoma</option>
        <option value="OR" <?php if ($_GET['state'] === "OR") echo "selected"; ?>>Oregon</option>
        <option value="PA" <?php if ($_GET['state'] === "PA") echo "selected"; ?>>Pennsylvania</option>
        <option value="RI" <?php if ($_GET['state'] === "RI") echo "selected"; ?>>Rhode Island</option>
        <option value="SC" <?php if ($_GET['state'] === "SC") echo "selected"; ?>>South Carolina</option>
        <option value="SD" <?php if ($_GET['state'] === "SD") echo "selected"; ?>>South Dakota</option>
        <option value="TN" <?php if ($_GET['state'] === "TN") echo "selected"; ?>>Tennessee</option>
        <option value="TX" <?php if ($_GET['state'] === "TX") echo "selected"; ?>>Texas</option>
        <option value="UT" <?php if ($_GET['state'] === "UT") echo "selected"; ?>>Utah</option>
        <option value="VT" <?php if ($_GET['state'] === "VT") echo "selected"; ?>>Vermont</option>
        <option value="VA" <?php if ($_GET['state'] === "VA") echo "selected"; ?>>Virginia</option>
        <option value="WA" <?php if ($_GET['state'] === "WA") echo "selected"; ?>>Washington</option>
        <option value="WV" <?php if ($_GET['state'] === "WV") echo "selected"; ?>>West Virginia</option>
        <option value="WI" <?php if ($_GET['state'] === "WI") echo "selected"; ?>>Wisconsin</option>
        <option value="WY" <?php if ($_GET['state'] === "WY") echo "selected"; ?>>Wyoming</option>
        <option value="AS" <?php if ($_GET['state'] === "AS") echo "selected"; ?>>American Samoa</option>
        <option value="GU" <?php if ($_GET['state'] === "GU") echo "selected"; ?>>Guam</option>
        <option value="MP" <?php if ($_GET['state'] === "MP") echo "selected"; ?>>Northern Mariana Islands</option>
        <option value="PR" <?php if ($_GET['state'] === "PR") echo "selected"; ?>>Puerto Rico</option>
        <option value="UM" <?php if ($_GET['state'] === "UM") echo "selected"; ?>>United States Minor Outlying Islands</option>
        <option value="VI" <?php if ($_GET['state'] === "VI") echo "selected"; ?>>Virgin Islands</option>
    </select>
    <button type="submit">Go</button>
</form>
<div>
    <a href="add.php">Record a Price</a>
</div>
<?php
if (isset($_GET['state'])) {
    $state = htmlspecialchars($_GET['state'], ENT_QUOTES);
    if (strlen(trim($state)) === 2) {
        $servername = "127.0.0.1";
        $username = "root";
        $password = "password";
        $dbname = "gas-tracker";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("SQL Connection failed: " . $conn->connect_error);
        }

        $stmt = sprintf("SELECT * FROM stations WHERE state = '%s'", $conn->real_escape_string($state));
        $stations = $conn->query($stmt);

        if (mysqli_num_rows($stations) === 0) {
            echo "<p>No stations found in $state";
        } else {
?>
            <table>
                <tr>
                    <th>Price</th>
                    <th>City</th>
                    <th>Location</th>
                    <th>Brand</th>
                </tr>
                <?php
                foreach ($stations as $station) { ?>
                    <tr>
                        <td><?php echo $station['price'] ?></td>
                        <td><?php echo $station['city'] ?></td>
                        <td><?php echo $station['street'] ?></td>
                        <td><?php echo $station['brand'] ?></td>
                    </tr>
    <?php }
                echo "</table>";
            }
            $conn->close();
        }
    }
