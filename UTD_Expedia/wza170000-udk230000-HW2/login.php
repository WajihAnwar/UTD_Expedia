<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login - Assignment #4</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- header -->
    <header class="row">
        <div class="header-data">
            <span>CS 6314</span><br>
            <span>Assignment #4</span>
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

    <!-- form -->
    <div class="row container">
        <section class="sidesection">
            <h2>Side Content</h2>
            <h4>Customization Controls :</h4>
            <div>
                <label for="fontsize">Font Size: </label>
                <input type="range" id="fontsize" min="5" max="50" value="16">
                <span id="fontsizeval">16px</span>
            </div>
            <div>
                <label for="bgColor">Background Color: </label>
                <input type="color" id="bgColor" value="#ffffff">
            </div><br>
        </section>
        <section class="mainsection">
            <h2>Login</h2>
            <?php
            if (isset($_GET['error']) && $_GET['error'] == 1) {
                echo "<p style='color:red;'>Invalid phone number or password.</p>";
            }
            ?>
            <form action="login_process.php" method="post">
                <label for="phone">Phone Number:</label><br>
                <input type="text" id="phone" name="phone" required><br><br>
                <label for="password">Password:</label><br>
                <input type="password" id="password" name="password" required><br><br>
                <button type="submit">Login</button>
            </form>
        </section>
    </div>

    <!-- footer -->
    <footer class="row">
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
    </footer>

    <!-- javascript -->
    <script>
        function showDateAndTime(){
            const datetime = new Date();
            document.getElementById("datetime").innerHTML = datetime.toLocaleString();
        }
        setInterval(showDateAndTime, 1000);
        showDateAndTime();


        function updateDateTime() {
        const now = new Date();
        const currentDateTime = now.toLocaleString();
        document.querySelector('#datetime').textContent = currentDateTime;
    }

    function updateFontSize() {
        const fontSize = document.getElementById('fontsize').value + 'px';
        document.querySelector('.mainsection').style.fontSize = fontSize;
        document.querySelector('#fontsizeval').textContent = fontSize;
    }

    function updateBackgroundColor() {
        const bgColor = document.getElementById('bgColor').value;
        document.querySelector('body').style.backgroundColor = bgColor;
    }

    // Call the update functions on change
    document.getElementById('fontsize').addEventListener('input', updateFontSize);
    document.getElementById('bgColor').addEventListener('input', updateBackgroundColor);

    // Update the date and time every second
    setInterval(updateDateTime, 1000);

    // Initialize
    updateFontSize();
    updateBackgroundColor();

    </script>
</body>
</html>
