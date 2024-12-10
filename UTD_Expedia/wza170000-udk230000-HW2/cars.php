<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Assignment 3</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- header -->
    <header class="row">
        <div class="header-data">
            <span>CS 6314</span><br>
            <span>Assignment - 3</span><br>
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
            <h2>Book a Car</h2>
            <form id="carform" onsubmit="return validateCarForm(event)">
                <label for="city">Which City are you picking up from:</label><br>
                <input list="citySuggestions" id="city" name="city"><br>
                <datalist id="citySuggestions"></datalist>


                <label for ="car">Which type of car do you want</label><br>
                <select name = "cars" id = "cars">
                    <option name = "economy">Economy </option>
                    <option name = "SUV">SUV </option>
                    <option name = "Compact">Compact </option>
                    <option name = "Midsize">Midsize</option>
                </select><br>




                
                <label for="checkinDay">Check-In Date:</label><br>
                <input type="date" id="checkinDay" name="checkinDay"><br>
                <label for="checkoutDay">Check-Out Date:</label><br>
                <input type="date" id="checkoutDay" name="checkoutDay"><br>

                <button type="submit">Submit</button>
            </form>
            <div id="staysinfo" class="hide">
                <p id="staysinfodetail"></p>
            </div>
          
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
        

 <!-- javascript -->
 <script>
    const validCities = [
        "Austin ", 
        "Dallas ", 
        "Houston ", 
        "San Antonio ", 
        "El Paso ", 
        "Lubbock ", 
        "Corpus Christi ", 
        "Midland ", 
        "Los Angeles ", 
        "San Francisco ", 
        "San Diego ", 
        "San Jose ", 
        "Sacramento ", 
        "Oakland ", 
        "Burbank ", 
        "Long Beach ", 
        "Santa Ana ", 
        "Fresno ", 
        "Palm Springs "
    ];

    // Function to filter and display city suggestions
    function filterCities() {
        const cityInput = document.getElementById('city').value.toLowerCase();
        const citySuggestions = document.getElementById('citySuggestions'); 

        citySuggestions.innerHTML = '';
        const filteredCities = validCities.filter(city => city.toLowerCase().startsWith(cityInput));

        // Add filtered suggestions to the datalist
        filteredCities.forEach(city => {
            const option = document.createElement('option');
            option.value = city; // Set option value
            citySuggestions.appendChild(option); // Add to datalist
        });
    }

    // Function to update date and time display
    function updateDateTime() {
        const now = new Date();
        const currentDateTime = now.toLocaleString();
        document.querySelector('#datetime').textContent = currentDateTime;
    }

    // Function to update font size based on input range
    function updateFontSize() {
        const fontSize = document.getElementById('fontsize').value + 'px';
        document.querySelector('.mainsection').style.fontSize = fontSize;
        document.querySelector('#fontsizeval').textContent = fontSize;
    }

    // Function to update background color based on user selection
    function updateBackgroundColor() {
        const bgColor = document.getElementById('bgColor').value;
        document.querySelector('body').style.backgroundColor = bgColor;
    }

    // Call update functions on input changes
    document.getElementById('fontsize').addEventListener('input', updateFontSize);
    document.getElementById('bgColor').addEventListener('input', updateBackgroundColor);
    document.getElementById('city').addEventListener('input', filterCities);

    // Update the date and time every second
    setInterval(updateDateTime, 1000);

    // Initialize font size and background color on page load
    updateFontSize();
    updateBackgroundColor();
    filterCities();




    function validateCarForm(event) {
    event.preventDefault();
    let city = document.getElementById("city").value.trim();
    let checkinDay = document.getElementById("checkinDay").value;
    let checkoutDay = document.getElementById("checkoutDay").value;
    let carType = document.getElementById("cars").value;
    const checkinDate = new Date(checkinDay);
    const checkoutDate = new Date(checkoutDay);
    const minDate = new Date("2024-09-01");
    const maxDate = new Date("2024-12-01");
    let cityLower = city.toLowerCase().replace(/\s+/g, ' ').trim(); 
    let valid = true;

 

    // Validate city
    if (!validCities.map(city => city.toLowerCase().trim()).includes(cityLower) || city === "") {
        alert("City must be a city in Texas or California and cannot be empty.");
        valid = false;
    }

    // Validate car type
    if (carType === "") {
        alert("Please select a car type.");
        valid = false;
    }

    // Validate check-in date
    if (checkinDay === "" || checkinDate < minDate || checkinDate > maxDate) {
        alert("Check-in date must be between Sep 1, 2024, and Dec 1, 2024.");
        valid = false;
    }

    // Validate check-out date
    if (checkoutDay === "" || checkoutDate < minDate || checkoutDate > maxDate) {
        alert("Check-out date must be between Sep 1, 2024, and Dec 1, 2024.");
        valid = false;
    }

    if (checkinDate > checkoutDate) {
        alert("Check-in date should be less than or equal to check-out date.");
        valid = false;
    }

    if (valid) {
        let displayCarInfo = document.getElementById("staysinfo");
        displayCarInfo.classList.remove("hide");
        
        // Display the booking details directly here
        displayCarInfo.innerHTML = `<h4>Booking Details:</h4><br>
            City: ${city}<br>
            Car Type: ${carType}<br>
            Check-In Date: ${checkinDay}<br>
            Check-Out Date: ${checkoutDay}<br>`;
    }
    return valid;
}
</script>
</body>
</html>