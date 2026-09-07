# Cinema Management System

## Project Overview

Cinema Management System is a Laravel-based application that provides a complete cinema management solution through two separate interfaces:

- Admin Dashboard built with Blade Templates.
- RESTful API for end users and mobile applications.

The system allows administrators to manage movies, halls, showtimes, and bookings, while users can browse movies, create bookings, manage their watch list, and receive AI-powered recommendations.

---

## Backend Architecture

### MVC Architecture

- Organized using Laravel MVC pattern.
- Clear separation between Models, Controllers, and Views.
- Business logic separated from presentation layer.
- Maintainable and scalable project structure.

### Service Layer

- Dedicated service for AI integration.
- Business logic isolated from controllers.
- Improved code readability and maintainability.

### Dependency Injection

- Service injection through Laravel container.
- Loose coupling between application components.
- Improved maintainability and scalability.
- Cleaner controller implementation.

---

## Authentication & Authorization

### Session Authentication

Used for the Admin Dashboard.

- Secure login system for administrators.
- Laravel session management.
- Protected admin routes.
- Session-based authentication workflow.

### Token Authentication

Used for API users through Laravel Sanctum.

- API token generation.
- Secure authenticated requests.
- User logout and token revocation.
- Stateless authentication for frontend and mobile applications.

### Role Based Access Control

- Admin role management.
- User role management.
- Middleware-based authorization.
- Protected resources based on user permissions.

---

## REST API Development

### API Design

- RESTful endpoint structure.
- Resource-oriented routes.
- Proper HTTP methods usage.
- Consistent API responses.

### API Resources

Used to standardize API output.

- User Resource.
- Movie Resource.
- Booking Resource.
- Showtime Resource.
- Seat Resource.

Benefits:

- Clean JSON responses.
- Controlled data exposure.
- Consistent response formatting.

---

## Request Validation

### Form Request Validation

Dedicated Request classes used for validation.

Examples:

- Login Request.
- Register Request.
- Booking Request.
- Movie Request.
- Hall Request.
- Showtime Request.
- AI Request.

Benefits:

- Clean controllers.
- Centralized validation logic.
- Improved security and maintainability.

---

## Database Design

### Relational Database Modeling

Designed using relational database principles.

Entities include:

- Users
- Movies
- Halls
- Showtimes
- Bookings
- Seats
- Genres
- Ticket Prices

### Database Relationships

Implemented using Eloquent ORM.

Examples:

- One To Many Relationships.
- Many To Many Relationships.
- Foreign Key Constraints.
- Data Integrity Management.

### Database Migrations

- Version controlled schema management.
- Reproducible database structure.
- Easy deployment process.

---

## Eloquent ORM

### Data Retrieval

- find()
- where()
- first()
- get()
- eager loading

### Data Manipulation

- create()
- update()
- delete()

### Query Optimization

- Relationship loading.
- Cleaner database interactions.
- Reduced query complexity.

---

## Routing

- Resource routes.
- API routes.
- Route groups.
- Middleware-protected routes.
- Organized route structure.

---

## Admin Dashboard

### Movie Management

- Add movies.
- Edit movies.
- Delete movies.
- View movies.

### Hall Management

- Create halls.
- Update hall information.
- Remove halls.

### Showtime Management

- Create showtimes.
- Edit showtimes.
- Delete showtimes.

### Booking Management

- View bookings.
- Manage booking records.

---

## User Features

### Movie Browsing

- View available movies.
- View movie details.
- Explore cinema content.

### Watch List Management

- Add movies to personal list.
- Remove movies from watch list.
- View saved movies.

### Booking System

- Select showtime.
- Choose seats.
- Create booking.
- Confirm reservation.
- Cancel booking.

---

## Middleware Implementation

Custom middleware used for route protection.

Responsibilities:

- Authentication checks.
- Role verification.
- Access control enforcement.
- Route security.

---

## AI Integration

### Gemini Integration

Implemented through a dedicated service layer.

Features:

- Movie recommendations.
- AI-powered movie suggestions.
- Movie-related chat functionality.

Skills Demonstrated:

- Third-party API integration.
- Service abstraction.
- External HTTP communication.
- Structured AI response handling.

---

## File Handling

### Media Uploads

- Movie image uploads.
- File validation.
- Secure file storage.

---

## Security Practices

### Authentication Security

- Password hashing.
- Protected routes.
- Sanctum token security.
- Session security.

### Input Validation

- Server-side validation.
- Request sanitization.
- Controlled user input.

### Authorization

- Role-based access control.
- Protected administrative operations.

---

## Skills Demonstrated

- Laravel Framework Development
- RESTful API Development
- MVC Architecture
- Service Layer Pattern
- Authentication & Authorization
- Laravel Sanctum
- Session-Based Authentication
- Role Based Access Control (RBAC)
- Middleware Development
- Form Request Validation
- API Resources
- Eloquent ORM
- Database Design & Relationships
- Database Migrations
- File Upload Management
- AI API Integration
- Dependency Injection
- Route Management
- CRUD Operations
- JSON API Responses
- MySQL Database Management
- Software Engineering Best Practices

---

## Installation Guide

### Prerequisites

- PHP 8.3 or later
- Composer
- MySQL
- Git

### Clone Repository

```bash
git clone <https://github.com/Mohamed-Ali-Developer/CinemaProject>
cd cinema-project
```

### Install Dependencies

```bash
composer install
```

### Environment Configuration

Create a copy of the environment file:

```bash
cp .env.example .env
```

Update database credentials inside the ".env" file.

### Generate Application Key

```bash
php artisan key\:generate
```

### Run Database Migrations

```bash
php artisan migrate
```

### Start Development Server

```bash
php artisan serve
```

Application will be available at:

http://127.0.0.1:8000

---

## Software Engineering Practices

- Clean MVC Structure
- Separation of Concerns
- Reusable Components
- Service-Oriented Design
- Dependency Injection
- Centralized Validation
- Consistent API Response Structure
- Maintainable Project Architecture
- Scalable Code Organization

---

## Technologies Used

### Backend

- PHP 8.3
- Laravel 13

### Authentication

- Laravel Sanctum
- Session Authentication

### Database

- MySQL
- Eloquent ORM
- Database Migrations

### API Development

- REST API
- JSON Resources

### Frontend

- Blade Templates

### AI Integration

- Gemini API

### Development Concepts

- MVC Architecture
- Service Layer Pattern
- Dependency Injection
- Authentication & Authorization
- Role Based Access Control
- Middleware
- Form Request Validation
- Database Relationships
- RESTful API Design
- Secure File Handling
