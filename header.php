<head>
    <title>Gas Tracker</title>
    <link rel="stylesheet" href="/style.css" />
</head>
<header>
    <div><h1><a id="header-link" href="/">Gas Tracker</a></h1></div>
    <?php
    $statesArray = [
        'AL', 'AK', 'AZ', 'AR', 'CA', 'CO', 'CT', 'DE', 'DC', 'FL', 'GA', 'HI',
        'ID', 'IL', 'IN', 'IA', 'KS', 'KY', 'LA', 'ME', 'MD', 'MA', 'MI', 'MN', 'MS', 'MO', 'MT',
        'NE', 'NV', 'NH', 'NJ', 'NM', 'NY', 'NC', 'ND', 'OH', 'OK', 'OR', 'PA', 'RI', 'SC', 'SD',
        'TN', 'TX', 'UT', 'VT', 'VA', 'WA', 'WV', 'WI', 'WY'
    ];

    if (!isset($_SESSION['username'])) { ?>
        <div id="login-links">
            <a href="signup.php" class='button'>Sign Up</a>
            <a href='login.php' class='button'>Log In</a>
        </div>


    <?php } else {
        $username = $_SESSION['username'];
        $uid = $_SESSION['id'];
        echo "<p class='name'>Welcome, $username!</p>";
    }

    ?>

</header>