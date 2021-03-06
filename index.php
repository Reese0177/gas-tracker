<?php
include('./header.php'); //Prevent XSS by escaping special chars
$state = trim(htmlspecialchars($_GET['state'] ?? '', ENT_QUOTES));
$search = trim(htmlspecialchars($_GET['search'] ?? '', ENT_QUOTES));
$filter = trim(htmlspecialchars($_GET['filter'] ?? '', ENT_QUOTES));
?>
<div id="searches">
    <form>
        <select name="state">
            <option value="">--Select a State--</option>
            <option value="AL" <?= ($state === "AL" ? "selected" : "") //Select the previously selected state if available 
                                ?>>Alabama</option>
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
        <button type="submit">Go</button>
    </form>
    <?php
    if (isset($_GET['state']) && in_array($state, $statesArray)) { //If state valid...
    ?>
        <form>
            <input type="text" placeholder="Search" name="search" value="<?= $search ?>" />
            <select name="filter">
                <option value="">--Select a Search Filter--</option>
                <option value="price" <?= ($filter === "price" ? "selected" : "") ?>>Price</option>
                <option value="city" <?= ($filter === "city" ? "selected" : "") ?>>City</option>
                <option value="street" <?= ($filter === "street" ? "selected" : "") ?>>Location</option>
                <option value="brand" <?= ($filter === "brand" ? "selected" : "") ?>>Brand</option>
            </select>
            <input type="hidden" name="state" value="<?= $state ?>" />
            <button type="submit" name="submit" value="search">Search</button>
        </form>
        <?php } //Search box
    echo "</div>";
    if (isset($username)) { //Show only if logged in
        echo "<div id='record'>
    <a class='button' href='record.php'>Record a Price</a>
</div>";
    }

    if (isset($_GET['state']) && in_array($state, $statesArray)) { //If state valid...
        $filterArray = ["price", "city", "street", "brand"];

        $stmt = sprintf(
            "SELECT * FROM stations WHERE state = '%s'" . (isset($_GET['search']) && isset($_GET['filter']) && in_array($filter, $filterArray) ? 'AND %s LIKE "%%%s%%"' : ""),
            $conn->real_escape_string($state),
            $conn->real_escape_string($filter),
            $conn->real_escape_string($search) //Query db for search, escaping SQL injection
        );
        $result = $conn->query($stmt);

        if (mysqli_num_rows($result) === 0) { //If no results found with query, say so
            echo "<p>No stations found in $state" . (isset($_GET['search']) && isset($_GET['filter']) && in_array($filter, $filterArray) ? " with $filter of $search" : "");
        } else { //If results found, create table of results
        ?>
            <table>
                <tr>
                    <th>Price</th>
                    <th>City</th>
                    <th>Location</th>
                    <th>Brand</th>
                </tr>
                <?php
                $rows = $result->fetch_all(MYSQLI_ASSOC);
                $reversed = array_reverse($rows);
                foreach ($reversed as $station) { ?>
                    <tr>
                        <td><?= $station['price'] ?></td>
                        <td><?= $station['city'] ?></td>
                        <td><?= $station['street'] ?></td>
                        <td><?= $station['brand'] ?></td>
                        <?php if (isset($_SESSION['uid']) && $station['cid'] === $_SESSION['uid']) { //If user is logged in and created this record, show Edit button
                        ?>
                            <td class="edit-td">
                                <form method="post" action="/edit.php?station=<?= $station['id'] ?>">
                                    <input type="hidden" name="price" value="<?= $station['price'] ?>" />
                                    <input type="hidden" name="city" value="<?= $station['city'] ?>" />
                                    <input type="hidden" name="location" value="<?= $station['street'] ?>" />
                                    <input type="hidden" name="brand" value="<?= $station['brand'] ?>" />
                                    <input type="hidden" name="state" value="<?= $station['state'] ?>" />
                                    <input type="hidden" name="cid" value="<?= $station['cid'] ?>" />
                                    <button type="submit" name="submit" value="edit">Edit</button>
                                </form>
                            </td>
                        <?php } ?>
                    </tr>
        <?php }
                echo "</table>";
            }
            $conn->close();
        } else { //If state not valid...
            if (isset($_SESSION['state'])) { //If the user is logged in, redirect to their home state
                $state = trim(htmlspecialchars($_SESSION['state']));
                header("Location: index.php?state=$state");
            } else {
                echo "<p>Select a state to view recorded prices.</p>"; //If not logged in, tell them to choose one
            }
        }
