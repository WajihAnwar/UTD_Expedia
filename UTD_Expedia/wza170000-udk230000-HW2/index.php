<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Assignment 2</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <!-- header -->
    <header class="row">
        <div class="header-data">
            <span>CS 6314</span><br>
            <span>Assignment - 3</span>
            <br><span>UTD Expedia </span>
        </div>
        <div id="datetime"></div>
        <?php
            if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
                echo "<div>Welcome, " . $_SESSION['firstname'] . " " . $_SESSION['lastname'] . "</div>";
                echo '<a href="logout.php" style="margin-left: 10px; text-decoration: none; color: #007BFF;">Sign Out</a>';
            }
            ?>


    </header>

    <!-- navigation bar-->
    <div class="row navigations">
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="stays.php">Stays</a></li>
                <li><a href="flights.php">Flights</a></li>
                <li><a href="cars.php">Cars</a></li>
                <li><a href="cruises.php">Cruises</a></li>
                <li><a href="contactUs.php">Contact Us</a></li>
                <li><a href="cart.php">Cart</a></li>
                <li><a href="register.php">Register</a></li>
                <li><a href="login.php">Login</a></li>
                <li><a href="my-account.php">My Account</a></li>
            </ul>
        </nav>
    </div>

    <!-- side and main content-->
    <div class="row container">
        <section class="sidesection">
            <h2>Side Content</h2>
            <h4>Customization Controls :</h4>
            <div>
                <label for="fontsize">Font Size: </label>
                <input type="range" id="fontsize" min="5" max="50" value="25">
                <span id="fontsizeval">25px</span>
            </div>
            <div>
                <label for="bgColor">Background Color: </label>
                <input type="color" id="bgColor" value="#ffffff">
            </div>
        </section>
        <section class="mainsection">
            <h2>Welcome to UTD Expedia</h2>
            <p>Welcome to <strong>UTD Expedia</strong>, A platform developed by Wajih Anwar and Utsav Kanani to help UTD Students travel across the Globe</p>
            <p>Students can book all these different activities below</p>
            <ul>
                <li><strong>Hotels</strong>: Find and reserve the perfect hotel for your destination</li>
                <li><strong>Flights</strong>: Browse flights and book the best deals for your journey.</li>
                <li><strong>Car Rentals</strong>: Convenient and <strong> Cheap</strong> car rental options.</li>
                <li><strong>Cruises</strong>: Go on Amazing Cruises through our links</li>
            </ul>
            <p>Need help? Our <strong>Contact Us</strong> page connects you directly with our support team to answer all your questions. </p>
        </section>
    </div>



    <!-- footer -->
    <footer class="row">
        <div class="footer-content">
            <div class="developer-details">
                <h3>Developer Details</h3>
                <span>First Name: Wajih</span><br>
                <span>Last Name: Anwar</span><br>
                <span>Net ID: WZA170000</span><br>
                <span>Section Number: 6314.002</span>
            </div>
            <div class="partner-details">
                <h4>Partner Details</h4>
                <span>First Name: Utsav Dushyant</span><br>
                <span>Last Name: Kanani</span><br>
                <span>Net ID: udk230000</span><br>
                <span>Section Number: 6314.002</span>
            </div>
        

 <!-- javascript using Jquery -->
 <script>
  $(document).ready(function () {

    // Update date and time
    setInterval(function () {
        const now = new Date();
        const currentDateTime = now.toLocaleString();
        $('#datetime').text(currentDateTime);
    }, 1000);

    // For Font Size
    $('#fontsize').on('input', function () {
        const fontSize = $(this).val() + 'px';
        $('.mainsection').css('font-size', fontSize);
        $('#fontsizeval').text(fontSize);
    });

    // For background color
    $('#bgColor').on('input', function () {
        const bgColor = $(this).val();
        $('body').css('background-color', bgColor);
    });
});

</script>
</body>
</html>