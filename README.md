# AppPaws: Veterinary Clinic Management and Community Platform

## Project Goal

How can a single web-based platform support veterinary clinic appointment scheduling, pet medical records, and client community interactions?

AppPaws is an academic full-stack web application prototype developed around the operational needs of Happy Paws Animal Care, a veterinary clinic in Meycauayan, Bulacan.

The system was developed for academic demonstration using synthetic data. It was not officially adopted or integrated into the clinic's operations.

## Technology Stack

- **Backend:** PHP
- **Database:** MySQL
- **Frontend:** HTML, CSS, JavaScript
- **Architecture:** Server-rendered PHP pages, form handlers, relational database, and client-side JavaScript interactions

## Core Features

### User Authentication and Authorization

- User registration and login using PHP and MySQL.
- Password hashing and verification through PHP's password functions.
- Session-based authentication with customer and administrator roles.
- Separate administrative dashboard for managing clinic-related information.

### Appointment Management

- Appointment requests containing pet information, consultation dates, and reasons for visits.
- Pet identification and appointment records stored in MySQL.
- Date and appointment-capacity validation.
- Administrative approval and rejection of pending appointments.

### Pet Medical Records

- Relational storage of pet details and medical histories.
- Customer-specific record viewing based on associated accounts.
- Administrator access to registered pet records.
- Read-only medical history interface using demonstration records.

### Community Forum

- Community posts and image attachments.
- Post likes and comments.
- Database-backed storage and retrieval of community interactions.
- JavaScript-based interactive controls.

## Database Design

The relational MySQL database contains tables supporting:

- Users and account information
- Pets and ownership relationships
- Appointments
- Medical records
- Community posts
- Likes and comments

The database schema is defined in `database/happy_paws_schema.sql` and includes foreign-key relationships and synthetic demonstration data.

## Implementation

The application uses PHP scripts to process form submissions, authenticate users, manage sessions, and execute MySQL queries.

Prepared SQL statements are used across major database operations. JavaScript supports client-side interactions, including authentication forms and asynchronous community features.

The system separates reusable components such as database connections, headers, and footers from account handlers and application pages.

## Limitations

- The application is an academic prototype and was not deployed for operational use by the veterinary clinic.
- The database contains synthetic demonstration records rather than real clinic data.
- Runtime functionality has not been fully reverified during repository recovery.
- Some authentication, registration, and legacy community workflows require corrections.
- Authorization checks, CSRF protection, output escaping, and file-upload validation require improvements before public deployment.
- Database configuration and initialization scripts are intended for local demonstration and require hardening for hosted environments.
- The medical records module primarily supports viewing existing records rather than complete clinical record management.
- No automated test suite is currently included.

**This repository is preserved as an academic development project and should not be deployed publicly in its current state.**

## Reproducing the Project

### Prerequisites

- PHP-capable web server, such as Apache with PHP support
- MySQL or MariaDB
- PHP `mysqli` extension with `mysqlnd` support
- Web browser with JavaScript enabled

### Local Setup

1. Clone the repository:

   ```bash
   git clone https://github.com/Zieroed/AppPaws.git
   ```

2. Place the application in the web server's document root so it is accessible under `/AppPaws`.

3. Configure the local MySQL connection in the existing database configuration files.

4. Initialize the demonstration database using the provided SQL schema or the existing `init.php` initialization script in an isolated local environment.

5. Restrict or remove access to `init.php` after initialization.

6. Create a writable `uploads/` directory if testing community image uploads. Use only synthetic demonstration content.

7. Open the application locally:

   ```text
   http://localhost/AppPaws/
   ```

These instructions describe the expected local environment. They have not been fully verified through a fresh installation.

## Project Contributions

**Role: Lead Developer**

Led the development and integration of the application's PHP/MySQL backend, database-driven modules, and overall web application functionality.

Collaborated with four other team members on project requirements, frontend design, documentation, and presentation.

The project was developed as a collaborative academic requirement, with individual contributions described according to the team's reported responsibilities.