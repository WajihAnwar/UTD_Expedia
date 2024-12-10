
<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <title>Assignment 3 - Cruises</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <!-- Header -->
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

    <!-- Navigation bar -->
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

    <!-- Main Content -->
    <div class="row container">
        <section class="sidesection">
            <h2>Customization Controls:</h2>
            <label for="fontsize">Font Size: </label>
            <input type="range" id="fontsize" min="5" max="50" value="25">
            <span id="fontsizeval">25px</span><br><br>

            <label for="bgColor">Background Color: </label>
            <input type="color" id="bgColor" value="#ffffff">
        </section>

        <section class="mainsection">
            <h2>Book a Cruise</h2>
      
            <form id="cruiseForm">
                <label for="destination">Destination:</label><br>
                <input list="destinationSuggestions" id="destination" name="destination">
                <datalist id="destinationSuggestions">
                    <option value="Alaska">
                    <option value="Bahamas">
                    <option value="Europe">
                    <option value="Mexico">
                </datalist><br><br>

                <label for="departing">Departing Date (Sep 1, 2024 to Dec 1, 2024):</label><br>
                <input type="date" id="departing" name="departing"><br><br>

                <label for="duration">Duration (3 to 10 days):</label><br>
                <input type="number" id="duration" name="duration"><br><br>

                <label for="adults">Number of Adults:</label><br>
                <input type="number" id="adults" name="adults" value="1"><br><br>

                <label for="children">Number of Children (per room):</label><br>
                <input type="number" id="children" name="children" value="0"><br><br>

                <label for="infants">Number of Infants (per room):</label><br>
                <input type="number" id="infants" name="infants" value="0"><br><br>

                <button type="submit">Submit</button>
            </form>

            <div id="output" style="margin-top: 20px;"></div>
        </section>
    </div>

    <!-- Footer -->
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
                <span>First Name: Utsav</span><br>
                <span>Last Name: Kanani</span><br>
                <span>Net ID: UDK230000</span><br>
                <span>Section Number: 6314.002</span>
            </div>
        </div>
    </footer>

    <!-- JavaScript -->
    <script>
        $(document).ready(function () {
            const validDestinations = ["Alaska", "Bahamas", "Europe", "Mexico"];

            // Update date and time
            setInterval(function () {
                let now = new Date();
                $("#datetime").text(now.toLocaleString());
            }, 1000);

            // Font size control
            $("#fontsize").on("input", function () {
                let fontSize = $(this).val() + "px";
                $(".mainsection").css("font-size", fontSize);
                $("#fontsizeval").text(fontSize);
            });

            // Background color control
            $("#bgColor").on("input", function () {
                $("body").css("background-color", $(this).val());
            });

            // Form validation and submission
            $("#cruiseForm").submit(function (event) {
                event.preventDefault();

                let destination = $("#destination").val();
                let departing = $("#departing").val();
                let duration = parseInt($("#duration").val());
                let adults = parseInt($("#adults").val());
                let children = parseInt($("#children").val());
                let infants = parseInt($("#infants").val());

                // Validate destination
                if (!validDestinations.includes(destination)) {
                    alert("Please select or enter a valid destination (Alaska, Bahamas, Europe, Mexico).");
                    return;
                }

                // Validate departing date
                let departingDate = new Date(departing);
                let minDate = new Date("2024-09-01");
                let maxDate = new Date("2024-12-01");

                if (!departing || departingDate < minDate || departingDate > maxDate) {
                    alert("Please select a valid departing date between Sep 1, 2024 and Dec 1, 2024.");
                    return;
                }

                // Validate duration
                if (isNaN(duration) || duration < 3 || duration > 10) {
                    alert("Duration must be between 3 and 10 days.");
                    return;
                }

                // Validate number of guests
                if (adults < 1 || adults > 2) {
                    if(adults<1){
                        alert("There Should be atleast One Adult")
                    }
                    else{
                        alert("Number of adults must be between 1 and 2.");
                    }
                    return;
                }

                if (infants < 0 || infants > 2) {
                    alert("Number of infants must be between 0 and 2.");
                    return;
                }

                // Logic when 1 adult is present
                if (adults === 1) {
                    if (children > 2) {
                        alert("A maximum of 2 children are allowed with 1 adult.");
                        return;
                    }
                }

                // Logic when 2 adults are present
                if (adults === 2) {
                    if (children > 1) {
                        alert("Maximum of 1 child is allowed with 2 adult.");
                        return;
                    }
                }

                // Display the entered data
                $("#output").html(`
                    <h4>Cruise Booking Details:</h4>
                    <p>Destination: ${destination}</p>
                    <p>Departing: ${departing}</p>
                    <p>Duration: ${duration} days</p>
                    <p>Adults: ${adults}</p>
                    <p>Children: ${children}</p>
                    <p>Infants: ${infants}</p>
                `);
            });
        });
    </script>
</body>

</html>