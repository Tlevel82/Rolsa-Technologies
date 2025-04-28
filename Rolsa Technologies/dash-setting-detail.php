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
    <title>Settings | Rolsa Technologies</title>

    <!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="css/swiper-bundle.min.css">

    <!-- CSS link -->
    <link rel="stylesheet" href="css/setting-dash-detail.css?v=<?php echo time(); ?>">
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
                    <img src="path/to/default-avatar.jpg" alt="User Avatar" class="avatar">
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
                <li><a href="#"> Settings</a></li>
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
        <h4>Dashboard | Settings </h4>
        <div class="icons">
            <a href="#"><i class="fa-solid fa-globe"></i></a>
            <a id="toggleDarkMode" title="Toggle Dark Mode"><i class="fa-solid fa-circle-half-stroke"></i></a>
            <a href="home.php"><i class="fa-solid fa-right-from-bracket"></i></a>   
        </div>
    </section>

    <section class="form" id="form">
        <div class="form-title">
            <h1>Settings</h1>
        </div>
        <nav>
            <ul>
                <li><a href="#" class="active-border">My Details</a></li>
                <li><a href="dash-setting-access.php">Accessibility</a></li>
                <li><a href="#">In-development</a></li>
                <li><a href="#">In-development</a></li>
                <li><a href="#">In-development</a></li>
            </ul>
        </nav>

        <div class="form-intro">
            <div class="details">
                <h2>Accessibility Features</h2>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Expedita, earum.</p>
            </div>
        </div>

        <div class="line"></div>

        <div class="feature">
            <label for="name">
                <span>Name</span>
                <div class="feature-input">
                    <input type="text" placeholder=<?php echo htmlspecialchars($first_name, ENT_QUOTES, 'UTF-8'); ?>>
                    <input type="text" placeholder=<?php echo htmlspecialchars($last_name, ENT_QUOTES, 'UTF-8'); ?>>
                </div>
            </label>
        </div>

        <div class="line"></div>

        <div class="feature">
            <label for="email" class="email">
                <span>Email</span>
                <div class="feature-input">
                    <input type="text" placeholder=<?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?>>
                </div>
            </label>
        </div>

        <div class="line"></div>

        <div class="feature">
            <label for="photo" class="photo">
                <span>Your Photo</span>
                <div class="feature-input">
                    <input type="file" id="avatar-input" style="display: none;">
                    <button class="change-avatar-btn" onclick="document.getElementById('avatar-input').click();">Change Avatar</button>
                </div>
            </label>
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