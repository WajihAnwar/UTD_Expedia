<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Assignment-2</title>
    <link rel="stylesheet" href="style.css">
    <!-- Font Awesome CDN for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <!-- Header -->
    <header class="row">
        <div class="header-data">
            <span>Flight Booking</span><br>
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
        <!-- Side Section -->
        <section class="sidesection">
            <h2>Customization Controls:</h2>
            <label for="fontsize">Font Size: </label>
            <input type="range" id="fontsize" min="5" max="50" value="25">
            <span id="fontsizeval">25px</span><br><br>

            <label for="bgColor">Background Color: </label>
            <input type="color" id="bgColor" value="#ffffff">
        </section>

        <!-- Main Section -->
        <section class="mainsection">
            <h2>Trip Details</h2>

            <!-- Trip Type -->
            <label for="tripType">Select Trip Type:</label><br>
            <input type="radio" id="oneWay" name="tripType" value="oneWay" checked> One-Way Trip
            <input type="radio" id="roundTrip" name="tripType" value="roundTrip"> Round Trip<br><br>

            <!-- Flight Form -->
            <form id="flightForm">
                <label for="origin">Origin (Departure City):</label><br>
                <input list="originSuggestions" id="origin" name="origin">
                <datalist id="originSuggestions">
                    <option value="Austin">
                    <option value="Dallas">
                    <option value="Houston">
                    <option value="San Antonio">
                    <option value="El Paso">
                    <option value="Los Angeles">
                    <option value="San Francisco">
                    <option value="San Diego">
                    <option value="San Jose">
                </datalist><br><br>

                <label for="destination">Destination (Arrival City):</label><br>
                <input list="destinationSuggestions" id="destination" name="destination">
                <datalist id="destinationSuggestions">
                    <option value="Austin">
                    <option value="Dallas">
                    <option value="Houston">
                    <option value="San Antonio">
                    <option value="El Paso">
                    <option value="Los Angeles">
                    <option value="San Francisco">
                    <option value="San Diego">
                    <option value="San Jose">
                </datalist><br><br>

                <!--Departing and Arrival Dates, used min and max to block dates from passing limit   --> 
                <label for="departingDate">Departing Date (Sep 1, 2024 to Dec 1, 2024):</label><br>
                <input type="date" id="departingDate" name="departingDate" min="2024-09-01" max="2024-12-01"><br><br>

                <div id="returnFlight" style="display: none;">
                    <label for="returningDate">Returning Date (Sep 1, 2024 to Dec 1, 2024):</label><br>
                    <input type="date" id="returningDate" name="returningDate" min="2024-09-01" max="2024-12-01"><br><br>
                </div>

                <!-- Passenger Icon -->
                <i class="fas fa-users" id="passengerIcon" style="font-size: 2rem; cursor: pointer;"></i>
                <span>Click to add passengers</span><br><br>

                <div id="passengerForm" style="display: none;">
                    <h4>Enter Passenger Details:</h4>
                    
                    <label for="adults">Number of Adults:</label><br>
                    <input type="number" id="adults" name="adults" value="1" min="0" max="4"><br><br>
                
                    <label for="children">Number of Children:</label><br>
                    <input type="number" id="children" name="children" value="0" min="0" max="4"><br><br>
                
                    <label for="infants">Number of Infants:</label><br>
                    <input type="number" id="infants" name="infants" value="0" min="0" max="4"><br><br>
                </div><br>
                

                <button type="submit">Search Flights</button>
            </form>

            <div id="output" style="margin-top: 20px;"></div>


            <div id="availableFlights" class="hide">
                    <h3>Available Flights:</h3>
                    <div id="flightsList"></div>
                </div>


                <div id="ticketPrices" style="display: none; margin-top: 20px;">
                    <h3>Ticket Prices:</h3>
                    <p id="adultPrice"></p>
                    <p id="childPrice"></p>
                    <p id="infantPrice"></p>
                </div>
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

$(document).ready(function () {

        // Adjust font size based on range input
        $('#fontsize').on('input', function () {
            const fontSize = $(this).val() + 'px';
            $('.mainsection').css('font-size', fontSize);
            $('#fontsizeval').text(fontSize);
        });

        // Change background color based on color input
        $('#bgColor').on('input', function () {
            const bgColor = $(this).val();
            $('body').css('background-color', bgColor);
        });

        // Toggle return flight date visibility based on trip type
        $("input[name='tripType']").change(function () {
            if ($("#roundTrip").is(":checked")) {
                $("#returnFlight").show();
            } else {
                $("#returnFlight").hide();
                $("#flightsList").empty(); // Added $ to correctly select the element
            }
        });

        // Toggle passenger form visibility
        $('#passengerIcon').click(function () {
            $('#passengerForm').toggle();
        });

        // Form submission for searching flights
        $("#flightForm").submit(function (event) {
            event.preventDefault();

            // Get form values
            let tripType = $("input[name='tripType']:checked").val();
            let origin = $("#origin").val().trim();
            let destination = $("#destination").val().trim();
            let departingDate = $("#departingDate").val();
            let returningDate = null;
            if (tripType === 'roundTrip') {
                returningDate = $("#returningDate").val();
            }
            let adults = parseInt($("#adults").val());
            let children = parseInt($("#children").val());
            let infants = parseInt($("#infants").val());
            let totalPassengers = adults + children + infants;

            // Form validation
            const validCities = [
                "Austin", "Dallas", "Houston", "San Antonio", "El Paso", "Los Angeles", "San Francisco", "San Diego", "San Jose"
            ];

            const dateRegex = /^2024-(09|10|11|12)-(0[1-9]|[12][0-9]|30|31)$/;

            if (!validCities.includes(origin)) {
                alert("Origin must be a city in Texas or California.");
                return;
            }
            if (!validCities.includes(destination)) {
                alert("Destination must be a city in Texas or California.");
                return;
            }
            if (origin === destination) {
                alert("Origin and Destination cannot be the same.");
                return;
            }
            if (!dateRegex.test(departingDate)) {
                alert("Please enter a valid departing date between Sep 1, 2024, and Dec 1, 2024.");
                return;
            }
            if (tripType === 'roundTrip' && (!returningDate || !dateRegex.test(returningDate))) {
                alert("Please enter a valid returning date between Sep 1, 2024, and Dec 1, 2024.");
                return;
            }

            searchFlights(departingDate, returningDate, origin, destination, totalPassengers, tripType);
        });

        // Function to search flights through looking through flight.xml
        function searchFlights(departureDate, returnDate, origin, destination, passengers, tripType) {
            fetch('retrieveFlightsSQL.php')
                .then(response => response.text())
                .then(data => {
                    let parser = new DOMParser();
                    let xml = parser.parseFromString(data, "application/xml");
                    let exactFlightsFound = false;

                    if (tripType === "roundTrip") {
                        // Round trip flight search
                        exactFlightsFound = displayAvailableFlights(xml, origin, destination, departureDate, passengers, true, 'depart', tripType) && 
                                             displayAvailableFlights(xml, destination, origin, returnDate, passengers, true, 'return', tripType);
                        if (!exactFlightsFound) {
                            // Search within a 3 day radius
                            searchFlightsWithDateRange(xml, origin, destination, departureDate, passengers, returnDate, tripType);
                        }
                    } else {
                        // One way flight search
                        exactFlightsFound = displayAvailableFlights(xml, origin, destination, departureDate, passengers, true, 'depart', tripType);
                        if (!exactFlightsFound) {
                            // Search within a 3 day radius
                            searchFlightsWithDateRange(xml, origin, destination, departureDate, passengers, null, tripType);
                        }
                    }
                })
                .catch(error => console.error('Error fetching the XML file:', error));
        }

        // Function to search flights within a ±3 day range if no exact match is found
        function searchFlightsWithDateRange(xml, origin, destination, departureDate, passengers, returnDate, tripType) {
            let startRange = new Date(departureDate);
            let endRange = new Date(departureDate);

                //Found online
            startRange.setUTCHours(0, 0, 0, 0);
            endRange.setUTCHours(23, 59, 59, 999);

       
            startRange.setDate(startRange.getDate() - 3);
            endRange.setDate(endRange.getDate() + 3);

            let startRangeRet = returnDate ? new Date(returnDate) : null;
            let endRangeRet = returnDate ? new Date(returnDate) : null;

            if (startRangeRet) {
                startRangeRet.setUTCHours(0, 0, 0, 0);
                endRangeRet.setUTCHours(23, 59, 59, 999);

                startRangeRet.setDate(startRangeRet.getDate() - 3);
                endRangeRet.setDate(endRangeRet.getDate() + 3);
            }


            let depFlightsFound = displayAvailableFlights(xml, origin, destination, [startRange, endRange], passengers, false, 'depart', tripType);
            let retFlightsFound = true;
            if (startRangeRet) {
                retFlightsFound = displayAvailableFlights(xml, destination, origin, [startRangeRet, endRangeRet], passengers, false, 'return', tripType);
            }

            if (!depFlightsFound) {
                $("#flightsList").append('<p>No exact departure flights found. Please look at these nearby dates within ±3 days.</p>');
            }
            if (startRangeRet && !retFlightsFound) {
                $("#flightsList").append('<p>No exact return flights found. Please look at these nearby dates within ±3 days.</p>');
            }
        }


        function displayAvailableFlights(xml, origin, destination, dateRange, passengers, exactMatch, flightType, triptype) {
    let flightsList = $("#flightsList");
    
    if (triptype === 'oneWay' || (triptype === 'roundTrip' && flightType === 'depart')) {
        flightsList.empty();
    }

    let flights = xml.getElementsByTagName('flight');
    let resultsFound = false;

    for (let flight of flights) {
        let flightOrigin = flight.getElementsByTagName('origin')[0].textContent.toLowerCase();
        let flightDestination = flight.getElementsByTagName('destination')[0].textContent.toLowerCase();
        let flightDepDate = new Date(flight.getElementsByTagName('departure-date')[0].textContent);
        flightDepDate.setUTCHours(0, 0, 0, 0); 
        let availableSeats = parseInt(flight.getElementsByTagName('available-seats')[0].textContent);

        let isDateWithinRange = false;

        if (exactMatch) {
            isDateWithinRange = flightDepDate.toISOString().split('T')[0] === new Date(dateRange).toISOString().split('T')[0];
        } else {
            let [startRange, endRange] = dateRange;
            isDateWithinRange = flightDepDate >= startRange && flightDepDate <= endRange;
        }

      
        if (flightOrigin === origin.toLowerCase() && flightDestination === destination.toLowerCase() && availableSeats >= passengers && isDateWithinRange) {
            resultsFound = true;
            const flightId = flight.getElementsByTagName('flight-id')[0].textContent;
            const arrivalDate = flight.getElementsByTagName('arrival-date')[0].textContent;
            const departureTime = flight.getElementsByTagName('departure-time')[0].textContent;
            const arrivalTime = flight.getElementsByTagName('arrival-time')[0].textContent;

            flightsList.append(`
                <div class="flight">
                    <p><strong>Flight ID:</strong> ${flightId}</p>
                    <p><strong>Origin:</strong> ${flightOrigin}</p>
                    <p><strong>Destination:</strong> ${flightDestination}</p>
                    <p><strong>Departure Date:</strong> ${flightDepDate.toISOString().split('T')[0]}</p>
                    <p><strong>Arrival Date:</strong> ${arrivalDate}</p>
                    <p><strong>Departure Time:</strong> ${departureTime}</p>
                    <p><strong>Arrival Time:</strong> ${arrivalTime}</p>
                    <p><strong>Available Seats:</strong> ${availableSeats}</p>
                </div>
                <hr>
            `);

            if (triptype === 'roundTrip' && flightType === 'depart') {
      
            } else {
                flightsList.append(`
                    <button class="add-to-cart" data-flight-id="${flightId}">Add to Cart</button>
                `);
            }
        }
    }

    if (!resultsFound) {
        flightsList.append(`<p>No available flights found for the selected ${flightType === 'depart' ? 'departure' : 'return'} date.</p>`);
    }


    $(".add-to-cart").off('click').on("click", function () {
        const flightId = $(this).data("flight-id");
        addToCart(flightId, triptype);
    });

    return resultsFound;
}



     
        function addToCart(flightId, triptype) {


            //USE SQL TABLE
            fetch('retrieveFlightsSQL.php')
                .then(response => response.text())
                .then(data => {
                    let parser = new DOMParser();
                    let xml = parser.parseFromString(data, "application/xml");
                    let flights = xml.getElementsByTagName('flight');

                    let adults = parseInt(document.getElementById("adults").value) || 0;
                    let children = parseInt(document.getElementById("children").value) || 0;
                    let infants = parseInt(document.getElementById("infants").value) || 0;

                  
                    let cart = { departingFlight: null, returningFlight: null };

                        //User input
                    const selectedOrigin = document.getElementById("origin").value.toLowerCase();
                    const selectedDestination = document.getElementById("destination").value.toLowerCase();
                    const selectedDepDate = document.getElementById("departingDate").value;
                    const selectedRetDate = document.getElementById("returningDate").value;

                    console.log("Starting to search for matching flights...");

                    // Iterate over each flight in the XML
                    for (let flight of flights) {
                        const currentFlightId = flight.getElementsByTagName('flight-id')[0].textContent;
                        const flightOrigin = flight.getElementsByTagName('origin')[0].textContent.toLowerCase();
                        const flightDestination = flight.getElementsByTagName('destination')[0].textContent.toLowerCase();
                        const flightDepDate = flight.getElementsByTagName('departure-date')[0].textContent;

                        console.log(`Checking flight with ID ${currentFlightId}...`);

                        if (triptype === 'oneWay' && currentFlightId == flightId) {
                            // Match for one-way flight
                            let adultTicketPrice = parseFloat(flight.getElementsByTagName('price')[0].textContent);
                            let childTicketPrice = adultTicketPrice * 0.7;
                            let infantTicketPrice = adultTicketPrice * 0.1;
                            let totalPrice = (adults * adultTicketPrice) + (children * childTicketPrice) + (infants * infantTicketPrice);

                            cart.departingFlight = {
                                flightId: currentFlightId,
                                origin: flightOrigin,
                                destination: flightDestination,
                                depDate: flightDepDate,
                                arrDate: flight.getElementsByTagName('arrival-date')[0].textContent,
                                depTime: flight.getElementsByTagName('departure-time')[0].textContent,
                                arrTime: flight.getElementsByTagName('arrival-time')[0].textContent,
                                seats: flight.getElementsByTagName('available-seats')[0].textContent,
                                adultTicketPrice: adultTicketPrice,
                                totalPrice: totalPrice.toFixed(2),
                                adults: adults,
                                children: children,
                                infants: infants
                            };
                            console.log("One-way flight added to cart:", cart.departingFlight);
                            break;
                        } 

                        // Round-trip logic
                        if (triptype === 'roundTrip') {
                            let adultTicketPrice = parseFloat(flight.getElementsByTagName('price')[0].textContent);
                            let totalPrice = (adults * adultTicketPrice) + (children * adultTicketPrice * 0.7) + (infants * adultTicketPrice * 0.1);

                            // Check for departing flight
                            if (!cart.departingFlight && flightOrigin === selectedOrigin && flightDestination === selectedDestination && flightDepDate === selectedDepDate) {
                                cart.departingFlight = {
                                    flightId: currentFlightId,
                                    origin: flightOrigin,
                                    destination: flightDestination,
                                    depDate: flightDepDate,
                                    arrDate: flight.getElementsByTagName('arrival-date')[0].textContent,
                                    depTime: flight.getElementsByTagName('departure-time')[0].textContent,
                                    arrTime: flight.getElementsByTagName('arrival-time')[0].textContent,
                                    seats: flight.getElementsByTagName('available-seats')[0].textContent,
                                    adultTicketPrice: adultTicketPrice,
                                    totalPrice: totalPrice.toFixed(2),
                                    adults: adults,
                                    children: children,
                                    infants: infants
                                };
                                console.log("Departing flight added for round-trip:", cart.departingFlight);
                            } 
                            
                            // Check for returning flight
                            else if (!cart.returningFlight && flightOrigin === selectedDestination && flightDestination === selectedOrigin && flightDepDate === selectedRetDate) {
                                cart.returningFlight = {
                                    flightId: currentFlightId,
                                    origin: flightOrigin,
                                    destination: flightDestination,
                                    depDate: flightDepDate,
                                    arrDate: flight.getElementsByTagName('arrival-date')[0].textContent,
                                    depTime: flight.getElementsByTagName('departure-time')[0].textContent,
                                    arrTime: flight.getElementsByTagName('arrival-time')[0].textContent,
                                    seats: flight.getElementsByTagName('available-seats')[0].textContent,
                                    adultTicketPrice: adultTicketPrice,
                                    totalPrice: totalPrice.toFixed(2),
                                    adults: adults,
                                    children: children,
                                    infants: infants
                                };
                                console.log("Returning flight added for round-trip:", cart.returningFlight);
                            }
                        }
                    }

                    // Log the final cart 
                    console.log("Final Cart Data:", cart);
                    localStorage.setItem('cart', JSON.stringify(cart));

                    // Call saveCartToPHP to save cart data to PHP
                    saveCartToPHP(cart);
                })
                .catch(error => console.error('Error fetching the XML file:', error));
        }


        function saveCartToPHP(cart) {
            fetch('saveCart.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(cart)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log("Cart data saved successfully.");
                    window.location.href = 'cart.php';
                } else {
                    console.error("Failed to save cart data.");
                }
            })
            .catch(error => console.error("Error:", error));
        }
    });
    </script>





    
</body>

</html>
