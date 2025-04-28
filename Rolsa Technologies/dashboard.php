<?php
session_start(); // Start the session

require_once "includes/dbh.inc.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Assuming the user's name is stored in the session
$first_name = isset($_SESSION['first_name']) ? $_SESSION['first_name'] : 'firstname';
$last_name = isset($_SESSION['last_name']) ? $_SESSION['last_name'] : 'lastname';
$email = isset($_SESSION['email']) ? $_SESSION['email'] : 'email';

// Fetch the latest carbon footprint data for the logged-in user
$user_id = $_SESSION['user_id'];
$sql = "SELECT power_heating_lighting, transport, total_carbon_footprint, created_at 
        FROM carbon_footprint 
        WHERE user_id = :user_id 
        ORDER BY created_at DESC 
        LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$latest_footprint = $stmt->fetch(PDO::FETCH_ASSOC);

// Set default values if no data is found
if ($latest_footprint) {
    $power_heating_lighting = $latest_footprint['power_heating_lighting'];
    $transport = $latest_footprint['transport'];
    $total_carbon_footprint = $latest_footprint['total_carbon_footprint'];
    $calculation_date = date("F j, Y", strtotime($latest_footprint['created_at']));
} else {
    $power_heating_lighting = "No data available";
    $transport = "No data available";
    $total_carbon_footprint = "No data available";
    $calculation_date = "N/A";
}

// Fetch the latest booking data for the logged-in user
$sql_booking = "SELECT booking_type, booking_date 
                FROM bookings 
                WHERE user_id = :user_id 
                ORDER BY booking_date DESC 
                LIMIT 1";
$stmt_booking = $pdo->prepare($sql_booking);
$stmt_booking->bindValue(':user_id', $user_id, PDO::PARAM_INT);
$stmt_booking->execute();
$latest_booking = $stmt_booking->fetch(PDO::FETCH_ASSOC);

// Set default values if no booking data is found
if ($latest_booking) {
    $booking_type = $latest_booking['booking_type'];
    $booking_date = date("F j, Y", strtotime($latest_booking['booking_date']));
} else {
    $booking_type = "No bookings available";
    $booking_date = "N/A";
}
// Set default values if no booking data is found
if ($latest_booking) {
    $booking_type = $latest_booking['booking_type'];
    $booking_date = date("F j, Y", strtotime($latest_booking['booking_date']));
} else {
    $booking_type = "No bookings available";
    $booking_date = "N/A";
}

// Fetch the latest installation data for the logged-in user
$sql_installation = "SELECT installation_type, installation_date 
                     FROM installations 
                     WHERE user_id = :user_id 
                     ORDER BY installation_date DESC 
                     LIMIT 1";
$stmt_installation = $pdo->prepare($sql_installation);
$stmt_installation->bindValue(':user_id', $user_id, PDO::PARAM_INT);
$stmt_installation->execute();
$latest_installation = $stmt_installation->fetch(PDO::FETCH_ASSOC);

// Set default values if no installation data is found
if ($latest_installation) {
    $installation_type = $latest_installation['installation_type'];
    $installation_date = date("F j, Y", strtotime($latest_installation['installation_date']));
} else {
    $installation_type = "No installations available";
    $installation_date = "N/A";
}

// Fetch all carbon footprint data for the logged-in user
$sql_graph = "SELECT created_at, power_heating_lighting, transport, total_carbon_footprint 
              FROM carbon_footprint 
              WHERE user_id = :user_id 
              ORDER BY created_at ASC";
$stmt_graph = $pdo->prepare($sql_graph);
$stmt_graph->bindValue(':user_id', $user_id, PDO::PARAM_INT);
$stmt_graph->execute();
$carbon_footprint_data = $stmt_graph->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard | Rolsa Technologies</title>

    <!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="css/swiper-bundle.min.css">

    <!-- CSS link -->
    <link rel="stylesheet" href="css/dash.css?v=<?php echo time(); ?>">
    
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

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

    <div class="sidebar">
        <header>
            <!-- Profile picture -->
            <div class="avatar-text">
                <div class="avatar-container">
                <img src="<?php echo isset($_SESSION['user_avatar']) ? htmlspecialchars($_SESSION['user_avatar'], ENT_QUOTES, 'UTF-8') : 'path/to/default-avatar.jpg'; ?>" alt="User Avatar" class="avatar">
                    <div class="text header-text">
                    <!-- Displaying users name -->
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
                <li><a href="calculate.php"> Calculate</a></li>
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
        <h4>Dashboard | Overview </h4>
        <div class="icons">
            <a href="#"><i class="fa-solid fa-globe"></i></a>
            <a id="toggleDarkMode" title="Toggle Dark Mode"><i class="fa-solid fa-circle-half-stroke"></i></a>
            <a href="home.php"><i class="fa-solid fa-right-from-bracket"></i></a>   
        </div>
    </section>

    <!-- Summary boxes on dashboard -->
    <section class="overview">
        <h1>Overview</h1>
        <div class="summary">
            <!-- Inserting specific information that the user has entered and showing them to the user -->
            <div class="card">
                <h2>Latest Carbon Footprint</h2>
                <p><strong>Power, Heating, Lighting:</strong> <?php echo htmlspecialchars($power_heating_lighting, ENT_QUOTES, 'UTF-8'); ?> kg CO<sub>2</sub></p>
                <p><strong>Transport:</strong> <?php echo htmlspecialchars($transport, ENT_QUOTES, 'UTF-8'); ?> kg CO<sub>2</sub></p>
                <p><strong>Total Carbon Footprint:</strong> <?php echo htmlspecialchars($total_carbon_footprint, ENT_QUOTES, 'UTF-8'); ?> kg CO<sub>2</sub></p>
                <p><strong>Calculation Date:</strong> <?php echo htmlspecialchars($calculation_date, ENT_QUOTES, 'UTF-8'); ?></p>
            </div>
            <div class="card">
                <h2>Latest Booking</h2>
                <p><strong>Type:</strong> <?php echo htmlspecialchars($booking_type, ENT_QUOTES, 'UTF-8'); ?></p>
                <p><strong>Date:</strong> <?php echo htmlspecialchars($booking_date, ENT_QUOTES, 'UTF-8'); ?></p>
            </div>
            <div class="card">
                <h2>Latest Installation</h2>
                <p><strong>Type:</strong> <?php echo htmlspecialchars($installation_type, ENT_QUOTES, 'UTF-8'); ?></p>
                <p><strong>Date:</strong> <?php echo htmlspecialchars($installation_date, ENT_QUOTES, 'UTF-8'); ?></p>
            </div>
        </div>
        
        <!-- dotted graph -->
        <div class="graph-container">
            <h2>Carbon Footprint Over Time</h2>
            <label for="timeframe">Select Timeframe:</label>
            <select id="timeframe">
                <option value="daily">Daily</option>
                <option value="monthly">Monthly</option>
                <option value="yearly">Yearly</option>
            </select>
            <canvas id="carbonFootprintGraph"></canvas>
        </div>

        <div class="graph-container">
            <h2>Energy Consumption by Appliance</h2>
            <canvas id="energyConsumptionGraph"></canvas>
        </div>
    </section>

    <section class="random-blog-content">
        <h2>Blog</h2>
        <div id="randomBlogContainer" class="random-blog-container">
            <!-- Dynamic content will be inserted here through the user of javascript -->
        </div>
    </section>


    <script>
    document.getElementById('avatar-input').addEventListener('change', function (event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                document.querySelector('.avatar').src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
    </script>

    <script src="js/blog.js"></script> 
    <script src="js/graph-energy.js"></script>
    <script src="js/graph.js"></script>
    <script src="js/dark-mode.js"></script>

    <script>
        // Pass carbon footprint data to JavaScript
        const carbonFootprintData = <?php echo json_encode($carbon_footprint_data, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>;
    </script>
</body>
</html>