# AppPaws - Veterinary Clinic Management System

AppPaws is an academic full-stack veterinary clinic management prototype built with PHP, MySQL, JavaScript, HTML, and CSS. It was created for academic demonstration and is being preserved as evidence of development work for internship applications.

## Scope and status

- The application uses synthetic database records only.
- The veterinary clinic did not officially adopt or integrate the system.
- The project was temporarily hosted for academic demonstration, not production use.
- Public hosting, comprehensive security repairs, refactoring, and automated testing are explicitly postponed.
- The repository should not be represented as production-ready or as an officially deployed clinic system.

## Architecture verified from the repository

- PHP page and handler scripts provide the web application and server-side workflows.
- MySQL stores users, pets, appointments, medical records, community posts, likes, and comments.
- JavaScript provides modal authentication forms and asynchronous community interactions.
- `database/happy_paws_schema.sql` creates the database schema and seeds synthetic demonstration data.
- Authentication uses `password_hash()` and `password_verify()`, prepared statements, PHP sessions, and user/admin roles.
- The main implemented areas are registration/login, customer and admin views, appointment requests and approval, read-only pet medical records, and community posts, likes, and comments.

This architecture and the listed modules were verified by source inspection. Runtime behavior was not fully re-tested during recovery, so individual features should be described as implemented in the prototype rather than guaranteed production functionality.

## Local setup requirements

1. Use a PHP-capable web server such as Apache, Nginx with PHP-FPM, IIS, or an equivalent local stack.
2. Use MySQL or MariaDB with the `mysqli` extension enabled in PHP. Some handlers use `mysqli_stmt::get_result()`, which commonly requires `mysqlnd`.
3. Serve the project at `/AppPaws` unless the hardcoded application paths are updated.
4. Ensure the configured database account can create the `happy_paws` database, tables, foreign keys, and trigger.
5. Open `/AppPaws/init.php` once to initialize the schema and seed data, then remove or restrict access to that script.
6. Create a writable `uploads/` directory if testing community image uploads. Image-upload validation is not implemented.
7. Enable JavaScript in the browser.

The repository does not include Composer/npm dependencies, a deployment configuration, or automated tests. The existing PHP/MySQL architecture is not directly deployable to Vercel without changing the backend hosting model.

## Known limitations

These are known limitations of the recovered academic prototype, not claims of production readiness:

- `init.php` and database credentials are suitable only for a local demonstration environment.
- State-changing endpoints do not consistently implement CSRF protection.
- The appointment approval endpoint requires additional authorization checks before public exposure.
- File uploads lack server-side type, size, and content validation.
- Several outputs require stronger escaping before public hosting.
- Registration and some legacy community handlers require functional cleanup.
- Appointment capacity validation, transactions, and server-side input validation are limited.
- The medical-record view is primarily read-only and uses seeded demonstration records.

## Responsibility and resume attribution

Reported responsibility: lead developer. The repository supports the existence of the integrated PHP/MySQL modules described above, but source code alone cannot establish which individual authored each component. Teammate contributions primarily covered frontend design, documentation, and presentation, according to the project context.

## Resume entry - V0

**AppPaws - Veterinary Clinic Management System** | PHP, MySQL, JavaScript, HTML, CSS
*Lead Developer | Academic Full-Stack Prototype*

- Led development of a PHP/MySQL veterinary clinic management prototype integrating appointment scheduling, pet medical records, and community interactions.
- Implemented backend authentication using password hashing, prepared SQL statements, session management, and customer/admin role handling.
- Integrated a relational MySQL database supporting users, pets, appointments, medical records, posts, likes, and comments.

## Demo setup note

The original demo setup instructions and intentionally published demo-admin credentials are retained below for the academic recovery environment. Treat those credentials as public, demo-only credentials and never reuse them for a real deployment.