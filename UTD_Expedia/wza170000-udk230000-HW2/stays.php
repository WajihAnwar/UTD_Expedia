<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assignment 2</title>
    <link rel="stylesheet" href="style.css">
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

    <!-- Side and Main Content -->
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
            <h2>Book a stay</h2>
            <form id="staysform" onsubmit="return validateStaysForm(event)">
                <label for="city">City:</label><br>
                <input list="citySuggestions" id="city" name="city" required><br>
                <datalist id="citySuggestions"></datalist>
                <label for="checkinDay">Check-In Date:</label><br>
                <input type="date" id="checkinDay" name="checkinDay" min="2024-09-01" max="2024-12-01" required><br>
                <label for="checkoutDay">Check-Out Date:</label><br>
                <input type="date" id="checkoutDay" name="checkoutDay" min="2024-09-01" max="2024-12-01" required><br>


                <h2><Strong>Guest Policy</Strong></h2>
                <ul>
                    <li><Strong>2 individuals per room with the exception of one infant</Strong></li>
                </ul>
                <label for="adults">Number of adults (per room):</label><br>
                <input type="number" id="adults" name="adults" min="1" max="2" value="1" required><br>
                <label for="children">Number of children (per room):</label><br>
                <input type="number" id="children" name="children" min="0" max="2" value="0"><br>
                <label for="infants">Number of infants (per room):</label><br>
                <input type="number" id="infants" name="infants" min="0" max="2" value="0"><br>

                <button type="submit">Submit</button>
            </form>
            <div id="staysinfo" class="hide">
                <p id="staysinfodetail"></p>
            </div>

            <!-- Div where hotel info will be displayed -->
            <div id="hotelList"></div>
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
                <span>First Name: Utsav Dushyant</span><br>
                <span>Last Name: Kanani</span><br>
                <span>Net ID: udk230000</span><br>
                <span>Section Number: 6314.002</span>
            </div>
        </div>
    </footer>

    <!-- JavaScript -->
    <script>
    const validCities = [
        "Austin",
        "Dallas",
        "Houston",
        "San Antonio",
        "El Paso",
        "Los Angeles",
        "San Francisco",
        "San Diego",
        "San Jose"
    ];

    function filterCities() {
        const cityInput = document.getElementById('city').value.toLowerCase();
        const citySuggestions = document.getElementById('citySuggestions');

        citySuggestions.innerHTML = '';
        const filteredCities = validCities.filter(city => city.toLowerCase().startsWith(cityInput));

        filteredCities.forEach(city => {
            const option = document.createElement('option');
            option.value = city;
            citySuggestions.appendChild(option);
        });
    }

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

    document.getElementById('fontsize').addEventListener('input', updateFontSize);
    document.getElementById('bgColor').addEventListener('input', updateBackgroundColor);
    document.getElementById('city').addEventListener('input', filterCities);

    setInterval(updateDateTime, 1000);

    updateFontSize();
    updateBackgroundColor();
    filterCities();

    function validateStaysForm(event) {
        event.preventDefault();

        const city = document.getElementById("city").value.trim();
        const checkinDay = document.getElementById("checkinDay").value;
        const checkoutDay = document.getElementById("checkoutDay").value;
        const adults = parseInt(document.getElementById("adults").value);
        const infants = parseInt(document.getElementById("infants").value);
        const children = parseInt(document.getElementById("children").value);
        const checkinDate = new Date(checkinDay);
        const checkoutDate = new Date(checkoutDay);
        const minDate = new Date("2024-09-01");
        const maxDate = new Date("2024-12-01");
        const cityLower = city.toLowerCase();
        let valid = true;

        // Validate city
        if (!validCities.map(city => city.toLowerCase()).includes(cityLower)) {
            alert("City must be a city in Texas or California.");
            valid = false;
        }

        // Validate check-in date
        if (checkinDay === "" || checkinDate < minDate || checkinDate > maxDate) {
            alert("Check-in date must be between Sep 1, 2024, and Dec 1, 2024.");
            valid = false;
        }

        // Validate check-out date
        if (checkoutDay === "" || checkoutDate <= checkinDate || checkoutDate > maxDate) {
            alert("Check-out date must be after check-in date and before Dec 1, 2024.");
            valid = false;
        }

        // Validate number of guests (total of adults, children, infants)
        const totalGuests = adults + children;
        if (totalGuests > 2) {
            alert("Total number of guests (adults and children) cannot exceed 2 per room.");
            valid = false;
        } else if (totalGuests === 2 && infants > 1) {
            alert("For 2 guests (adults and children), only 1 infant is allowed in the room.");
            valid = false;
        } else if (totalGuests === 1 && infants > 1) {
            alert("If there is 1 adult and 1 child, only 1 infant can be included.");
            valid = false;
        } else {
            // If guest validation passes
            let displayStaysInfo = document.getElementById("staysinfo");
            displayStaysInfo.classList.remove("hide");
            displayStaysInfo.innerHTML = `
                    <h4>Booking Details:</h4><br>
                    City: ${city}<br>
                    Check-In Date: ${checkinDay}<br>
                    Check-Out Date: ${checkoutDay}<br>
                    Adults: ${adults}<br>
                    Children: ${children}<br>
                    Infants: ${infants}<br>
                    `;
            fetchHotels(city, checkinDay, checkoutDay, adults, children, infants);
        }
    }

    function fetchHotels(city, checkinDay, checkoutDay, adults, children, infants) {
        const url = `getHotels.php?city=${encodeURIComponent(city)}`;

        fetch(url)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to fetch hotels');
                }
                return response.json();
            })
            .then(data => {
                let hotelList = document.getElementById('hotelList');
                hotelList.innerHTML = "<h3>Available Hotels</h3>";

                // Filter hotels by city and date range
                const filteredHotels = data.hotels.filter(hotel => {
                    const hotelCheckIn = new Date(hotel['check-in-date']);
                    const hotelCheckOut = new Date(hotel['check-out-date']);
                    const userCheckIn = new Date(checkinDay);
                    const userCheckOut = new Date(checkoutDay);

                    // Check if hotel city matches and dates fall within available range
                    return (
                        hotel.city.toLowerCase() === city.toLowerCase() &&
                        userCheckIn >= hotelCheckIn &&
                        userCheckOut <= hotelCheckOut
                    );
                });

                // Display hotels matching city and date criteria
                if (filteredHotels.length > 0) {
                    filteredHotels.forEach(hotel => {
                        let hotelItem = document.createElement('div');
                        hotelItem.innerHTML = `
                        <strong>${hotel['hotel-name']}</strong><br>
                        City: ${hotel.city}<br>
                        Price per Night (per room): $${hotel['price-per-night']}<br>
                        Available from: ${hotel['check-in-date']} to ${hotel['check-out-date']}<br>
                        <button onclick="addToCart('${hotel['hotel-id']}', '${hotel['hotel-name']}', '${hotel.city}', ${hotel['price-per-night']}, '${checkinDay}', '${checkoutDay}', ${adults}, ${children}, ${infants})">Add to Cart</button>
                        <hr>`;
                        hotelList.appendChild(hotelItem);
                    });
                } else {
                    hotelList.innerHTML = "<p>No hotels available for the selected city and dates.</p>";
                }
            })
            .catch(error => {
                console.error('Error fetching hotels:', error);
            });
    }


    function addToCart(hotelId, hotelName, city, pricePerNight, checkInDate, checkOutDate, adults, children, infants) {
        // Parse dates for stay duration calculation
        const checkIn = new Date(checkInDate);
        const checkOut = new Date(checkOutDate);
        const stayDuration = Math.ceil((checkOut - checkIn) / (1000 * 60 * 60 * 24)); // Convert milliseconds to days

        let numberOfRooms;

        if (adults === 2 && infants <= 1 && children === 0) {
            // Special case: Two adults and one infant require only one room
            numberOfRooms = 1;
        } else {
            // General case: Divide total guests by 2 (maximum 2 individuals per room, excluding one infant)
            const totalGuests = adults + children + infants;
            numberOfRooms = Math.ceil(totalGuests / 2);
        }

        // Calculate the total price
        const totalPrice = parseFloat(pricePerNight) * stayDuration * numberOfRooms;

        // Prepare the cart item object
        let cartItem = {
            hotelId: hotelId,
            hotelName: hotelName,
            city: city,
            checkInDate: checkInDate,
            checkOutDate: checkOutDate,
            pricePerNight: parseFloat(pricePerNight),
            totalPrice: totalPrice.toFixed(2),
            adults: adults,
            children: children,
            infants: infants,
            numberOfRooms: numberOfRooms
        };

        console.log("Adding to cart:", cartItem); // Debugging 


        let cart = JSON.parse(localStorage.getItem('cart')) || {
            stays: [],
            departingFlight: null,
            returningFlight: null
        };


        if (!Array.isArray(cart.stays)) {
            cart.stays = [];
        }

        // Add the current item to the stays array
        cart.stays.push(cartItem);

        // Save the updated cart back to localStorage
        localStorage.setItem('cart', JSON.stringify(cart));

        // Redirect to the cart page
        window.location.href = 'cart.php';
    }

    function showStayFormDetails(hotelId, hotelName, city, pricePerNight, checkInDate, checkOutDate, adults, children,
        infants, numberOfRooms) {
        let staysInfoDiv = document.getElementById("staysinfo");
        let staysInfoDetail = document.getElementById("staysinfodetail");

        staysInfoDetail.innerHTML = `
                    <h3>Booking Details</h3>
                    <p><strong>City:</strong> ${city}</p>
                    <p><strong>Check-In Date:</strong> ${checkindt}</p>
                    <p><strong>Check-Out Date:</strong> ${checkoutdt}</p>
                    <p><strong>Number of Adults:</strong> ${noofadults}</p>
                    <p><strong>Number of Children:</strong> ${noofchildren}</p>
                    <p><strong>Number of Infants:</strong> ${noofinfants}</p>
                    <p><strong>Number of Rooms Needed:</strong> ${roomsNeeded}</p>
                `;

        staysInfoDiv.classList.remove("hide");
    }
    </script>
</body>

</html>