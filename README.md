### Description

A web-based Customer Relationship Management (CRM) application showcasing full-stack development skills using Vue.js and Laravel. This application enables users to manage customer information, including the ability to add, update, delete, and view customer details.

### Technology Stack:

Frontend: Vue.js
Backend: Laravel
Database: MySQL
Testing: PHPUnit
Documentation: Scribe

### Key Features:

The project showcases two different approaches to development:

1. Manual Development: Demonstrates skills in working with Laravel and Vue, including the use of both Composition API and Options API in Vue. 

2. Backpack Integration: Demonstrates the ability to integrate and leverage third-party libraries to speed up development.

The root assets folder contains screenshots, including the client index page after authentication.
Additionally, the project includes testing and RESTful API documentation: APP_URL/docs

For testing authenticated requests, include the following in the Authorization header field: Bearer {token}. Replace {token} with the actual token you receive after logging in or registeriion


### Installation

1. Navigate to the server directory using terminal 
2. Create .env file - cp .env.example .env
3. Connect your MySQL database, create a schema for the project and update .env
4. Execute composer install
5. Run wev server and MySQL server
6. Set application key - php artisan key:generate --ansi
7. Execute migrations and seed data - php artisan migrate --seed
8. Navigate to the client directory using terminal 
9. Execute npm install
10. Generate documentation: php artisan scribe:generate
11. Start client: vite server - npm run dev
12. Start server: Artisan server - php artisan serve

