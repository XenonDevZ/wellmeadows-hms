# WellMeadows Hospital Management System (HMS)

A modern, fully dynamic **Laravel** application for managing patients, staff, wards, appointments, billing, requisitions, and hospital reporting at WellMeadows Hospital. Built with a premium Bootstrap 5 UI and backed by PostgreSQL.

---

## Features

| Module | Description |
|---|---|
| 🏠 **Dashboard** | Real-time KPIs — patients, staff on duty, beds, and low-stock alerts |
| 👤 **Patient Management** | Full CRUD — admit, update, view, and discharge patient records |
| 👨‍⚕️ **Staff Directory** | Employee database with role, salary, and allocation tracking |
| 🏥 **Ward & Bed Management** | Interactive bed occupancy map with real-time availability |
| 📅 **Appointments** | Schedule, edit, and cancel patient appointments with status tracking |
| 💳 **Billing & Requisitions** | Patient billing, payment recording, ward supply orders, and stock management |
| 📊 **Reports** | 5 printable reports: Ward Allocation, Billing, Appointments, Requisitions, Medications |
| 🔒 **Authentication** | Secure custom login linked to the Staff table via middleware |

---

## Tech Stack

| Layer | Technology |
|---|---|
| **Framework** | Laravel (PHP 8.3+) |
| **Database** | PostgreSQL 17 |
| **Frontend** | Bootstrap 5, Vanilla CSS, Bootstrap Icons |
| **UI Enhancements** | SweetAlert2 (toast notifications), Bootstrap Modals |
| **Auth** | Custom `AuthController` with `auth` middleware |

---

## Prerequisites

Before you begin, ensure you have the following installed:

- **PHP** ≥ 8.1 (with `pdo_pgsql` and `pgsql` extensions enabled)
- **Composer** ≥ 2.x
- **Node.js** ≥ 18.x & **npm**
- **PostgreSQL** ≥ 14

### Enable PHP PostgreSQL Extensions

If you're using **MAMP**, edit your `php.ini` and ensure these lines are **uncommented**:
```ini
extension=pgsql
extension=pdo_pgsql
```
> On MAMP, `php.ini` is usually at: `/Applications/MAMP/bin/php/php8.x.x/conf/php.ini`

---

## Installation & Setup

### Step 1 — Clone the Repository
```bash
git clone https://github.com/yourusername/wellmeadows-hms.git
cd wellmeadows-hms
```

### Step 2 — Install PHP Dependencies
```bash
composer install
```

### Step 3 — Install Frontend Dependencies
```bash
npm install
```

### Step 4 — Create the Environment File
```bash
cp .env.example .env
```
Then open `.env` and update your **PostgreSQL credentials**:
```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=wellmeadows_hms
DB_USERNAME=your_postgres_username
DB_PASSWORD=your_postgres_password
```

### Step 5 — Generate App Key
```bash
php artisan key:generate
```
> This generates a unique `APP_KEY` used for encryption. **Required before running.**

### Step 6 — Create the PostgreSQL Database

Open **pgAdmin**, **TablePlus**, or your terminal and run:
```sql
CREATE DATABASE wellmeadows_hms;
```

### Step 7 — Run Migrations
```bash
php artisan migrate
```
This creates all 20+ tables (patients, staff, wards, appointments, billing, etc.).

### Step 8 — Seed the Admin Account
```bash
php artisan db:seed --class=AdminSeeder
```
This creates a staff record and a linked user account for logging in:

| Field | Value |
|---|---|
| **Email** | `admin@wellmeadows.com` |
| **Password** | `password` |

### Step 9 — Start the Development Server

```bash
php artisan serve
```

Then open your browser and navigate to:
```
http://localhost:8000
```
You will be automatically redirected to the login page.

---

## Seeding Stock & Suppliers (Optional)

The Billing module's Suppliers & Stock tab requires sample inventory data. If your `item` and `supplier` tables are empty, run this SQL in pgAdmin or TablePlus:

```sql
-- Suppliers
INSERT INTO supplier (supplier_no, name, address, telephone_number, fax_number) VALUES
('SUP001', 'MediSupply Ltd', '12 Health St, Edinburgh, EH1 1AB', '0131-222-3333', '0131-222-3334'),
('SUP002', 'PharmaCo UK', '45 Pharma Ave, Glasgow, G1 2CD', '0141-444-5555', '0141-444-5556'),
('SUP003', 'Hospital Essentials', '99 Med Lane, London, SW1A 1AA', '0207-111-2222', '0207-111-2223');

-- Items
INSERT INTO item (item_no, name, description, quantity_in_stock, reorder_level, cost_per_unit, supplier_no) VALUES
('ITEM001', 'Bandages (Large)', 'Large sterile bandages', 15, 25, 2.50, 'SUP001'),
('ITEM002', 'Surgical Gloves (M)', 'Medium nitrile surgical gloves (box of 100)', 200, 50, 0.15, 'SUP001'),
('ITEM003', 'Paracetamol 500mg', 'Paracetamol tablets 500mg (box of 100)', 8, 20, 0.05, 'SUP002'),
('ITEM004', 'Ibuprofen 400mg', 'Ibuprofen tablets 400mg (box of 100)', 45, 20, 0.08, 'SUP002'),
('ITEM005', 'Sterile Gauze Pads', 'Non-stick sterile gauze pads (pack of 50)', 30, 30, 1.20, 'SUP001'),
('ITEM006', 'IV Cannula 18G', '18 gauge IV cannula (box of 50)', 60, 40, 1.75, 'SUP003'),
('ITEM007', 'Saline Solution 500ml', 'Normal saline IV solution 500ml bags', 12, 25, 3.50, 'SUP003'),
('ITEM008', 'Disposable Syringes 5ml', '5ml disposable syringes (box of 100)', 90, 50, 0.25, 'SUP001'),
('ITEM009', 'Oxygen Masks (Adult)', 'Adult disposable oxygen masks', 5, 15, 2.80, 'SUP003'),
('ITEM010', 'Blood Pressure Cuffs', 'Reusable adult blood pressure cuffs', 10, 5, 18.99, 'SUP003');
```

---

## Project Structure

```
wellmeadows-hms/
├── app/
│   ├── Http/Controllers/
│   │   ├── AuthController.php          # Login / Logout
│   │   ├── DashboardController.php     # Home dashboard KPIs
│   │   ├── PatientController.php       # Patient CRUD
│   │   ├── StaffController.php         # Staff CRUD
│   │   ├── WardController.php          # Ward & Bed views
│   │   ├── AppointmentController.php   # Appointment CRUD
│   │   ├── BillingController.php       # Billing, Requisitions, Stock
│   │   └── ReportController.php        # 5 printable reports
│   └── Models/                         # 20+ Eloquent models
├── resources/views/
│   ├── layouts/app.blade.php           # Global layout shell
│   ├── auth/login.blade.php            # Login page
│   ├── dashboard.blade.php
│   ├── patients/                       # Patient CRUD views
│   ├── staff/                          # Staff CRUD views
│   ├── appointments/                   # Appointment views
│   ├── billing.blade.php               # Billing & Requisitions dashboard
│   ├── billing/create.blade.php        # Create bill form
│   ├── requisitions/create.blade.php   # New requisition form
│   ├── reports.blade.php               # Reports landing page
│   └── reports/                        # 5 individual report views
├── routes/web.php                      # All application routes
├── database/migrations/                # Database schema
└── database/seeders/AdminSeeder.php    # Admin account seeder
```

---

## Development Roadmap

### ✅ Phase 1 — Data Structure & Layout
- Extracted shared layout to `layouts/app.blade.php`
- Wired Dashboard, Patients, Staff, and Wards to live Eloquent queries
- Scaffolded all 20+ database models with correct relationships

### ✅ Phase 2 — Interactivity & Data Mutation
- Full CRUD forms for Patients and Staff with `@error` validation and `old()` retention
- Global SweetAlert2 toast notifications for success/error feedback

### ✅ Phase 3 — Authentication & Security
- Custom `AuthController` with login/logout
- `auth` middleware protecting all routes
- Staff table linked to users table via `staff_no`

### ✅ Phase 4 — Advanced Features & Polish
- **Appointments Module**: Full CRUD with dynamic KPI dashboard
- **Billing & Requisitions**: Patient billing, payment recording, ward supply orders, inventory stock management with Low Stock alerts
- **Reports**: 5 dedicated printable reports (Ward Allocation, Billing, Appointments, Requisitions, Medications)
- **Bootstrap Modals**: View, confirm, and action dialogs replacing native browser `confirm()`
- **Mobile Responsive**: All tables wrapped in `.table-responsive` for small screens

---

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
