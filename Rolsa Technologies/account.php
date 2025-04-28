<?php
require_once 'includes/config_session.inc.php';
require_once 'includes/signup_view.inc.php';
require_once 'includes/login_view.inc.php';

if (!isset($_SESSION['dark_mode'])) {
  $_SESSION['dark_mode'] = 'disabled'; // Default to light mode
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Portal | Rolsa Technologies</title>

    <!-- CSS link -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/account.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="css/darkmode.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome CDN link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" 
    integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" 
    crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script>
    src="https://kit.fontawesome.com/64d58efce2.js"
    crossorigin="anonymous"
    </script>

    <!-- Boxicons CSS -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

</head>
<body class="<?php echo isset($_SESSION['dark_mode']) && $_SESSION['dark_mode'] === 'enabled' ? 'dark-mode' : ''; ?>">
    
    <!-- Navigation bar + Hero section -->
    <section class="hero-section">
        <div class="navbar">
            <a href="home.php" class="logo"><i class="fa-solid fa-shoe-prints fa-bounce" style="color: #20511f;"></i>Rolsa Technologies</a>
            <nav>
                <ul>
                    <li><a href="home.php">Home</a></li>
                    <li><a href="about.html">About Us</a></li>
                    <li><a href="product.html">Product</a></li>
                </ul>
            </nav>

            <div class="icons">
                <!-- settings icon -->
                <a href="setting.php"><i class="fa-solid fa-gear"></i></a>

                <!-- account icon -->
                <a href="account.php"><i class="fa-solid fa-user"></i></a>
            </div>
        </div>
    </section>

    <!-- End -->

    
    <!-- Account section -->

    <div class="container">
        <div class="forms-container">
          <div class="signin-signup">
            <!-- Login Form -->
            <form action="includes/login.inc.php" method="post" class="sign-in-form">
              <h2 class="title">Login</h2>
              <!-- User Input -->
              <div class="input-field">
                <i class="fas fa-envelope"></i>
                <input type="text" name="email" placeholder="Email" maxlength="50" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}" title="Enter a valid email address"/>
              </div>
              <div class="input-field">
                <i class="fas fa-lock"></i>
                <input type="password" name="pwd" placeholder="Password" minlength="8" maxlength="20" title="Password must be between 8 and 20 characters"/>
              </div>
              <input type="submit" value="Login" class="btn solid" />
            </form>

            <?php
            check_login_errors();
            ?>
            <!-- Display Login Errors -->
            <?php
            if (isset($_SESSION["errors_login"])) {
                echo '<div class="error-container">';
                foreach ($_SESSION["errors_login"] as $error) {
                    echo '<div class="error-message">' . htmlspecialchars($error, ENT_QUOTES, 'UTF-8') . '</div>';
                }
                unset($_SESSION["errors_login"]); // Clear errors after displaying
                echo '</div>';
            }
            ?>


            <!-- Sign-Up Form -->
            <form action="includes/signup.inc.php" method="post" class="sign-up-form">
              <h2 class="title">Register</h2>

              <!-- Display Sign-Up Errors -->
              <?php
              if (isset($_SESSION["errors_signup"])) {
                  echo '<div class="error-container">';
                  foreach ($_SESSION["errors_signup"] as $error) {
                      echo '<div class="error-message">' . htmlspecialchars($error) . '</div>';
                  }
                  unset($_SESSION["errors_signup"]); // Clear errors after displaying
                  echo '</div>';
              }
              ?>

              <!-- User Input -->
              <div class="input-field">
                <i class="fas fa-user"></i>
                <input type="text" name="first_name" placeholder="First Name" maxlength="30" pattern="[A-Za-z]+" title="First name should only contain letters"/>
              </div>
              <div class="input-field">
                <i class="fas fa-user"></i>
                <input type="text" name="last_name" placeholder="Last Name" maxlength="30" pattern="[A-Za-z]+" title="Last name should only contain letters"/>
              </div>
              <div class="input-field">
                <i class="fas fa-envelope"></i>
                <input type="text" name="email" placeholder="Email" maxlength="50" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}" title="Enter a valid email address"/>
              </div>
              <div class="input-field">
                <i class="fas fa-lock"></i>
                <input type="password" name="pwd" placeholder="Password" minlength="8" maxlength="20" title="Password must be between 8 and 20 characters"/>
              </div>
              <input type="submit" class="btn" value="Sign up" />
            </form>
          </div>
        </div>

  
        <div class="panels-container">
          <div class="panel left-panel">
            <div class="content">
              <h3>New here ?</h3>
              <p>
                Lorem ipsum, dolor sit amet consectetur adipisicing elit. Debitis,
                ex ratione. Aliquid!
              </p>
              <button class="btn transparent" id="sign-up-btn">
                Register
              </button>
            </div>
            <img src="images/log.svg" class="image" alt="" />
          </div>
          <div class="panel right-panel">
            <div class="content">
              <h3>One of us ?</h3>
              <p>
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Nostrum
                laboriosam ad deleniti.
              </p>
              <button class="btn transparent" id="sign-in-btn">
                Login
              </button>
            </div>
            <img src="images/register.svg" class="image" alt="" />
          </div>
        </div>
      </div>

      <?php
      check_signup_errors();
      
      ?>
  
      <script src="js/account.js"></script>
      <script src="js/dark-mode.js?v=<?php echo time(); ?>"></script>
      
      <script>
      // Check if the active form is set to "signup"
      <?php if (isset($_SESSION["active_form"]) && $_SESSION["active_form"] === "signup"): ?>
          document.addEventListener("DOMContentLoaded", function () {
              const signUpBtn = document.getElementById("sign-up-btn");
              if (signUpBtn) {
                  signUpBtn.click(); // Simulate a click to switch to the sign-up form
              }
          });
          <?php unset($_SESSION["active_form"]); // Clear the flag after use ?>
      <?php endif; ?>
      </script>

</body>
</html>