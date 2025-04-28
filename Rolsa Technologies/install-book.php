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
    <title>Installation Booking | Rolsa Technologies</title>

    <!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="css/swiper-bundle.min.css">

    <!-- CSS link -->
    <link rel="stylesheet" href="css/consult.css?v=<?php echo time(); ?>">

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

        <!-- Sidebar -->
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
        <h4>Dashboard | Consultation Book </h4>
        <div class="icons">
            <a href="#"><i class="fa-solid fa-globe"></i></a>
            <a id="toggleDarkMode" title="Toggle Dark Mode"><i class="fa-solid fa-circle-half-stroke"></i></a>
            <a href="home.html"><i class="fa-solid fa-right-from-bracket"></i></a>   
        </div>
    </section>

    <!-- checking for errors and displaying them if found -->

    <?php if (isset($_SESSION['errors'])): ?>
        <div class="error-messages">
            <ul>
                <?php foreach ($_SESSION['errors'] as $error): ?>
                    <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php unset($_SESSION['errors']); ?>
    <?php endif; ?>

    <!-- Booking form stages -->
    <section class="booking-form">
        <h1>Book Your Solar Panel Installation</h1>
        <div class="form-container">
            <form id="installationBookingForm" method="POST" action="includes/process_installation_booking.php">
                <!-- Stage 1: Details -->
                <div class="form-stage" id="install-stage-1" style="display: block;">
                    <h2>Step 1: Your Details</h2>
                    <label for="install-name">Full Name:</label>
                    <input type="text" id="install-name" name="name" required>
                    
                    <label for="install-email">Email:</label>
                    <input type="email" id="install-email" name="email" required>
                    
                    <label for="install-phone">Phone Number:</label>
                    <input type="text" id="install-phone" name="phone" required>
                    
                    <button type="button" class="next-button" onclick="nextInstallStage(2)">Next</button>
                </div>

                <!-- Stage 2: Scheduling -->
                <div class="form-stage" id="install-stage-2" style="display: none;">
                    <h2>Step 2: Schedule Your Installation</h2>
                    <label for="install-date">Preferred Date:</label>
                    <input type="date" id="install-date" name="date" required>

                    <label for="install-time">Preferred Time:</label>
                    <select id="install-time" name="time" required>
                        <option value="">Select a time</option>
                        <option value="09:00">09:00 AM</option>
                        <option value="10:00">10:00 AM</option>
                        <option value="11:00">11:00 AM</option>
                        <option value="12:00">12:00 PM</option>
                        <option value="13:00">01:00 PM</option>
                        <option value="14:00">02:00 PM</option>
                        <option value="15:00">03:00 PM</option>
                        <option value="16:00">04:00 PM</option>
                        <option value="17:00">05:00 PM</option>
                    </select>

                    <button type="button" class="prev-button" onclick="prevInstallStage(1)">Back</button>
                    <button type="button" class="next-button" onclick="nextInstallStage(3)">Next</button>
                </div>

                <!-- Stage 3: Payment -->
                <div class="form-stage" id="install-stage-3" style="display: none;">
                    <h2>Step 3: Payment</h2>
                    <label for="install-card-number">Card Number:</label>
                    <input type="text" id="install-card-number" name="card_number" required>
                    
                    <label for="install-expiry-date">Expiry Date:</label>
                    <input type="text" id="install-expiry-date" name="expiry_date" placeholder="MM/YY" required>
                    
                    <label for="install-cvv">CVV:</label>
                    <input type="text" id="install-cvv" name="cvv" required>
                    
                    <button type="button" class="prev-button" onclick="prevInstallStage(2)">Back</button>
                    <button type="submit" class="submit-button">Submit</button>
                </div>
            </form>
        </div>
    </section>

    <!-- JavaScript -->
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

    <!-- Link to JavaScripts -->
    <script src="js/install.js"></script>
    <script src="js/dark-mode.js"></script>
    
</body>
</html>