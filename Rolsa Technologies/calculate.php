<?php
session_start(); // Start the session

require_once "includes/dbh.inc.php";

// Assuming the user's name is stored in the session
$first_name = isset($_SESSION['first_name']) ? $_SESSION['first_name'] : 'firstname';
$last_name = isset($_SESSION['last_name']) ? $_SESSION['last_name'] : 'lastname';
$email = isset($_SESSION['email']) ? $_SESSION['email'] : 'email';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculate | Rolsa Technologies</title>

    <!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="css/swiper-bundle.min.css">

    <!-- CSS link -->
    <link rel="stylesheet" href="css/cal.css?v=<?php echo time(); ?>">

    <!-- CSS link -->
    <link rel="stylesheet" href="css/darkmode.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome CDN link -->
    <link rel="stylesheet" 
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" 
    integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" 
    crossorigin="anonymous" 
    referrerpolicy="no-referrer" />

    <!-- Boxicons CSS -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

</head>
<body>

    <div class="sidebar">
        <header>
            <div class="avatar-text">
                <div class="avatar-container">
                <img src="<?php echo isset($_SESSION['user_avatar']) ? htmlspecialchars($_SESSION['user_avatar'], ENT_QUOTES, 'UTF-8') : 'path/to/default-avatar.jpg'; ?>" alt="User Avatar" class="avatar">
                    <div class="text header-text">
                    <span class="name">
                        <?php 
                        if (isset($_SESSION['user_id'])) {
                            $user_id = $_SESSION['user_id'];
                            $query = "SELECT first_name, last_name FROM `users` WHERE id = :user_id LIMIT 1";
                            $stmt = $pdo->prepare($query);
                            $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
                            $stmt->execute();
                            $row = $stmt->fetch(PDO::FETCH_ASSOC);
                            if ($row) {
                                echo htmlspecialchars($row['first_name'], ENT_QUOTES, 'UTF-8') . ' ' . htmlspecialchars($row['last_name'], ENT_QUOTES, 'UTF-8');
                            } else {
                                echo "User not found";
                            }
                        } else {
                            echo "Not logged in";
                        }
                        ?>
                    </span>
                </div>
                </div>
            </div>
        </header>
        <nav class="sidebar-nav">
            <h1>Dashboard</h1>
            <ul>
                <li><a href="dashboard.php"><i class="fa-solid fa-chart-simple"></i> Overview</a></li>
            </ul>

            <h1>Area of Focus</h1>
            <ul>
                <li><a href="book.php"> Book</a></li>
                <li><a href="#"> Calculate</a></li>
                <li><a href="blog.php"> Blog</a></li>
                <li><a href="dash-setting-detail.php"> Settings</a></li>
            </ul>

            <footer>
            <a href="#" class="logo" style="display: flex; flex-direction: row;"><i class="fa-solid fa-shoe-prints fa-bounce" style="color: #20511f; padding-right: 10px;"></i><h3 style="color: #000; font-size: 1rem; font-weight: 700; ">Rolsa Technologies</h3></a>
            <div class="accessibility-link" style="display: flex; flex-direction: row; gap:5px; margin: 10px 20px">
                <a href="dash-term.php"><h3 style="color: #333; font-size: 0.9rem; font-weight: 200;">Terms and conditions</h3></a>
                <a href="dash-cookies.php"><h3 style="color: #333; font-size: 0.9rem; font-weight: 200;">Cookies</h3></a>
            </div>
            </footer>
            <style>
                .accessibility-link a:hover {
                    color: #007BFF; /* Changing text color on hover */
                    text-decoration: underline; /* Adding underline on hover */
                }
            </style>
        </nav>
    </div>

    <section class="subtitle">
        <h4>Dashboard | Calculate </h4>
        <div class="icons">
            <a href="#"><i class="fa-solid fa-globe"></i></a>
            <a id="toggleDarkMode" title="Toggle Dark Mode"><i class="fa-solid fa-circle-half-stroke"></i></a>
            <a href="home.php"><i class="fa-solid fa-right-from-bracket"></i></a>   
        </div>
    </section>

    
    <section class="carbon-footprint">
        <h2>Want to know your carbon footprint?</h2>
        <p>Calculate yours now!</p>
        <a href="cal-carbon.php" class="carbon-container">
            <h1>Click Here!</h1>
        </a>
    </section>

    <section class="energy-consumption">
        <h2>Want to know your energy consumption?</h2>
        <p>Calculate yours now!</p>
        <a href="cal-energy.php" class="energy-container">
            <h1>Click Here!</h1>
        </a>
    </section>

    <section class="summary">
        <h1>Summary</h1>
        <p>See your energy consumption and carbon footprint </p>

        <div class="containers">
            <div class="categories">
                <h1>Carbon footprint and energy consumption by categories</h1>
                <div class="cat">
                    <h3>Power, Heating & Lighting: <?php
                        if (isset($_SESSION['carbon_results']['power_heating_lighting'])) {
                            echo htmlspecialchars($_SESSION['carbon_results']['power_heating_lighting'], ENT_QUOTES, 'UTF-8') . " kg CO2";
                        } else {
                            echo "----";
                        }
                        ?></h3>
                </div>
                <div class="cat">
                    <h3>Transport: <p>
                    <?php
                    if (isset($_SESSION['carbon_results']['transport'])) {
                        echo htmlspecialchars($_SESSION['carbon_results']['transport'], ENT_QUOTES, 'UTF-8') . " kg CO2";
                    } else {
                        echo "----";
                    }
                    ?>
                </p></h3>
                </div>
            </div>

            <div class="sum-container">
                <h1>Total Carbon footprint and energy consumption</h1>
                <div class="sum">
                    <h3>Your total Carbon Footprint is: <?php
                    if (isset($_SESSION['carbon_results']['total_carbon_footprint'])) {
                        echo htmlspecialchars($_SESSION['carbon_results']['total_carbon_footprint'], ENT_QUOTES, 'UTF-8') . " kg CO2";
                    } else {
                        echo "----";
                    }
                    ?></h3>
                </div>
                <div class="sum">
                    <h3>Your total Energy Consumption is: </h3>
                </div>
            </div>
        </div>
    </section>


    <script src="js/dark-mode.js"></script>
    
</body>
</html>