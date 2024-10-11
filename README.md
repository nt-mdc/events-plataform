# Event Management API

![Event Management](public/img/banner.png)

This is a Laravel-based API for managing events, attendees, and registrations. It provides functionalities for user authentication, event retrieval, and managing conference registrations.

## Features

- **Attendee Authentication**: Secure registration, login, and logout for attendees.
- **Event Management**: Retrieve events with associated conferences and tickets.
- **Registration Management**: Register attendees for conferences and remove registrations.
- **Organizer Interface**: A Server-Side Rendering (SSR) system that allows organizers to create events, channels, tickets, rooms, and conferences.

## API Documentation

You can find the complete API documentation, including all available endpoints, request parameters, and response formats, at the following URL:

http://your-app-url/docs

## Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/nt-mdc/event-management-api.git
   ```

2. Navigate to the project directory:
   ```bash
   cd event-management-api
   ```

3. Install PHP dependencies:
   ```bash
   composer install
   ```

4. Set up your `.env` file:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. Configure your email provider in the `.env` file by updating the following fields:
   ```dotenv
   MAIL_MAILER=smtp
   MAIL_HOST=smtp.example.com
   MAIL_PORT=587
   MAIL_USERNAME=your_email@example.com
   MAIL_PASSWORD=your_email_password
   MAIL_ENCRYPTION=tls
   MAIL_FROM_ADDRESS=your_email@example.com
   MAIL_FROM_NAME="${APP_NAME}"
   ```

6. Run migrations:
   ```bash
   php artisan migrate
   ```

7. Install front-end dependencies:
   ```bash
   npm install
   ```

8. Compile the assets:
   ```bash
   npm run dev
   ```

9. Start the server:
   ```bash
   php artisan serve
   ```
## Usage

You can use tools like Postman or curl to test the API endpoints. Ensure to include the authentication token in the header for protected routes.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
