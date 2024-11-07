

# For the Generations

For the Generations is an online charity platform designed to streamline the donation process, making it easy and impactful for users to contribute to a variety of causes. This project, developed by Da Deebugers, connects users with diverse charities focused on health, social justice, environmental issues, and humanitarian efforts.

## Table of Contents
- [Project Overview](#project-overview)
- [Features](#features)
- [Getting Started](#getting-started)
- [File Structure](#file-structure)
- [Database Setup](#database-setup)
- [Technologies Used](#technologies-used)

## Project Overview 

At the core of For the Generations is a structured MySQL database that enables efficient management of charity and donor information. This database implementation is essential for ensuring data integrity, quick retrieval, and secure handling of sensitive information. The database holds information on:
- **Charity Organizations:** Details such as names, descriptions, and categories, allowing users to browse a wide array of causes.
- **Donor History:** A complete log of user contributions, making it possible for users to view their donation history and track their impact over time.

The database is integrated with PHP scripts (`display_table.php` and `displaydonor.php`) that dynamically retrieve and render data from the database. This setup ensures that users always see the most up-to-date information on available charities and their personal contribution history. Additionally, the database structure is optimized for scalability, allowing future extensions such as user accounts, personalized recommendations, and donation tracking. 

This project demonstrates the importance of database-driven applications in building scalable, secure, and data-intensive web platforms. 


## Features
- **Browse Charities:** Explore a variety of charity organizations and causes.
- **View Donation History:** Access historical records of contributions.
- **About Us:** Learn more about our mission and purpose.
- **Responsive Design:** A mobile-friendly layout for a seamless user experience on any device.

## Getting Started
To get a local copy up and running, follow these steps.

### Prerequisites
- A web server (e.g., XAMPP, WAMP)
- PHP 7 or higher
- MySQL database

### Installation
1. Clone the repository:
   ```bash
   git clone https://github.com/yourusername/for-the-generations.git
   ```
2. Place the files in your web server's directory.
3. Import the provided SQL file to set up the database.

## File Structure
- **Home.html:** Homepage featuring an introduction to the platform and easy access to charity browsing.
- **about.html:** About Us page describing the mission of For the Generations.
- **display_table.php:** Displays a list of charities available for browsing.
- **displaydonor.php:** Shows donor history.

## Database Setup
1. Open your MySQL database and import the SQL file included in this repository.
2. Ensure your database connection settings in `display_table.php` and `displaydonor.php` match your environment.

## Technologies Used
- **Frontend:** HTML5, CSS3 (Bootstrap 4.5), JavaScript
- **Backend:** PHP
- **Database:** MySQL
