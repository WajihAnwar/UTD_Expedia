<?php
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Contact Us </title>
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
                </div><br>
            </section>
            <section class="mainsection">
                <h2>Ready to Book a Flight </h2>
                <p>This is where you can contact us regarding your enquires </p>

                <form id="contactform" onsubmit="return validateForm(event)">
                    <label for="firstname">First name:</label><br>
                    <input type="text" id="firstname" name="firstname" style="width: 300px;"><br>
                    
                    <label for="lastname">Last name:</label><br>
                    <input type="text" id="lastname" name="lastname" style="width: 300px;"><br>
                    
                    <label for="phone">Phone number:</label><br>
                    <input type="text" id="phone" name="phone" placeholder="(ddd) ddd-dddd"><br>
                    
                    <label>Gender:</label><br>
                    <label><input type="radio" name="gender" value="male"> Male</label><br>
                    <label><input type="radio" name="gender" value="female"> Female</label><br>
                    
                    <label for="email">Email Address:</label><br>
                    <input type="email" id="email" name="email"><br>
                    
                    <label for="comment">Comment:</label><br>
                    <textarea id="comment" name="comment" rows="4" cols="50"></textarea><br>
                    
                    <button type="submit" value="submit">Submit</button><br>
                </form>
                <div id="displayContact"></div>
                
            </div>
        </section>


                
            </section>
        </div>

        <!-- footer -->
        <footer class="row">
            <div>
                <h3>Developers Details</h3>
                <span>First Name: Wajih </span><br>
                <span>Last Name: Anwar</span><br>
                <span>Net ID: WZA170000</span><br>
                <span>Section Number: 6314.002</span><br>
                <h4>Partner Details</h4>
                <span>First Name: Utsav Dushyant</span><br>
                <span>Last Name: Kanani</span><br>
                <span>Net ID: udk230000</span><br>
                <span>Section Number: 6314.002</span><br>
            </div>
        </footer>

        <!-- javascript -->
        <script>


// Call the function to fetch session information on page load
$(document).ready(function () {
    fetchSessionInfo();
});

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
    function validateForm(event){
    event.preventDefault();
    let firstname = document.getElementById("firstname").value.trim();
    let lastname = document.getElementById("lastname").value.trim();
    let phone = document.getElementById("phone").value;
    let email = document.getElementById("email").value.trim();
    let gender = document.querySelector('input[name="gender"]:checked');
    let comment = document.getElementById("comment").value.trim();

    let isValid = true;

    let namePattern = /^[A-Za-z]*$/;
    let phonePattern = /^\(\d{3}\)\s?\d{3}-\d{4}$/;
    let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (!firstname && !lastname && !phone && !email && !gender && !comment) {
        alert("All fields are empty. Please fill in the form.");
        return false;
    }

    // Validate first name
    if(!namePattern.test(firstname)){
        isValid = false;
        alert("First name should contain only letters.");
    } else if (!/^[A-Z]/.test(firstname)) {
        isValid = false;
        alert("First name must start with an uppercase letter.");
    }

    // Validate last name
    if(!namePattern.test(lastname)){
        isValid = false;
        alert("Last name should contain only letters.");
    } else if (!/^[A-Z]/.test(lastname)) {
        isValid = false;
        alert("Last name must start with an uppercase letter.");
    }

    // Validate email
    if(!emailPattern.test(email)){
        isValid = false;
        alert("Email must include @ and .");
    }

    // Validate phone number
    if (!phonePattern.test(phone)) {
        isValid = false;
        alert("Phone number must be in the format (ddd) ddd-dddd.");
    }

    // Validate gender
    if (!gender) {
        isValid = false;
        alert("Gender must be selected.");
    }

    // Validate comment length
    if (comment.length < 10) {
        isValid = false;
        alert("Comment must be at least 10 characters long.");
    }

    if(isValid){
        let displayContactElement = document.getElementById('displayContact');
        displayContactElement.innerHTML = `<h4>Submitted Contact:</h4><br>
        First Name: ${firstname}<br>
        Last Name: ${lastname}<br>
        Gender: ${gender.value}<br>
        Email: ${email}<br>
        Phone: ${phone}<br>
        Comment: ${comment}<br>`;

        // AJAX request
        const xhtpp = new XMLHttpRequest();
        xhtpp.open('POST', 'contact.php', true);
        xhtpp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhtpp.onload = function() {
            if (xhtpp.status === 200) {
                alert(xhtpp.responseText);
            } else {
                alert('Error: ' + xhtpp.status);
            }
        };
        xhtpp.send(`firstname=${encodeURIComponent(firstname)}&lastname=${encodeURIComponent(lastname)}&phone=${encodeURIComponent(phone)}&email=${encodeURIComponent(email)}&gender=${encodeURIComponent(gender.value)}&comment=${encodeURIComponent(comment)}`);
    }

    return false;
}

 
        </script>
    </body>
</html>