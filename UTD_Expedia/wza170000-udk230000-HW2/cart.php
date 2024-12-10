<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Cart - Flight Booking</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <header class="row">
        <div class="header-data">
            <span>CS 6314</span><br>
            <span>Assignment #3</span>
        </div>
        <div id="datetime"></div>

        <?php
            if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
                echo "<div>Welcome, " . $_SESSION['firstname'] . " " . $_SESSION['lastname'] . "</div>";
                echo '<a href="logout.php" style="margin-left: 10px; text-decoration: none; color: #007BFF;">Sign Out</a>';
            }
            ?>
    </header>

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

    <div class="row container">
        <section class="sidesection">
            <h2>Customization Controls :</h2>
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
            <h2>Your Cart</h2>
            <div id="cartDetails"></div>

            <h3>Book Your Flight</h3>
            <form id="bookingForm" onsubmit="processBooking(event)">
                <div id="passengerDetails"></div>
                <button type="submit">Book Flight</button>
            </form>

            <h3>Book Your Stays</h3>
            <div id="stayDetails"></div>
            <button id="bookHotelButton" onclick="bookHotel()">Book Hotel</button>
            <div id="hotelSummary"></div><br> 
            
            <button id="clearCartButton" onclick="clearCart()">Clear Cart</button>

     
        </section>
    </div>

    <footer class="row">
        <h3>Developer Details</h3>
        <span>First Name: Wajih</span><br>
        <span>Last Name: Anwar</span><br>
        <span>Net ID: WZA170000</span><br>
        <span>Section Number: 6314.002</span>
    </footer>

    <script>
function displayCartDetails() {

    let cart = JSON.parse(localStorage.getItem('cart')) || { departingFlight: null, returningFlight: null, stays: [] };

    if (!Array.isArray(cart.stays)) {
        cart.stays = [];
    }

    console.log("Cart Data:", cart); // Debugging

    let cartDetails = document.getElementById('cartDetails');
    let stayDetails = document.getElementById('stayDetails');
    let totalPrice = 0;

    cartDetails.innerHTML = "";
    stayDetails.innerHTML = "";

    // Display Departing Flight
    if (cart.departingFlight) {
        totalPrice += parseFloat(cart.departingFlight.totalPrice);
        cartDetails.innerHTML += `
            <h3>Departing Flight</h3>
            <p><strong>Flight ID:</strong> ${cart.departingFlight.flightId}</p>
            <p><strong>Origin:</strong> ${cart.departingFlight.origin}</p>
            <p><strong>Destination:</strong> ${cart.departingFlight.destination}</p>
            <p><strong>Departure Date:</strong> ${cart.departingFlight.depDate}</p>
            <p><strong>Arrival Date:</strong> ${cart.departingFlight.arrDate}</p>
            <p><strong>Total Price:</strong> $${parseFloat(cart.departingFlight.totalPrice).toFixed(2)}</p>
            <p><strong>Passengers:</strong></p>
            <ul>
                <li><strong>Adults:</strong> ${cart.departingFlight.adults}</li>
                <li><strong>Children:</strong> ${cart.departingFlight.children}</li>
                <li><strong>Infants:</strong> ${cart.departingFlight.infants}</li>
            </ul>
        `;
    }

    // Display Returning Flight
    if (cart.returningFlight) {
        totalPrice += parseFloat(cart.returningFlight.totalPrice);
        cartDetails.innerHTML += `
            <h3>Returning Flight</h3>
            <p><strong>Flight ID:</strong> ${cart.returningFlight.flightId}</p>
            <p><strong>Origin:</strong> ${cart.returningFlight.origin}</p>
            <p><strong>Destination:</strong> ${cart.returningFlight.destination}</p>
            <p><strong>Departure Date:</strong> ${cart.returningFlight.depDate}</p>
            <p><strong>Arrival Date:</strong> ${cart.returningFlight.arrDate}</p>
            <p><strong>Total Price:</strong> $${parseFloat(cart.returningFlight.totalPrice).toFixed(2)}</p>
            <p><strong>Passengers:</strong></p>
            <ul>
                <li><strong>Adults:</strong> ${cart.returningFlight.adults}</li>
                <li><strong>Children:</strong> ${cart.returningFlight.children}</li>
                <li><strong>Infants:</strong> ${cart.returningFlight.infants}</li>
            </ul>
        `;
    }

    // Display Hotel Stays
    if (cart.stays.length > 0) {
        cart.stays.forEach((stay, index) => {
            //Debugging
            console.log("Stay Details:", stay); 
            totalPrice += parseFloat(stay.totalPrice);
            stayDetails.innerHTML += `
                <h3>Hotel Stay #${index + 1}</h3>
                <p><strong>Hotel Name:</strong> ${stay.hotelName}</p>
                <p><strong>City:</strong> ${stay.city}</p>
                <p><strong>Check-In Date:</strong> ${stay.checkInDate}</p>
                <p><strong>Check-Out Date:</strong> ${stay.checkOutDate}</p>
                <p><strong>Number of Rooms:</strong> ${stay.numberOfRooms}</p>
                <p><strong>Guests:</strong></p>
                <ul>
                    <li><strong>Adults:</strong> ${stay.adults}</li>
                    <li><strong>Children:</strong> ${stay.children}</li>
                    <li><strong>Infants:</strong> ${stay.infants}</li>
                </ul>

                <p><strong>Price per Night:</strong> $${parseFloat(stay.pricePerNight).toFixed(2)}</p>
                <p><strong>Total Price:</strong> $${parseFloat(stay.totalPrice).toFixed(2)}</p>
                <hr>
            `;
        });

        // Display guest details for hotels
        displayGuestDetailsForHotels(cart);
    } else {
        stayDetails.innerHTML += "<p>No hotel bookings in cart.</p>";
    }

    // Display Total Price (Flights + Hotels)
    cartDetails.innerHTML += `
        <h3>Total Price (Including Flights and Hotels):</h3>
        <p><strong>Total Price:</strong> $${totalPrice.toFixed(2)}</p>
    `;

    // Populate Passenger Details for Flights
    displayPassengerDetails(cart);
}

function displayPassengerDetails(cart) {
    const form = document.getElementById('passengerDetails');
    form.innerHTML = "";
    let passengerIndex = 0;

    function appendPassengerDetails(count, category) {
        for (let i = 0; i < count; i++) {
            const passengerLabel = `${capitalizeFirstLetter(category)} ${i + 1}`;
            form.innerHTML += `
                <h4>${passengerLabel}</h4>
                <label for="firstName${passengerIndex}">First Name:</label>
                <input type="text" id="firstName${passengerIndex}" name="firstName${passengerIndex}" required><br>
                <label for="lastName${passengerIndex}">Last Name:</label>
                <input type="text" id="lastName${passengerIndex}" name="lastName${passengerIndex}" required><br>
                <label for="dob${passengerIndex}">Date of Birth:</label>
                <input type="date" id="dob${passengerIndex}" name="dob${passengerIndex}" required><br>
                <label for="ssn${passengerIndex}">SSN:</label>
                <input type="text" id="ssn${passengerIndex}" name="ssn${passengerIndex}" required><br><br>
            `;
            passengerIndex++;
        }
    }

    if (cart.departingFlight) {
        appendPassengerDetails(cart.departingFlight.adults, "adult");
        appendPassengerDetails(cart.departingFlight.children, "child");
        appendPassengerDetails(cart.departingFlight.infants, "infant");
    }
}

function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

function processBooking(event) {
    event.preventDefault();

    let bookingNumberDeparting = generateBookingNumber();
    let bookingNumberReturning = generateBookingNumber();
    let passengers = [];
    let cart = JSON.parse(localStorage.getItem('cart')) || { departingFlight: null, returningFlight: null };

    console.log("Cart Data Before Processing:", cart);

    if (cart.departingFlight) {
        passengers = passengers.concat(collectPassengerDetails(cart.departingFlight, "departing"));
    }

    if (cart.returningFlight) {
        passengers = passengers.concat(collectPassengerDetails(cart.returningFlight, "returning"));
    }

    let bookingData = {
        bookingNumberDeparting: bookingNumberDeparting,
        bookingNumberReturning: cart.returningFlight ? bookingNumberReturning : null,
        departingFlight: cart.departingFlight,
        returningFlight: cart.returningFlight,
        passengers: passengers,
    };

    console.log("Booking Data:", bookingData);

    displayBookingSummary(bookingData);
    saveBookingToServer(bookingData);

}

function displayBookingSummary(bookingData) {
    const mainSection = document.querySelector('.mainsection');
    let summaryHtml = `<h2>Booking Summary</h2>`;

    // Display Departing Flight
    if (bookingData.departingFlight) {
        summaryHtml += `
            <h3>Departing Flight</h3>
            <p><strong>Booking Number:</strong> ${bookingData.bookingNumberDeparting}</p>
            <p><strong>Origin:</strong> ${bookingData.departingFlight.origin}</p>
            <p><strong>Destination:</strong> ${bookingData.departingFlight.destination}</p>
            <p><strong>Departure Date:</strong> ${bookingData.departingFlight.depDate}</p>
            <p><strong>Arrival Date:</strong> ${bookingData.departingFlight.arrDate}</p>
            <p><strong>Total Price:</strong> $${bookingData.departingFlight.totalPrice}</p>
        `;

        // Passengers for Departing Flight
        summaryHtml += `<h4>Passengers for Departing Flight</h4><ul>`;
        bookingData.passengers.forEach((passenger) => {
            if (passenger.flightType === "departing") {
                summaryHtml += `
                    <li>${passenger.firstName} ${passenger.lastName} (${passenger.category}, DOB: ${passenger.dob}, SSN: ${passenger.ssn})</li>
                `;
            }
        });
        summaryHtml += `</ul>`;
    }

    // Display Returning Flight
    if (bookingData.returningFlight) {
        summaryHtml += `
            <h3>Returning Flight</h3>
            <p><strong>Booking Number:</strong> ${bookingData.bookingNumberReturning}</p>
            <p><strong>Origin:</strong> ${bookingData.returningFlight.origin}</p>
            <p><strong>Destination:</strong> ${bookingData.returningFlight.destination}</p>
            <p><strong>Departure Date:</strong> ${bookingData.returningFlight.depDate}</p>
            <p><strong>Arrival Date:</strong> ${bookingData.returningFlight.arrDate}</p>
            <p><strong>Total Price:</strong> $${bookingData.returningFlight.totalPrice}</p>
        `;

        // Passengers for Returning Flight
        summaryHtml += `<h4>Passengers for Returning Flight</h4><ul>`;
        bookingData.passengers.forEach((passenger) => {
            if (passenger.flightType === "returning") {
                summaryHtml += `
                    <li>${passenger.firstName} ${passenger.lastName} (${passenger.category}, DOB: ${passenger.dob}, SSN: ${passenger.ssn})</li>
                `;
            }
        });
        summaryHtml += `</ul>`;
    }

    // Append the summary to the main section
    const bookingSummary = document.createElement('div');
    bookingSummary.innerHTML = summaryHtml;
    mainSection.appendChild(bookingSummary);
}


function collectPassengerDetails(flight, flightType) {
    let passengers = [];
    let passengerIndex = 0;

    const appendPassengers = (count, category) => {
        for (let i = 0; i < count; i++) {
            passengers.push({
                firstName: document.getElementById(`firstName${passengerIndex}`).value,
                lastName: document.getElementById(`lastName${passengerIndex}`).value,
                dob: document.getElementById(`dob${passengerIndex}`).value,
                ssn: document.getElementById(`ssn${passengerIndex}`).value,
                category: category,
                flightType: flightType
            });
            passengerIndex++;
        }
    };

    appendPassengers(flight.adults, 'adult');
    appendPassengers(flight.children, 'child');
    appendPassengers(flight.infants, 'infant');

    return passengers;
}


//Found online
function generateBookingNumber() {
    const timestamp = Date.now();
    const randomNum = Math.floor(Math.random() * 1000);
    return `BN${timestamp}${randomNum}`;
}

//Save Flight
function saveBookingToServer(bookingInfo) {
    console.log("Booking Info Sent to Server:", JSON.stringify(bookingInfo, null, 2));

    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'bookFlight.php', true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.onload = function () {
        console.log("Server Response:", xhr.responseText);

        if (xhr.status === 200) {
            alert('Booking information saved successfully.');
        } else {
            console.error('Error saving booking information:', xhr.responseText);
        }
    };
    xhr.send(JSON.stringify(bookingInfo));

}

function displayGuestDetailsForHotels(cart) {
    const stayDetails = document.getElementById('stayDetails');
    stayDetails.innerHTML = ""; 

    let guestIndex = 0;

    if (!cart.stays || cart.stays.length === 0) {
        stayDetails.innerHTML = "<p>No hotel bookings in the cart.</p>";
        return;
    }

    cart.stays.forEach((stay, stayIndex) => {
        stayDetails.innerHTML += `
            <h3>Guest Details for Hotel Stay ${stayIndex + 1}</h3>
            <p><strong>Hotel Name:</strong> ${stay.hotelName}</p>
            <p><strong>City:</strong> ${stay.city}</p>
            <p><strong>Check-in Date:</strong> ${stay.checkInDate}</p>
            <p><strong>Check-out Date:</strong> ${stay.checkOutDate}</p>
            <p><strong>Number of Rooms:</strong> ${stay.numberOfRooms}</p>
            <p><strong>Total Guests:</strong> Adults: ${stay.adults}, Children: ${stay.children}, Infants: ${stay.infants}</p>
        `;

        // Add input forms for adult guests
        for (let i = 0; i < stay.adults; i++) {
            stayDetails.innerHTML += `
                <h4>Adult ${i + 1}</h4>
                <label for="guestFirstName${guestIndex}">First Name:</label>
                <input type="text" id="guestFirstName${guestIndex}" name="guestFirstName${guestIndex}" required><br>
                <label for="guestLastName${guestIndex}">Last Name:</label>
                <input type="text" id="guestLastName${guestIndex}" name="guestLastName${guestIndex}" required><br>
                <label for="guestDOB${guestIndex}">Date of Birth:</label>
                <input type="date" id="guestDOB${guestIndex}" name="guestDOB${guestIndex}" required><br>
                <label for="guestSSN${guestIndex}">SSN:</label>
                <input type="text" id="guestSSN${guestIndex}" name="guestSSN${guestIndex}" required><br><br>
            `;
            guestIndex++;
        }

        // Add input forms for child guests
        for (let i = 0; i < stay.children; i++) {
            stayDetails.innerHTML += `
                <h4>Child ${i + 1}</h4>
                <label for="guestFirstName${guestIndex}">First Name:</label>
                <input type="text" id="guestFirstName${guestIndex}" name="guestFirstName${guestIndex}" required><br>
                <label for="guestLastName${guestIndex}">Last Name:</label>
                <input type="text" id="guestLastName${guestIndex}" name="guestLastName${guestIndex}" required><br>
                <label for="guestDOB${guestIndex}">Date of Birth:</label>
                <input type="date" id="guestDOB${guestIndex}" name="guestDOB${guestIndex}" required><br>
                <label for="guestSSN${guestIndex}">SSN:</label>
                <input type="text" id="guestSSN${guestIndex}" name="guestSSN${guestIndex}" required><br><br>
            `;
            guestIndex++;
        }

        // Add input forms for infant guests
        for (let i = 0; i < stay.infants; i++) {
            stayDetails.innerHTML += `
                <h4>Infant ${i + 1}</h4>
                <label for="guestFirstName${guestIndex}">First Name:</label>
                <input type="text" id="guestFirstName${guestIndex}" name="guestFirstName${guestIndex}" required><br>
                <label for="guestLastName${guestIndex}">Last Name:</label>
                <input type="text" id="guestLastName${guestIndex}" name="guestLastName${guestIndex}" required><br>
                <label for="guestDOB${guestIndex}">Date of Birth:</label>
                <input type="date" id="guestDOB${guestIndex}" name="guestDOB${guestIndex}" required><br>
                <label for="guestSSN${guestIndex}">SSN:</label>
                <input type="text" id="guestSSN${guestIndex}" name="guestSSN${guestIndex}" required><br><br>
            `;
            guestIndex++;
        }
    });
}



function bookHotel() {
    const cart = JSON.parse(localStorage.getItem('cart')) || { stays: [] };

    if (cart.stays.length === 0) {
        alert("No hotel selected for booking.");
        return;
    }

    let bookingId = `HB${Date.now()}`; // Generate a unique booking ID
    let bookingDetails = [];
    let guestDetails = [];
    let guestIndex = 0;

    cart.stays.forEach((stay) => {
        // Prepare hotel-booking data
        bookingDetails.push({
            hotel_booking_id: bookingId,
            hotel_id: stay.hotelId,
            check_in_date: stay.checkInDate,
            check_out_date: stay.checkOutDate,
            num_rooms: stay.numberOfRooms,
            price_per_night: stay.pricePerNight,
            total_price: stay.totalPrice,
        });

        // Collect guest details for each category
        const totalGuests = stay.adults + stay.children + stay.infants;
        for (let i = 0; i < totalGuests; i++) {
            const firstName = document.getElementById(`guestFirstName${guestIndex}`).value;
            const lastName = document.getElementById(`guestLastName${guestIndex}`).value;
            const dob = document.getElementById(`guestDOB${guestIndex}`).value;
            const ssn = document.getElementById(`guestSSN${guestIndex}`).value;

            const category =
                i < stay.adults
                    ? "Adult"
                    : i < stay.adults + stay.children
                    ? "Child"
                    : "Infant";

            guestDetails.push({
                ssn: ssn,
                hotel_booking_id: bookingId,
                first_name: firstName,
                last_name: lastName,
                dob: dob,
                category: category,
            });

            guestIndex++;
        }
    });

    // Send data to the server
    sendBookingToServer(bookingDetails, guestDetails, cart);
}


//Book hotel to sql 
function sendBookingToServer(bookingDetails, guestDetails, cart) {
    const payload = { bookingDetails, guestDetails };

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "bookHotel.php", true);
    xhr.setRequestHeader("Content-Type", "application/json");
    xhr.onload = function () {
        if (xhr.status === 200) {
            alert("Hotel booking saved successfully.");
            console.log("Server Response:", xhr.responseText);

            // Display the booking summary after booking
            displayHotelSummary(bookingDetails, guestDetails, cart);
        } else {
            alert("Failed to save hotel booking. Please try again.");
            console.error("Error:", xhr.responseText);
        }
    };
    xhr.onerror = function () {
        alert("A network error occurred. Please check your connection and try again.");
    };
    xhr.send(JSON.stringify(payload));
}
function displayHotelSummary(bookingDetails, guestDetails, cart) {
    const hotelSummary = document.getElementById('hotelSummary');
    hotelSummary.innerHTML = ""; 

    bookingDetails.forEach((booking) => {
        let summaryHtml = `
            <h3>Hotel Booking Summary</h3>
            <p><strong>Booking ID:</strong> ${booking.hotel_booking_id}</p>
            <p><strong>Hotel ID:</strong> ${booking.hotel_id}</p>
            <p><strong>Check-In Date:</strong> ${booking.check_in_date}</p>
            <p><strong>Check-Out Date:</strong> ${booking.check_out_date}</p>
            <p><strong>Number of Rooms:</strong> ${booking.num_rooms}</p>
            <p><strong>Price per Night:</strong> $${booking.price_per_night}</p>
            <p><strong>Total Price:</strong> $${booking.total_price}</p>
            <h4>Guests</h4>
            <ul>
        `;

        guestDetails.forEach((guest) => {
            if (guest.hotel_booking_id === booking.hotel_booking_id) {
                summaryHtml += `
                    <li>
                        <strong>${guest.category}:</strong> ${guest.first_name} ${guest.last_name}, 
                        DOB: ${guest.dob}, SSN: ${guest.ssn}
                    </li>
                `;
            }
        });

        summaryHtml += `</ul>`;
        hotelSummary.innerHTML += summaryHtml;
    });
}






function clearCart() {
    localStorage.removeItem('cart');
    document.getElementById('cartDetails').innerHTML = "<p>Your cart is now empty.</p>";
    document.getElementById('passengerDetails').innerHTML = "";
    document.getElementById('stayDetails').innerHTML = "<p>No hotel bookings in cart.</p>";
    document.getElementById('bookingForm').reset();
    document.getElementById('hotelSummary').innerHTML = ""; 

    // Remove the booking summary
    const bookingSummaryDiv = document.querySelector('.mainsection div:last-child');
    if (bookingSummaryDiv && bookingSummaryDiv.innerHTML.includes('Booking Summary')) {
        bookingSummaryDiv.remove();
    }
}



window.onload = function () {
    displayCartDetails();
};



    </script>


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