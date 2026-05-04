# WellMeadows Hospital Management System (HMS)

A modern, dynamic Laravel 11 application designed to manage patients, staff, wards, and hospital administration for WellMeadows Hospital.

## Features

- **Dynamic Dashboard**: Real-time hospital metrics including patient counts, active staff on shift, and low stock warnings.
- **Patient Management**: Full CRUD capabilities to admit, update, and manage patient profiles and their medical records.
- **Staff Directory**: Detailed employee database with role-based routing and salary tracking.
- **Ward & Bed Management**: Interactive bed occupancy mapping showing real-time availability.
- **Secure Authentication**: Protected endpoints ensuring that only authorized hospital staff can access sensitive records.

## Tech Stack

- **Framework:** Laravel 11 (PHP 8.3)
- **Database:** PostgreSQL 17
- **Frontend:** Bootstrap 5, Vanilla CSS, Bootstrap Icons
- **UX/UI:** SweetAlert2 for toast notifications

## Installation & Setup

1. **Clone the repository:**
   ```bash
   git clone https://github.com/yourusername/wellmeadows-hms.git
   cd wellmeadows-hms
   ```

2. **Install Dependencies:**
   ```bash
   composer install
   npm install
   ```

3. **Environment Setup:**
   Duplicate the `.env.example` file and rename it to `.env`. Update the PostgreSQL connection credentials:
   ```env
   DB_CONNECTION=pgsql
   DB_HOST=127.0.0.1
   DB_PORT=5432
   DB_DATABASE=wellmeadows_hms
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

4. **Generate Application Key:**
   ```bash
   php artisan key:generate
   ```

5. **Run Migrations:**
   *(Note: Ensure your PostgreSQL database `wellmeadows_hms` is created before running this step)*
   ```bash
   php artisan migrate
   ```

6. **Seed the Database (Optional):**
   To create an initial Administrator account for login testing:
   ```bash
   php artisan db:seed --class=AdminSeeder
   ```

7. **Start the Development Server:**
   ```bash
   php artisan serve
   ```

## Default Login Credentials
If you ran the `AdminSeeder`, you can log in to the dashboard using:
- **Email:** `admin@wellmeadows.com`
- **Password:** `password`

## Development Roadmap

### 🟢 Phase 1: Data Structure & Layout (Completed)
- Extracted common UI to `layouts/app.blade.php`.
- Wired `Dashboard`, `Patient Management`, `Staff Management`, and `Ward & Bed Management` to dynamic Eloquent ORM queries.
- Scaffolded all 24 database Models with correct relationships.

### 🟢 Phase 2: Interactivity & Data Mutation (Completed)
- Built robust Blade forms for Patient and Staff management.
- Added `@error` handling to inputs and retained data using `old()`.
- Added SweetAlert2 to the global layout to present beautiful Toast notifications for Success/Error events.

### 🟢 Phase 3: Authentication & Security (Completed)
- Built custom `AuthController` and Login Views integrating with the Bootstrap theme.
- Linked the default Laravel `users` table to the existing `staff` table via a `staff_no` foreign key.
- Implemented `auth` middleware across all routes and displayed the active user profile dynamically in the header.

### 🟡 Phase 4: Advanced Features & Polish (Current Focus)
- **Live Search**: Convert standard tables to use Livewire or simple AJAX for instant patient/staff searching without page reloads.
- **Reporting**: Generate the required end-of-month case study reports (e.g., Ward Requisitions, Patient Allocation) with print-friendly CSS styles.
- **Optimization**: Ensure all Eloquent queries use eager loading (`with()`) to prevent N+1 query performance issues.

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
