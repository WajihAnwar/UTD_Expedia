<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <title>Assignment #4</title>
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
            <div class="registrationform">
                <h3>Register</h3>
                <form id="registerform" onsubmit="return validateRegisterForm(event)">
                    <label for="phone">Phone number:</label><br>
                    <input type="text" id="phone" name="phone" placeholder="ddd-ddd-dddd" required><br>

                    <label for="password">Password:</label><br>
                    <input type="password" id="password" name="password" required><br>

                    <label for="confirmPassword">Confirm Password:</label><br>
                    <input type="password" id="confirmPassword" name="confirmPassword" required><br>

                    <label for="firstname">First Name:</label><br>
                    <input type="text" id="firstname" name="firstname" required><br>

                    <label for="lastname">Last Name:</label><br>
                    <input type="text" id="lastname" name="lastname" required><br>

                    <label for="dob">Date of Birth:</label><br>
                    <input type="text" id="dob" name="dob" placeholder="MM-DD-YYYY" required><br>

                    <label for="email">Email:</label><br>
                    <input type="email" id="email" name="email" required><br>
                    >
                    <label>Gender:</label><br>
                    <label><input type="radio" name="gender" value="male"> Male</label><br>
                    <label><input type="radio" name="gender" value="female"> Female</label><br>

                    <button type="submit" value="submit">Register</button><br>
                </form>
            </div>
            <div id="displayRegister"></div>
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
        </div>
    </footer>

    <!-- javascript -->
    <script>
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


    function validateRegisterForm(event) {
        event.preventDefault();

        let phone = document.getElementById("phone").value.trim();
        let password = document.getElementById("password").value.trim();
        let confirmPassword = document.getElementById("confirmPassword").value.trim();
        let firstname = document.getElementById("firstname").value.trim();
        let lastname = document.getElementById("lastname").value.trim();
        let dob = document.getElementById("dob").value.trim();
        let email = document.getElementById("email").value.trim();

        let isValid = true;
        let errorMessages = [];

        // Regular expressions
        let phonePattern = /^\d{3}-\d{3}-\d{4}$/;
        let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        let dobPattern = /^\d{2}-\d{2}-\d{4}$/;

        // Phone validation
        if (!phonePattern.test(phone)) {
            isValid = false;
            errorMessages.push("Phone number must be in the format ddd-ddd-dddd.");
        }

        // Password validation
        if (password.length < 8) {
            isValid = false;
            errorMessages.push("Password must be at least 8 characters long.");
        }

        if (password !== confirmPassword) {
            isValid = false;
            errorMessages.push("Passwords do not match.");
        }

        // Date of birth validation
        if (!dobPattern.test(dob)) {
            isValid = false;
            errorMessages.push("Date of birth must be in the format MM-DD-YYYY.");
        }

        // Email validation
        if (!emailPattern.test(email) || !email.includes(".com")) {
            isValid = false;
            errorMessages.push("Email must include '@' and end with '.com'.");
        }

        // Display all errors at once
        if (!isValid) {
            alert(errorMessages.join("\n"));
            return false;
        }

        // Display success message and form data
        let displayRegisterElement = document.getElementById('displayRegister');
        let gender = document.querySelector('input[name="gender"]:checked');
        displayRegisterElement.innerHTML = `<h4>Submitted Registration:</h4><br>
    Phone: ${phone}<br>
    First Name: ${firstname}<br>
    Last Name: ${lastname}<br>
    Date of Birth: ${dob}<br>
    Email: ${email}<br>
    Gender: ${gender ? gender.value : "Not specified"}<br>`;

        // Send data via AJAX
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'registerUser.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status === 200) {
                alert(xhr.responseText);
            } else {
                alert('Error: ' + xhr.status);
            }
        };
        xhr.send(
            `phone=${encodeURIComponent(phone)}&password=${encodeURIComponent(password)}&firstname=${encodeURIComponent(firstname)}&lastname=${encodeURIComponent(lastname)}&dob=${encodeURIComponent(dob)}&email=${encodeURIComponent(email)}&gender=${encodeURIComponent(gender ? gender.value : "")}`
            );

        return false;
    }
    </script>
</body>

</html>