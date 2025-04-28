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
    <title>Energy Calculation | Rolsa Technologies</title>

    <!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="css/swiper-bundle.min.css">

    <!-- CSS link -->
    <link rel="stylesheet" href="css/cal-energy.css?v=<?php echo time(); ?>">
    
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
        <h4>Dashboard | Calculate Energy Consumption</h4>
        <div class="icons">
            <a href="#"><i class="fa-solid fa-globe"></i></a>
            <a id="toggleDarkMode" title="Toggle Dark Mode"><i class="fa-solid fa-circle-half-stroke"></i></a>
            <a href="home.php"><i class="fa-solid fa-right-from-bracket"></i></a>   
        </div>
    </section>
            
    
    <section class="energy-calculator">
        <h2>Energy Consumption Calculator</h2>
        <form action="includes/calculate-energy.inc.php" method="post" class="energy-form">
            <!-- Appliance Selection -->
            <fieldset>
                <legend>Appliance Details</legend>
                <label for="appliance">
                    Select Appliance:
                    <select name="appliance" id="appliance" required onchange="updatePowerConsumption()">
                        <option value="Refrigerator">Refrigerator</option>
                        <option value="Washing Machine">Washing Machine</option>
                        <option value="Air Conditioner">Air Conditioner</option>
                        <option value="Television">Television</option>
                        <option value="Microwave">Microwave</option>
                    </select>
                </label>
                <label for="power_consumption">
                    Power Consumption (Watts):
                    <input type="number" name="power_consumption" id="power_consumption" placeholder="Enter power in watts" readonly required>
                </label>
                <label for="hours_per_day">
                    Hours of Use Per Day:
                    <input type="number" name="hours_per_day" id="hours_per_day" placeholder="Enter hours per day" required>
                </label>
            </fieldset>

            <button type="submit" class="btn">Calculate Energy Consumption</button>
        </form>
    </section>

    <script>
        // Predefined power consumption values for appliances
        const appliancePower = {
            "Refrigerator": 150, // Watts
            "Washing Machine": 500, // Watts
            "Air Conditioner": 2000, // Watts
            "Television": 100, // Watts
            "Microwave": 1200 // Watts
        };

        // Function to update the power consumption field based on selected appliance
        function updatePowerConsumption() {
            const applianceSelect = document.getElementById("appliance");
            const powerConsumptionInput = document.getElementById("power_consumption");
            const selectedAppliance = applianceSelect.value;

            // Set the power consumption value based on the selected appliance
            powerConsumptionInput.value = appliancePower[selectedAppliance] || "";
        }

        // Initialize the power consumption field when the page loads
        document.addEventListener("DOMContentLoaded", updatePowerConsumption);
    </script>

    <?php
    if (isset($_SESSION['energy_results'])) {
        $results = $_SESSION['energy_results'];
        echo "<section class='energy-results'>";
        echo "<h2>Energy Consumption Results</h2>";
        echo "<p>Appliance: " . htmlspecialchars($results['appliance'], ENT_QUOTES, 'UTF-8') . "</p>";
        echo "<p>Power Consumption: " . htmlspecialchars($results['power_consumption'], ENT_QUOTES, 'UTF-8') . " Watts</p>";
        echo "<p>Hours Per Day: " . htmlspecialchars($results['hours_per_day'], ENT_QUOTES, 'UTF-8') . "</p>";
        echo "<p>Total Energy Consumption: " . htmlspecialchars($results['energy_consumption'], ENT_QUOTES, 'UTF-8') . " kWh</p>";
        echo "</section>";

        // Clear results from session
        unset($_SESSION['energy_results']);
    }
    ?>
    
    

    <script src="js/dark-mode.js"></script>
    
</body>
</html>