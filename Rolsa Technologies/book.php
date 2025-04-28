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
    <title>Book | Rolsa Technologies</title>

    <!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="css/swiper-bundle.min.css">

    <!-- CSS link -->
    <link rel="stylesheet" href="css/book.css?v=<?php echo time(); ?>">

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
                <li><a href="#"> Book</a></li>
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
        <h4>Dashboard | Book </h4>
        <div class="icons">
            <a href="#"><i class="fa-solid fa-globe"></i></a>
            <a id="toggleDarkMode" title="Toggle Dark Mode"><i class="fa-solid fa-circle-half-stroke"></i></a>
            <a href="home.php"><i class="fa-solid fa-right-from-bracket"></i></a>   
        </div>
    </section>

    <section class="Consultation">
        <h2>Not Sure About Something?</h2>
        <p>No worries, you can book a consultation and ask away...</p>
        <a href="consult-book.php" class="consult-container">
            <h1>Click Here!</h1>
        </a>
    </section>

    <section class="Installation">
        <h2>Ready to reduce your carbon emission?</h2>
        <p>Book your solar panel now and become Eco-friendly</p>
        <a href="install-book.php" class="install-container">
            <h1>Click Here!</h1>
        </a>
    </section>

    <?php
    require_once "includes/dbh.inc.php";

    // Check if the user is logged in
    if (!isset($_SESSION['user_id'])) {
        header("Location: account.php"); // Redirect to login page if not logged in
        exit();
    }

    $user_id = $_SESSION['user_id']; // Get the logged-in user's ID
    ?>

    <section class="latest-booking">
        <h1>Your Latest Booking</h1>
        <p>Be in control and cancel anytime</p>
        <div class="booked-container">
            <?php
            // Fetch the latest booking from the database
            $sql = "SELECT id, booking_date, service_name FROM bookings WHERE user_id = :user_id ORDER BY booking_date DESC LIMIT 1";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                echo '<div class="booking-details">';
                echo '<p><strong>Service:</strong> ' . htmlspecialchars($result['service_name'], ENT_QUOTES, 'UTF-8') . '</p>';
                echo '<p><strong>Date:</strong> ' . htmlspecialchars($result['booking_date'], ENT_QUOTES, 'UTF-8') . '</p>';
                echo '<form method="POST" action="includes/cancel_booking.php">';
                echo '<input type="hidden" name="booking_id" value="' . htmlspecialchars($result['id'], ENT_QUOTES, 'UTF-8') . '">';
                echo '<button type="submit" class="cancel-button">Cancel Booking</button>';
                echo '</form>';
                echo '</div>';
            } else {
                echo '<p>No bookings found.</p>';
            }
            ?>
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

    <script src="js/dark-mode.js"></script>
    
</body>
</html>