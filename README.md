# UTD Expedia

A travel booking web application built for CS 6314 (Web Programming Languages) at UT Dallas. UTD Expedia allows users to search, book, and manage flights, hotel stays, car rentals, and cruises.

## Tech Stack

- **Frontend:** HTML, CSS, JavaScript, jQuery 3.6.0
- **Backend:** PHP
- **Database:** MySQL (`cs6314`)
- **Server:** XAMPP (Apache + MySQL)
- **Data Formats:** XML, JSON

## Features

- **User Registration & Login** -- session-based authentication with admin/regular user roles
- **Flight Booking** -- search flights by origin, destination, and date; supports one-way and round-trip with passenger categories (adults, children, infants)
- **Hotel Stays** -- browse available hotels by city and date range with room allocation logic
- **Car Rentals** -- search car rentals by city, type, and dates
- **Cruise Booking** -- book cruises by destination, duration, and guest count
- **Shopping Cart** -- add flights and hotel stays to cart, view pricing, and complete bookings
- **Contact Form** -- submit inquiries saved to XML
- **Admin Dashboard** -- upload flight XML / hotel JSON, view all records, run database queries (expensive bookings, passenger lookups, filtered searches)

## Project Structure

```
wza170000-udk230000-HW2/
│
├── index.php              # Home page
├── flights.php            # Flight search & booking
├── stays.php              # Hotel search & booking
├── cars.php               # Car rental search
├── cruises.php            # Cruise booking
├── contactUs.php          # Contact form
├── cart.php               # Shopping cart & checkout
├── register.php           # User registration
├── login.php              # User login
├── my-account.php         # User/Admin dashboard
├── logout.php             # Session logout
│
├── api/                   # Backend API scripts
│   ├── login_process.php          # Login authentication
│   ├── registerUser.php           # User registration handler
│   ├── retrieveFlightsSQL.php     # Fetch flights from DB (returns XML)
│   ├── getHotels.php              # Fetch hotels from DB (returns JSON)
│   ├── saveCart.php               # Save cart data to JSON
│   ├── bookFlight.php             # Process flight booking
│   ├── bookHotel.php              # Process hotel booking
│   ├── contact.php                # Save contact form to XML
│   ├── uploadFlightsSQL.php       # Admin: upload flights XML to DB
│   ├── uploadHotelsSQL.php        # Admin: upload hotels JSON to DB
│   ├── showFlightsSql.php         # Admin: list all flights
│   ├── showHotelsSQL.php          # Admin: list all hotels
│   ├── adminTexas.php             # Admin: Texas bookings query
│   ├── retrieve_*.php             # Various retrieval queries
│   └── ...
│
├── data/                  # Data files
│   ├── bookings.json
│   ├── cart.json
│   ├── hotel.json
│   ├── contacts.xml
│   ├── flights.xml
│   └── hotels.xml
│
└── assets/
    └── css/
        └── style.css      # Global stylesheet
```

## Setup

1. Install [XAMPP](https://www.apachefriends.org/) and start Apache and MySQL
2. Create a MySQL database named `cs6314`
3. Place the `wza170000-udk230000-HW2` folder inside your XAMPP `htdocs` directory
4. Open `http://localhost/wza170000-udk230000-HW2/index.php` in your browser
5. Register a new account, or log in with the admin phone number `222-222-2222` to access admin features
6. Use the admin dashboard to upload `data/flights.xml` and `data/hotel.json` to populate the database

## Developers

- **Wajih Anwar** -- Net ID: WZA170000

