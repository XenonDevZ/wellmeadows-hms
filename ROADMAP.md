# WellMeadows HMS Development Roadmap

> [!NOTE]
> This document outlines the strategic progression from our current scaffolded state (Static Premium UI + Seeded PostgreSQL Database) to a fully dynamic, production-ready Laravel 11 application.

## 🟢 Current State (Completed)

We have successfully bridged the gap between our raw database and our frontend prototypes:

1.  **Database Layer (`wellmeadows_hms`)**: Fully designed PostgreSQL schema with 24 entities matching the ERD, populated with realistic clinical test data.
2.  **Logic Layer**: 24 Eloquent Models configured with correct relationships, hidden fields, and custom casts. Base Controllers are scaffolded.
3.  **Presentation Layer**: A cohesive, premium "Bento-style" dark sidebar UI is built out across 6 core Blade templates.
4.  **Environment**: Laravel application initialized via MAMP (PHP 8.3) and connected to the local database, with routing serving the static Blade views.

---

## 🟢 Phase 1.1: Dashboard & Layout (Completed)
*   **Action**: Extracted common UI to `layouts/app.blade.php`, added Reports sidebar link.
*   **Action**: Updated `DashboardController@index` to query live metrics.
*   **Action**: Wired `dashboard.blade.php` to use dynamic data and resolved missing Eloquent models.

---

## 🟢 Phase 1.2: Patient Management (Completed)
*   **Action**: Converted `/patients` route to a Resource controller.
*   **Action**: Built full CRUD views (`index`, `create`, `edit`, `show`) into `resources/views/patients/`.
*   **Action**: Scaffolded all 24 Eloquent Models to prevent missing dependencies.

---

## 🟢 Phase 1.3: Staff Management (Completed)

### Step 1.3: Staff Directory (`/staff`)
*   **Action**: Wired up the Staff cards/table.
*   **Data Needed**: `Staff::with('category')->orderBy('staff_no')->paginate(10)`
*   **Blade Updates**: Dynamic staff position badges, full CRUD views, and layout integration.

## 🟢 Phase 1.4: Ward & Bed Management (Completed)

### Step 1.4: Ward & Bed Management (`/wards`)
*   **Action**: Wired Ward Controller to dynamic Grid.
*   **Data Needed**: `Ward::with(['beds.currentPatient.patient'])->get()`
*   **Blade Updates**: Color-coded bed map and live occupancy progress bar generation.

---

## 🟢 Phase 2: Interactivity & Data Mutation (Completed)

Once the data is displaying correctly, we will allow the staff to interact with it seamlessly.

*   **Forms**: Build robust Blade forms for Patient and Staff management.
*   **Validation**: Add `@error` handling to inputs and retain data using the `old()` helper on validation failure.
*   **UX/UI**: Add SweetAlert2 to the global layout to present beautiful Toast notifications for Success/Error events from the controllers.

---

## 🟢 Phase 3: Authentication & Security (Completed)

Securing the system so only authorized medical staff can access specific modules.

*   **Setup**: Built custom AuthController and Login Views to integrate seamlessly with the Bootstrap theme without installing Tailwind.
*   **Auth Logic**: Link the default Laravel `users` table to our existing `staff` table via a `staff_no` foreign key.
*   **Middleware**: Implement a `auth` middleware across all routes and display the active user profile dynamically in the header.

---

## 🟡 Phase 4: Advanced Features & Polish (Current Focus)

*   **Live Search**: Convert standard tables to use Livewire or simple AJAX for instant patient/staff searching without page reloads.
*   **Reporting**: Generate the required end-of-month case study reports (e.g., Ward Requisitions, Patient Allocation) with print-friendly CSS styles.
*   **Optimization**: Ensure all Eloquent queries use eager loading (`with()`) to prevent N+1 query performance issues.
