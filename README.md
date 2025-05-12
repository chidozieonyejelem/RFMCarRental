<h1 align="center">RF Motors</h1>

<img width="1498" alt="Screenshot 2025-05-12 at 11 39 23" src="https://github.com/user-attachments/assets/afcc7f64-967c-463d-a8ac-7cb1adb18525" />

RF Motors is a car rental system web application that allows users to browse, book, and manage car rentals. The platform provides features for both users and administrators. Users can view available cars and make bookings. Administrators can manage cars, bookings, users, and messages from the dashboard. 

This was a group project I worked on with [jacobbibat](https://github.com/jacobbibat) and [Mateusz-gif](https://github.com/Mateusz-gif).

The information used to complete this project was from [SymfonyCasts PHP Courses](https://symfonycasts.com/tracks/php).

## Languages Used

- **HTML**: For structuring the content on the web pages.
- **CSS**: For styling the layout and providing a responsive and modern user interface.
- **PHP**: For server-side logic, handling form submissions, managing sessions, and interacting with the database.
- **MySQL**: For the database, storing car details, user data, booking information, etc.
- **PDO** (PHP Data Objects): For securely interacting with the database using prepared statements, ensuring protection against SQL injection.

## Features

### User Features
- **Browse Cars**: Users can filter and search available cars by make, model, year, and availability status.
- **Car Booking**: Users can select a car, pick rental dates, and proceed to the payment page.
- **Bookings Management**: Users can view and manage their bookings.
- **Messages**: Users can contact admins regarding any inquiries, and receive replies.

### Admin Features
- **Dashboard**: Admins can manage cars, users, and bookings.
- **Car Management**: Admins can view, add, update, and delete car records.
- **User Management**: Admins can view, edit, and delete user profiles.
- **Booking Management**: Admins can view and manage user bookings, including canceling or editing bookings.
- **Message Management**: Admins can view and reply to user inquiries/messages.

## Database Structure

The database consists of the following tables:
- **users**: Stores user data (e.g., name, email, phone number, isAdmin flag).
- **cars**: Contains car details (e.g., make, model, year, price, availability).
- **bookings**: Stores information about car bookings (e.g., userID, carID, start date, end date).
- **messages**: Contains user messages and admin replies.
- **contacts**: Stores user inquiries and admin replies.
- **payments**: Logs payment transactions for bookings.
