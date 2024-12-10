<?php
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

// Check if the user is an admin
$is_admin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'];
?>
<!DOCTYPE html>
<html>

<head>
    <title>My Account - Assignment #4</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

    <!-- navigation bar -->
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

    <!-- side and main content -->
    <div class="row container">
        <section class="sidesection">
            <h2>Side Content</h2>
            <h4>Customization Controls:</h4>
            <div>
                <label for="fontsize">Font Size:</label>
                <input type="range" id="fontsize" min="5" max="50" value="16">
                <span id="fontsizeval">16px</span>
            </div>
            <div>
                <label for="bgColor">Background Color:</label>
                <input type="color" id="bgColor" value="#ffffff">
            </div>
        </section>

        <section class="mainsection">
            <h2>My Account</h2>
            <p>Welcome, <?php echo htmlspecialchars($_SESSION['firstname'] . ' ' . $_SESSION['lastname']); ?>!</p>
            <p><?php echo $is_admin ? "You are logged in as an Admin." : "You are logged in as a Regular User."; ?></p>





            <?php if (!$is_admin): ?>
            <h3>User Options</h3>

            <!-- Retrieve Flight by Booking ID -->
            <form id="retrieveFlightByIdForm">
                <h4>Retrieve Flight by Booking ID</h4>
                <label for="flight_booking_id">Flight Booking ID:</label>
                <input type="text" id="flight_booking_id" required>
                <button type="button" id="retrieveFlightByIdButton">Retrieve Flight</button>
            </form>
            <div id="flightByIdMessage" style="margin-top: 10px;"></div>

            <!-- Retrieve Hotel by Booking ID -->
            <form id="retrieveHotelByIdForm">
                <h4>Retrieve Hotel by Booking ID</h4>
                <label for="hotel_booking_id">Hotel Booking ID:</label>
                <input type="text" id="hotel_booking_id" required>
                <button type="button" id="retrieveHotelByIdButton">Retrieve Hotel</button>
            </form>
            <div id="hotelByIdMessage" style="margin-top: 10px;"></div>


            <!-- Retrieve Passengers by Flight Booking ID -->
            <form id="retrievePassengersByFlightIdForm">
                <h4>Retrieve Passengers by Flight Booking ID</h4>
                <label for="flight_booking_id_passengers">Flight Booking ID:</label>
                <input type="text" id="flight_booking_id_passengers" required>
                <button type="button" id="retrievePassengersButton">Retrieve Passengers</button>
            </form>
            <div id="passengersMessage" style="margin-top: 10px;"></div>



            <form id="retrieveSeptemberInfoForm">

                <h4>Retrieve Booked Information for SEP 2024</h4>
                <button type="button" id="retrieveSeptemberInfoButton">Retrieve September Information</button>
            </form>
            <div id="septemberInfoMessage"></div>



            <form id="retrieveFlightsBySsnForm">
                <h4>Retrieve via SSN </h4>
                <label for="ssn">SSN:</label>
                <input type="text" id="ssn" required>
                <button type="button" id="retrieveFlightsButton">Retrieve Flights</button>
            </form>
            <div id="flightsMessage" style="margin-top: 20px;"></div>




            <?php endif; ?>







            <?php if ($is_admin): ?>
            <h3>Admin Options</h3>

            <!-- Toggle to Show All Hotels -->
            <button id="toggleHotelsButton">Show All Hotels</button>
            <div id="hotelsContainer" style="display: none; margin-top: 20px;">
                <h4>All Hotels</h4>
                <table border="1">
                    <thead>
                        <tr>
                            <th>Hotel ID</th>
                            <th>Hotel Name</th>
                            <th>City</th>
                            <th>Available Rooms</th>
                            <th>Check-in Date</th>
                            <th>Check-out Date</th>
                            <th>Price Per Night</th>
                        </tr>
                    </thead>
                    <tbody id="hotelsTableBody">

                    </tbody>
                </table>
            </div>

            <!-- Toggle to Show All Flights -->
            <button id="toggleFlightsButton">Show All Flights</button>
            <div id="flightsContainer" style="display: none; margin-top: 20px;">
                <h4>All Flights</h4>
                <table border="1">
                    <thead>
                        <tr>
                            <th>Flight ID</th>
                            <th>Origin/th>
                            <th>Arrival</th>
                            <th>Deparature Date </th>
                            <th>Arrival Date</th>
                            <th>Departure Time</th>
                            <th>Arrival Time</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody id="flightsTableBody">

                    </tbody>
                </table>
            </div>

            <!-- Upload Forms -->
            <form id="uploadFlightsForm" enctype="multipart/form-data">
                <label for="flights_xml">Upload Flights XML:</label><br>
                <input type="file" id="flights_xml" name="flights_xml" accept=".xml" required><br><br>
                <button type="submit">Upload Flights</button>
            </form>
            <p id="uploadMessage"></p>

            <form id="uploadHotelForm" enctype="multipart/form-data">
                <label for="hotel_json">Upload Hotel JSON:</label><br>
                <input type="file" id="hotel_json" name="hotel_json" accept=".json" required><br><br>
                <button type="submit">Upload Hotel Data</button>
            </form>
            <p id="hotelUploadMessage"></p>

            <h3>Admin Queries</h3>

            <!-- Retrieve Booked Information in Texas for September 2024 -->
            <h4>Retrieve Texas Bookings for September 2024</h4>
            <form id="retrieveTexasBookingsForm">
                <button type="button" id="retrieveTexasBookingsButton">Retrieve Texas Bookings</button>
            </form>
            <div id="texasBookingsMessage" style="margin-top: 10px;"></div>



            <!-- Retrieve Most Expensive Flights -->
            <form id="retrieveExpensiveFlightForm">
                <h4>Retrieve Most Expensive Flight</h4>
                <button type="button" id="retrieveExpensiveFlightButton">Retrieve Most Expensive Flight</button>
            </form>
            <div id="expensiveInfoMessage" style="margin-top: 10px;"></div>



            <!-- Retrieve Most Expensive Hotel -->
            <form id="retrieveExpensiveHotelForm">
                <h4>Retrieve Most Expensive Hotel</h4>
                <button type="button" id="retrieveExpensiveHotelButton">Retrieve Most Expensive Hotel</button>
            </form>
            <div id="expensiveHotelMessage" style="margin-top: 10px; display: none;"></div>





            <!-- Retrieve Flights with Infants -->
            <form id="retrieveInfantsForm">
                <h4>Retrieve Flights with Infants</h4>
                <button type="button" id="retrieveInfantsButton">Retrieve Flights with Infants</button>
            </form>
            <div id="expensiveInfantMessage" style="margin-top: 10px; display: none;"></div>


            <!-- Retrieve Flights with Infant and At Least 2 Children -->
            <form id="retrieveInfantChildrenForm">
                <h4>Retrieve Flights with Infant Passenger and At Least 2 Children</h4>
                <button type="button" id="retrieveInfantChildrenButton">Retrieve Flights</button>
            </form>
            <div id="infantChildrenMessage" style="margin-top: 10px; display: none;"></div>



            <!-- Retrieve Flights from Texas without Infants -->
            <form id="retrieveFlightsNoInfantsForm">
                <h4>Retrieve Flights from Texas without Infants</h4>
                <button type="button" id="retrieveFlightsNoInfantsButton">Retrieve Flights</button>
            </form>
            <div id="flightsNoInfantsMessage" style="margin-top: 10px;"></div>

            <!-- Retrieve Flights to California -->
            <form id="retrieveCaliforniaFlightsForm">
                <h4>Retrieve Flights to California (Sep & Oct 2024)</h4>
                <button type="button" id="retrieveCaliforniaFlightsButton">Retrieve California Flights</button>
            </form>
            <div id="californiaFlightsMessage" style="margin-top: 10px;"></div>




            <?php else: ?>
            <p>You do not have admin privileges.</p>
            <?php endif; ?>



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

    $(document).ready(function() {

        // Handle Flights XML Upload
        document.getElementById('uploadFlightsForm').addEventListener('submit', function(e) {
            e.preventDefault(); 
            const formData = new FormData(this); 
            const uploadMessage = document.getElementById('uploadMessage');

      
            uploadMessage.textContent = '';

            fetch('uploadFlightsSQL.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    uploadMessage.textContent = data.includes('Error') ?
                        'Error uploading flights.' : 'Flights uploaded successfully.';
                    uploadMessage.style.color = data.includes('Error') ? 'red' : 'green';
                })
                .catch(error => {
                    uploadMessage.textContent = 'Error: Could not upload flights.';
                    uploadMessage.style.color = 'red';
                    console.error('Error:', error);
                });
        });

        // Handle Hotel JSON Upload
        document.getElementById('uploadHotelForm').addEventListener('submit', function(e) {
            e.preventDefault(); 

            const formData = new FormData(this); 
            const hotelUploadMessage = document.getElementById('hotelUploadMessage');

            // Clear any previous messages
            hotelUploadMessage.textContent = '';

            fetch('uploadHotelsSQL.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    hotelUploadMessage.textContent = data.includes('Error') ?
                        'Error uploading hotels.' : 'Hotels uploaded successfully.';
                    hotelUploadMessage.style.color = data.includes('Error') ? 'red' : 'green';
                })
                .catch(error => {
                    hotelUploadMessage.textContent = 'Error: Could not upload hotels.';
                    hotelUploadMessage.style.color = 'red';
                    console.error('Error:', error);
                });
        });





        $('#retrieveFlightsButton').click(function() {
            const ssn = $('#ssn').val();
            const flightsMessage = $('#flightsMessage');

            if (ssn) {
                $.ajax({
                    url: 'retrieve_flights_by_ssn.php',
                    type: 'POST',
                    data: {
                        ssn: ssn
                    },
                    success: function(response) {
                        flightsMessage.html(response);
                    },
                    error: function() {
                        flightsMessage.html(
                            '<p>Error retrieving flights for the provided SSN.</p>');
                    },
                });
            } else {
                flightsMessage.html('<p>Please enter an SSN.</p>');
            }
        });
        $('#retrieveBookingsButton').click(function() {
            const bookingsMessage = $('#bookingsMessage');

            $.ajax({
                url: 'retrieve_booking.php',
                type: 'POST',
                dataType: 'json',
                success: function(response) {
                    let output = '<h3>Bookings for September 2024</h3>';

                    if (response.flights.length > 0) {
                        output += '<h4>Flights</h4>';
                        response.flights.forEach(flight => {
                            output += `
                            <p><strong>Flight Booking ID:</strong> ${flight.flight_booking_id}</p>
                            <p><strong>Flight ID:</strong> ${flight.flight_id}</p>
                            <p><strong>Origin:</strong> ${flight.origin}</p>
                            <p><strong>Destination:</strong> ${flight.destination}</p>
                            <p><strong>Departure Date:</strong> ${flight.departure_date}</p>
                            <p><strong>Arrival Date:</strong> ${flight.arrival_date}</p>
                            <p><strong>Total Price:</strong> $${flight.total_price}</p>
                            <hr>
                        `;
                        });
                    } else {
                        output += '<p>No flights booked in September 2024.</p>';
                    }

                    if (response.hotels.length > 0) {
                        output += '<h4>Hotels</h4>';
                        response.hotels.forEach(hotel => {
                            output += `
                            <p><strong>Hotel Booking ID:</strong> ${hotel.hotel_booking_id}</p>
                            <p><strong>Hotel Name:</strong> ${hotel.hotel_name}</p>
                            <p><strong>City:</strong> ${hotel.city}</p>
                            <p><strong>Check-in Date:</strong> ${hotel.check_in_date}</p>
                            <p><strong>Check-out Date:</strong> ${hotel.check_out_date}</p>
                            <p><strong>Total Price:</strong> $${hotel.total_price}</p>
                            <hr>
                        `;
                        });
                    } else {
                        output += '<p>No hotels booked in September 2024.</p>';
                    }

                    bookingsMessage.html(output);
                },
                error: function() {
                    bookingsMessage.html(
                        '<p>Error retrieving bookings for September 2024.</p>'
                    );
                }
            });
        });
    });
    // Retrieve Flight by Booking ID
    $('#retrieveFlightByIdButton').click(function() {
        const flight_booking_id = $('#flight_booking_id').val();
        const flightByIdMessage = $('#flightByIdMessage');

        if (flight_booking_id) {
            $.ajax({
                url: 'retrieve_booked_flights.php',
                type: 'POST',
                data: {
                    flight_booking_id: flight_booking_id
                },
                dataType: 'json',
                success: function(response) {
                    if (response.error) {
                        flightByIdMessage.html(`<p>${response.error}</p>`);
                    } else {
                        flightByIdMessage.html(`
                            <p><strong>Flight Booking ID:</strong> ${response.flight_booking_id}</p>
                            <p><strong>Flight ID:</strong> ${response.flight_id}</p>
                            <p><strong>Origin:</strong> ${response.origin}</p>
                            <p><strong>Destination:</strong> ${response.destination}</p>
                            <p><strong>Departure Date:</strong> ${response.departure_date}</p>
                            <p><strong>Arrival Date:</strong> ${response.arrival_date}</p>
                            <p><strong>Departure Time:</strong> ${response.departure_time}</p>
                            <p><strong>Arrival Time:</strong> ${response.arrival_time}</p>
                            <p><strong>Price:</strong> $${response.price}</p>
                            <p><strong>Total Price:</strong> $${response.total_price}</p>
                        `);
                    }
                },
                error: function() {
                    flightByIdMessage.html(
                        '<p>Error retrieving flight information.</p>');
                }
            });
        } else {
            flightByIdMessage.html('<p>Please enter a Flight Booking ID.</p>');
        }
    });

    // Retrieve Hotel by Booking ID
    $('#retrieveHotelByIdButton').click(function() {
        const hotel_booking_id = $('#hotel_booking_id').val();
        const hotelByIdMessage = $('#hotelByIdMessage');

        if (hotel_booking_id) {
            $.ajax({
                url: 'retrieve_booked_hotels.php',
                type: 'POST',
                data: {
                    hotel_booking_id: hotel_booking_id
                },
                dataType: 'json',
                success: function(response) {
                    if (response.error) {
                        hotelByIdMessage.html(`<p>${response.error}</p>`);
                    } else {
                        hotelByIdMessage.html(`
                            <p><strong>Hotel Booking ID:</strong> ${response.hotel_booking_id}</p>
                            <p><strong>Hotel Name:</strong> ${response.hotel_name}</p>
                            <p><strong>City:</strong> ${response.city}</p>
                            <p><strong>Check-in Date:</strong> ${response.check_in_date}</p>
                            <p><strong>Check-out Date:</strong> ${response.check_out_date}</p>
                            <p><strong>Number of Rooms:</strong> ${response.number_of_rooms}</p>
                            <p><strong>Total Price:</strong> $${response.total_price}</p>
                        `);
                    }
                },
                error: function() {
                    hotelByIdMessage.html('<p>Error retrieving hotel information.</p>');
                }
            });
        } else {
            hotelByIdMessage.html('<p>Please enter a Hotel Booking ID.</p>');
        }
    });

    // Retrieve Booked Information for SEP 2024
    $('#retrieveSeptemberInfoButton').click(function() {
        const septemberInfoMessage = $('#septemberInfoMessage');
        if (septemberInfoMessage.is(':hidden')) {
            $.ajax({
                url: 'retrieve_september.php',
                type: 'POST',
                success: function(response) {
                    $('#septemberInfoMessage').html(response);
                },
                error: function() {
                    $('#septemberInfoMessage').html(
                        'Error retrieving September 2024 information.');
                }
            });
            septemberInfoMessage.show();
            $('#retrieveSeptemberInfoButton').text('Hide September Information');
        } else {
            septemberInfoMessage.hide();
            $('#retrieveSeptemberInfoButton').text('Retrieve September Information');
        }
    });



    $(document).ready(function() {
        // Retrieve Passengers by Flight Booking ID
        $('#retrievePassengersButton').click(function() {
            const flight_booking_id = $('#flight_booking_id_passengers').val();
            const passengersMessage = $('#passengersMessage');

            if (flight_booking_id) {
                $.ajax({
                    url: 'retrieve_passengers.php', // Backend script to fetch passengers
                    type: 'POST',
                    data: {
                        flight_booking_id: flight_booking_id
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.error) {
                            passengersMessage.html(`<p>${response.error}</p>`);
                        } else {
                            let passengersHTML = '<h4>Passengers:</h4><ul>';
                            response.forEach((passenger) => {
                                passengersHTML += `
                                <li>
                                    <p><strong>SSN:</strong> ${passenger.ssn}</p>
                                    <p><strong>Name:</strong> ${passenger.first_name} ${passenger.last_name}</p>
                                    <p><strong>Category:</strong> ${passenger.category}</p>
                                </li><hr>
                            `;
                            });
                            passengersHTML += '</ul>';
                            passengersMessage.html(passengersHTML);
                        }
                    },
                    error: function() {
                        passengersMessage.html('<p>Error retrieving passengers.</p>');
                    },
                });
            } else {
                passengersMessage.html('<p>Please enter a Flight Booking ID.</p>');
            }
        });
    });
    </script>


    <script>
    $(document).ready(function() {
        // Retrieve Flight by Booking ID
        $('#retrieveFlightByIdButton').click(function() {
            const flight_booking_id = $('#flight_booking_id').val();
            const flightByIdMessage = $('#flightByIdMessage');

            if (flight_booking_id) {
                $.ajax({
                    url: 'retrieve_booked_flights.php',
                    type: 'POST',
                    data: {
                        flight_booking_id: flight_booking_id
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.error) {
                            flightByIdMessage.html(`<p>${response.error}</p>`);
                        } else {
                            flightByIdMessage.html(`
                            <p><strong>Flight Booking ID:</strong> ${response.flight_booking_id}</p>
                            <p><strong>Flight ID:</strong> ${response.flight_id}</p>
                            <p><strong>Origin:</strong> ${response.origin}</p>
                            <p><strong>Destination:</strong> ${response.destination}</p>
                            <p><strong>Departure Date:</strong> ${response.departure_date}</p>
                            <p><strong>Arrival Date:</strong> ${response.arrival_date}</p>
                            <p><strong>Departure Time:</strong> ${response.departure_time}</p>
                            <p><strong>Arrival Time:</strong> ${response.arrival_time}</p>
                            <p><strong>Price:</strong> $${response.price}</p>
                            <p><strong>Total Price:</strong> $${response.total_price}</p>
                        `);
                        }
                    },
                    error: function() {
                        flightByIdMessage.html(
                            '<p>Error retrieving flight information.</p>');
                    }
                });
            } else {
                flightByIdMessage.html('<p>Please enter a Flight Booking ID.</p>');
            }
        });

        // Retrieve Hotel by Booking ID
        $('#retrieveHotelByIdButton').click(function() {
            const hotel_booking_id = $('#hotel_booking_id').val();
            const hotelByIdMessage = $('#hotelByIdMessage');

            if (hotel_booking_id) {
                $.ajax({
                    url: 'retrieve_booked_hotels.php',
                    type: 'POST',
                    data: {
                        hotel_booking_id: hotel_booking_id
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.error) {
                            hotelByIdMessage.html(`<p>${response.error}</p>`);
                        } else {
                            hotelByIdMessage.html(`
                            <p><strong>Hotel Booking ID:</strong> ${response.hotel_booking_id}</p>
                            <p><strong>Hotel Name:</strong> ${response.hotel_name}</p>
                            <p><strong>City:</strong> ${response.city}</p>
                            <p><strong>Check-in Date:</strong> ${response.check_in_date}</p>
                            <p><strong>Check-out Date:</strong> ${response.check_out_date}</p>
                            <p><strong>Number of Rooms:</strong> ${response.number_of_rooms}</p>
                            <p><strong>Total Price:</strong> $${response.total_price}</p>
                        `);
                        }
                    },
                    error: function() {
                        hotelByIdMessage.html('<p>Error retrieving hotel information.</p>');
                    }
                });
            } else {
                hotelByIdMessage.html('<p>Please enter a Hotel Booking ID.</p>');
            }
        });
    });
    $('#retrieveTexasBookingsButton').click(function() {
        const texasBookingsMessage = $('#texasBookingsMessage');

        $.ajax({
            url: 'adminTexas.php',
            type: 'POST',
            success: function(response) {
                texasBookingsMessage.html(response);
            },
            error: function() {
                texasBookingsMessage.html('<p>Error retrieving Texas bookings.</p>');
            }
        });
    });



    // Retrieve Most Expensive Hotel
    $('#retrieveExpensiveHotelButton').click(function() {
        const expensiveHotelMessage = $('#expensiveHotelMessage');
        if (expensiveHotelMessage.is(':hidden')) {
            $.ajax({
                url: 'retrieve_ExpensiveHotel.php', // Backend script to fetch expensive hotel data
                type: 'POST',
                dataType: 'json',
                success: function(response) {
                    if (response.error) {
                        expensiveHotelMessage.html(`<p>${response.error}</p>`);
                    } else {
                        expensiveHotelMessage.html(`
                        <p><strong>Hotel Booking ID:</strong> ${response.hotel_booking_id}</p>
                        <p><strong>Hotel Name:</strong> ${response.hotel_name}</p>
                        <p><strong>City:</strong> ${response.city}</p>
                        <p><strong>Check-in Date:</strong> ${response.check_in_date}</p>
                        <p><strong>Check-out Date:</strong> ${response.check_out_date}</p>
                        <p><strong>Number of Rooms:</strong> ${response.number_of_rooms}</p>
                        <p><strong>Total Price:</strong> $${response.total_price}</p>
                    `);
                    }
                    expensiveHotelMessage.show();
                    $('#retrieveExpensiveHotelButton').text(
                        'Hide Expensive Hotel Info');
                },
                error: function() {
                    expensiveHotelMessage.html(
                        '<p>Error retrieving the most expensive hotel.</p>');
                },
            });
        } else {
            expensiveHotelMessage.hide();
            $('#retrieveExpensiveHotelButton').text('Retrieve Most Expensive Hotel');
        }
    });


    // Retrieve Most Expensive Flight
    $('#retrieveExpensiveFlightButton').click(function() {
        const expensiveInfoMessage = $('#expensiveInfoMessage');
        if (expensiveInfoMessage.is(':hidden')) {
            $.ajax({
                url: 'retrieve_expensive.php',
                type: 'POST',
                dataType: 'json',
                success: function(response) {
                    if (response.error) {
                        expensiveInfoMessage.html(`<p>${response.error}</p>`);
                    } else {
                        expensiveInfoMessage.html(`
                            <p><strong>Flight Booking ID:</strong> ${response.flight_booking_id}</p>
                            <p><strong>Flight ID:</strong> ${response.flight_id}</p>
                            <p><strong>Origin:</strong> ${response.origin}</p>
                            <p><strong>Destination:</strong> ${response.destination}</p>
                            <p><strong>Departure Date:</strong> ${response.departure_date}</p>
                            <p><strong>Arrival Date:</strong> ${response.arrival_date}</p>
                            <p><strong>Departure Time:</strong> ${response.departure_time}</p>
                            <p><strong>Arrival Time:</strong> ${response.arrival_time}</p>
                            <p><strong>Available Seats:</strong> ${response.available_seats}</p>
                            <p><strong>Price:</strong> $${response.price}</p>
                            <p><strong>Total Price:</strong> $${response.total_price}</p>
                        `);
                    }
                    expensiveInfoMessage.show();
                    $('#retrieveExpensiveFlightButton').text('Hide Expensive Info');
                },
                error: function() {
                    expensiveInfoMessage.html(
                        'Error retrieving most expensive flight.');
                }
            });
        } else {
            expensiveInfoMessage.hide();
            $('#retrieveExpensiveFlightButton').text('Retrieve Most Expensive Flight');
        }
    });


    // Retrieve Flights with Infants
    $('#retrieveInfantsButton').click(function() {
        const expensiveInfantMessage = $('#expensiveInfantMessage');
        if (expensiveInfantMessage.is(':hidden')) {
            $.ajax({
                url: 'retrieve_infant.php', // Ensure this path is correct
                type: 'POST',
                dataType: 'json',
                success: function(response) {
                    if (response.error) {
                        expensiveInfantMessage.html(`<p>${response.error}</p>`);
                    } else {
                        expensiveInfantMessage.html(`
                        <p><strong>Flight Booking ID:</strong> ${response.flight_booking_id}</p>
                        <p><strong>Flight ID:</strong> ${response.flight_id}</p>
                        <p><strong>Origin:</strong> ${response.origin}</p>
                        <p><strong>Destination:</strong> ${response.destination}</p>
                        <p><strong>Departure Date:</strong> ${response.departure_date}</p>
                        <p><strong>Arrival Date:</strong> ${response.arrival_date}</p>
                        <p><strong>Departure Time:</strong> ${response.departure_time}</p>
                        <p><strong>Arrival Time:</strong> ${response.arrival_time}</p>
                        <p><strong>Available Seats:</strong> ${response.available_seats}</p>
                        <p><strong>Price:</strong> $${response.price}</p>
                        <p><strong>Total Price:</strong> $${response.total_price}</p>
                    `);
                    }
                    expensiveInfantMessage.show();
                    $('#retrieveInfantsButton').text('Hide Flights with Infants');
                },
                error: function() {
                    expensiveInfantMessage.html(
                        '<p>Error retrieving flights with infants.</p>');
                },
            });
        } else {
            expensiveInfantMessage.hide();
            $('#retrieveInfantsButton').text('Retrieve Flights with Infants');
        }
    });


    // Retrieve Flights with Infant Passenger and At Least 2 Children
    $('#retrieveInfantChildrenButton').click(function() {
        const infantChildrenMessage = $('#infantChildrenMessage');
        if (infantChildrenMessage.is(':hidden')) {
            $.ajax({
                url: 'retrieve_2Kids.php', // Backend script to fetch data
                type: 'POST',
                dataType: 'json',
                success: function(response) {
                    if (response.error) {
                        infantChildrenMessage.html(`<p>${response.error}</p>`);
                    } else {
                        let output =
                            '<h4>Flights with Infant Passenger and At Least 2 Children</h4>';
                        response.forEach((flight) => {
                            output += `
                            <p><strong>Flight Booking ID:</strong> ${flight.flight_booking_id}</p>
                            <p><strong>Flight ID:</strong> ${flight.flight_id}</p>
                            <p><strong>Origin:</strong> ${flight.origin}</p>
                            <p><strong>Destination:</strong> ${flight.destination}</p>
                            <p><strong>Departure Date:</strong> ${flight.departure_date}</p>
                            <p><strong>Arrival Date:</strong> ${flight.arrival_date}</p>
                            <p><strong>Departure Time:</strong> ${flight.departure_time}</p>
                            <p><strong>Arrival Time:</strong> ${flight.arrival_time}</p>
                            <p><strong>Available Seats:</strong> ${flight.available_seats}</p>
                            <p><strong>Price:</strong> $${flight.price}</p>
                            <p><strong>Total Price:</strong> $${flight.total_price}</p>
                            <hr>
                        `;
                        });
                        infantChildrenMessage.html(output);
                    }
                    infantChildrenMessage.show();
                    $('#retrieveInfantChildrenButton').text('Hide Flights');
                },
                error: function() {
                    infantChildrenMessage.html('<p>Error retrieving flights.</p>');
                }
            });
        } else {
            infantChildrenMessage.hide();
            $('#retrieveInfantChildrenButton').text('Retrieve Flights');
        }
    });


    // Retrieve Flights from Texas without Infants
    $('#retrieveFlightsNoInfantsButton').click(function() {
        const flightsNoInfantsMessage = $('#flightsNoInfantsMessage');
        if (flightsNoInfantsMessage.is(':hidden')) {
            $.ajax({
                url: 'retrieve_no_infants.php', // Ensure this file path is correct
                type: 'POST',
                dataType: 'json',
                success: function(response) {
                    if (response.error) {
                        flightsNoInfantsMessage.html(`<p>${response.error}</p>`);
                    } else {
                        let flightsHTML =
                            '<h5>Flights from Texas without Infants:</h5><ul>';
                        response.forEach(flight => {
                            flightsHTML += `
                            <li>
                                <p><strong>Flight Booking ID:</strong> ${flight.flight_booking_id}</p>
                                <p><strong>Flight ID:</strong> ${flight.flight_id}</p>
                                <p><strong>Origin:</strong> ${flight.origin}</p>
                                <p><strong>Destination:</strong> ${flight.destination}</p>
                                <p><strong>Departure Date:</strong> ${flight.departure_date}</p>
                                <p><strong>Arrival Date:</strong> ${flight.arrival_date}</p>
                                <p><strong>Departure Time:</strong> ${flight.departure_time}</p>
                                <p><strong>Arrival Time:</strong> ${flight.arrival_time}</p>
                                <p><strong>Available Seats:</strong> ${flight.available_seats}</p>
                                <p><strong>Price:</strong> $${flight.price}</p>
                                <p><strong>Total Price:</strong> $${flight.total_price}</p>
                            </li>
                        `;
                        });
                        flightsHTML += '</ul>';
                        flightsNoInfantsMessage.html(flightsHTML);
                    }
                    flightsNoInfantsMessage.show();
                    $('#retrieveFlightsNoInfantsButton').text('Hide Flights');
                },
                error: function() {
                    flightsNoInfantsMessage.html(
                        '<p>Error retrieving flights from Texas without infants.</p>'
                    );
                }
            });
        } else {
            flightsNoInfantsMessage.hide();
            $('#retrieveFlightsNoInfantsButton').text('Retrieve Flights');
        }
    });


    // Retrieve Flights to California
    $('#retrieveCaliforniaFlightsButton').click(function() {
        const californiaFlightsMessage = $('#californiaFlightsMessage');
        if (californiaFlightsMessage.is(':hidden')) {
            $.ajax({
                url: 'retrieve_california_flights.php', // Ensure the file path is correct
                type: 'POST',
                dataType: 'json',
                success: function(response) {
                    if (response.error) {
                        californiaFlightsMessage.html(`<p>${response.error}</p>`);
                    } else {
                        let flightsHTML =
                            `<p>Total Flights: ${response.total_flights}</p><ul>`;
                        response.flights.forEach(flight => {
                            flightsHTML += `
                        <li>
                            <p><strong>Flight ID:</strong> ${flight.flight_id}</p>
                            <p><strong>Origin:</strong> ${flight.origin}</p>
                            <p><strong>Destination:</strong> ${flight.destination}</p>
                            <p><strong>Departure Date:</strong> ${flight.departure_date}</p>
                            <p><strong>Arrival Date:</strong> ${flight.arrival_date}</p>
                            <p><strong>Departure Time:</strong> ${flight.departure_time}</p>
                            <p><strong>Arrival Time:</strong> ${flight.arrival_time}</p>
                            <p><strong>Price:</strong> $${flight.price}</p>
                        </li><hr>`;
                        });
                        flightsHTML += '</ul>';
                        californiaFlightsMessage.html(flightsHTML);
                    }
                    californiaFlightsMessage.show();
                    $('#retrieveCaliforniaFlightsButton').text(
                        'Hide California Flights Info');
                },
                error: function() {
                    californiaFlightsMessage.html(
                        '<p>Error retrieving flights to California.</p>');
                }
            });
        } else {
            californiaFlightsMessage.hide();
            $('#retrieveCaliforniaFlightsButton').text('Retrieve California Flights');
        }
    });










    // Toggle Hotels
    $('#toggleHotelsButton').click(function() {
        const hotelsContainer = $('#hotelsContainer');
        const hotelsTableBody = $('#hotelsTableBody');

        if (hotelsContainer.is(':hidden')) {
            $.ajax({
                url: 'showHotelsSQL.php',
                type: 'GET',
                dataType: 'json',
                success: function(hotels) {
                    if (hotels.error) {
                        alert(hotels.error);
                    } else {
                        hotelsTableBody.empty();
                        hotels.forEach((hotel) => {
                            hotelsTableBody.append(`
                                <tr>
                                    <td>${hotel.hotel_id}</td>
                                    <td>${hotel.hotel_name}</td>
                                    <td>${hotel.city}</td>
                                    <td>${hotel.available_rooms}</td>
                                    <td>${hotel.check_in_date}</td>
                                    <td>${hotel.check_out_date}</td>
                                    <td>${hotel.price_per_night}</td>
                                </tr>
                            `);
                        });
                        hotelsContainer.show();
                        $('#toggleHotelsButton').text('Hide All Hotels');
                    }
                },
                error: function() {
                    alert('Error fetching hotels.');
                }
            });
        } else {
            hotelsContainer.hide();
            $('#toggleHotelsButton').text('Show All Hotels');
        }
    });

    // Toggle Flights
    $('#toggleFlightsButton').click(function() {
        const flightsContainer = $('#flightsContainer');
        const flightsTableBody = $('#flightsTableBody');

        if (flightsContainer.is(':hidden')) {
            $.ajax({
                url: 'showFlightsSQL.php',
                type: 'GET',
                dataType: 'json',
                success: function(flights) {
                    if (flights.error) {
                        alert(flights.error);
                    } else {
                        flightsTableBody.empty();
                        flights.forEach((flight) => {
                            flightsTableBody.append(`
                                <tr>
                                    <td>${flight.flight_id}</td>
                                    <td>${flight.origin}</td>
                                    <td>${flight.destination}</td>
                                    <td>${flight.departure_date}</td>
                                    <td>${flight.arrival_date}</td>
                                    <td>${flight.departure_time}</td>
                                    <td>${flight.arrival_time}</td>
                                    <td>${flight.price}</td>
                                </tr>
                            `);
                        });
                        flightsContainer.show();
                        $('#toggleFlightsButton').text('Hide All Flights');
                    }
                },
                error: function() {
                    alert('Error fetching flights.');
                }
            });
        } else {
            flightsContainer.hide();
            $('#toggleFlightsButton').text('Show All Flights');
        }
    });
    </script>
</body>

</html>