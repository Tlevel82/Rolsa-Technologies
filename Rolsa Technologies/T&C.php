!<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terms and Conditions | Rolsa Technologies</title>

    <!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="css/swiper-bundle.min.css">

    <!-- CSS link -->
    <link rel="stylesheet" href="css/term&Conditions.css?v=<?php echo time(); ?>">
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

    <!-- Navigation bar -->
    <section class="hero-section">
        <div class="navbar">
            <a href="home.html" class="logo"><i class="fa-solid fa-shoe-prints fa-bounce" style="color: #20511f;"></i>Rolsa Technologies</a>
            <nav>
                <ul>
                    <li><a href="home.html">Home</a></li>
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

    <!-- Terms and Conditions Section -->
    <section class="terms-section">
        <div class="container">
            <h1>Terms and Conditions</h1>
            <p>
                By accessing or using this website, you agree to the terms and conditions outlined here. 
                Please read them carefully before proceeding.
            </p>
            <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero. 
                Sed cursus ante dapibus diam. Sed nisi. Nulla quis sem at nibh elementum imperdiet.
            </p>
            <p>
                If you do not agree to these terms, please do not use our website or services.
            </p>

            <!-- Terms and Conditions Form -->
            <form id="termsForm">
                <div class="form-group">
                    <input type="checkbox" id="acceptTerms" name="acceptTerms" required>
                    <label for="acceptTerms">I agree to the Terms and Conditions</label>
                </div>
                <button type="submit" id="submitBtn" class="btn">Submit</button>
            </form>
        </div>
    </section>

    


    <!-- Script -->
    <script src="js/js.js"></script>
    <script src="js/term.js"></script>

    <!-- Initialize FAQ -->
    <script>
        var acc = document.getElementsByClassName("accordion");
        var i;
  
        for (i = 0; i < acc.length; i++) {
          acc[i].addEventListener("click", function () {
            this.classList.toggle("active");
            this.parentElement.classList.toggle("active");
  
            var pannel = this.nextElementSibling;
  
            if (pannel.style.display === "block") {
              pannel.style.display = "none";
            } else {
              pannel.style.display = "block";
            }
          });
        }
    </script>
    
    <!-- JavaScript link -->
    <script src="js/dark-mode.js"></script>
</body>
</html>