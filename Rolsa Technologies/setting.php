<?php
session_start();
if (isset($_POST['dark_mode'])) {
    $_SESSION['dark_mode'] = $_POST['dark_mode'] === 'enabled' ? 'enabled' : 'disabled';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings | Rolsa Technologies</title>

    <!-- CSS link -->
    <link rel="stylesheet" href="css/style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="css/setting.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="css/darkmode.css?v=<?php echo time(); ?>">kmode.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome CDN link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" 
    integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" 
    crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>
<body class="<?php echo isset($_SESSION['dark_mode']) && $_SESSION['dark_mode'] === 'enabled' ? 'dark-mode' : ''; ?>">
    
    <!-- Navigation bar + Hero section -->
    <section class="hero-section" id="home">
        <div class="navbar">
            <a href="home.html" class="logo"><i class="fa-solid fa-shoe-prints fa-bounce" style="color: #20511f;"></i>Rolsa Technologies</a>
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
    
    <form class="form" id="form" method="POST" action="setting.php">
        <div class="form-title">
            <h1>Settings</h1>
        </div>
        <nav>
            <ul>
                <li><a href="setting.html" class="active-border">Accessibility</a></li>
                <li><a href="#">In-development</a></li>
                <li><a href="#">In-development</a></li>
                <li><a href="#">In-development</a></li>
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
            <label for="dark-mode">
                <span>Dark Mode</span>
                <div class="toggle-container" id="toggleDarkMode">
                    <div class="toggle-button"></div>
                </div>
            </label>
        </div>

        <div class="line"></div>

        <div class="feature">
            <label for="text-to-speech">
                <span>Text-to-speech</span>
                <div class="feature-btn">
                    <a href="#">
                        <button>on</button>
                    </a>
                    <a href="#">
                        <button>off</button>
                    </a>
                </div>
            </label>
        </div>

        <div class="line"></div>

        <div class="feature">
            <label for="text-size">
                <span>Text Size</span>
                <select name="text-size" id="text-size">
                    <option value="small">Small</option>
                    <option value="medium">Medium</option>
                    <option value="large">Large</option>
                </select>
            </label>
        </div>

        <div class="line"></div>

        <div class="feature">
            <label for="language">
                <span>Language</span>
                <select name="language" id="language">
                    <option value="english">English</option>
                    <option value="spanish">Spanish</option>
                    <option value="french">French</option>
                </select>
            </label>
        </div>


    </form>

    <!-- Footer -->
    
    <footer class="footer">
        <a href="#" class="footer-logo"><i class="fa-solid fa-shoe-prints fa-bounce" style="color: #20511f;"></i>Rolsa Technologies</a>
          
          <div class="footer-container">
              <div class="footer-content">
                  <h3>Quick Links</h3>
                  <ul>
                      <li><a href="home.php">Home</a></li>
                      <li><a href="about.html">About Us</a></li>
                      <li><a href="product.html">Product</a></li>
                      <li><a href="account.php">Join Us</a></li>
                      <li><a href="home.html#questions">FAQ</a></li>
                  </ul>
              </div>
  
              <div class="footer-content">
                  <h3>Accessibility</h3>
                  <ul>
                      <li><a href="cookies.html">Cookies</a></li>
                      <li><a href="#form">Settings</a></li>
                      <li><a href="T&C.php">Terms & Conditions</a></li>
                  </ul>
              </div>
  
              <div class="footer-content">
                  <h3>Social Links</h3>
                  <ul class="social">
                      <li><a href="#"><i class="fa-brands fa-facebook"></i></a></li>
                      <li><a href="#"><i class="fa-brands fa-twitter"></i></a></li>
                      <li><a href="#"><i class="fa-brands fa-instagram"></i></a></li>
                      <li><a href="#"><i class="fa-brands fa-linkedin-in"></i></a></li>
                  </ul>
              </div>
          </div>
  
          <div class="footer-bottom">
              <p>@ 2025 Rolsa Technologies. All rights reserved.</p>
          </div>
    </footer>
      <!-- End -->

    <!-- JavaScript link -->
    <script src="js/dark-mode.js?v=<?php echo time(); ?>"></script>
</body>
</html>