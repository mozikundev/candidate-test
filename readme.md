# CLT Manager - Feature Test Assignment

A Laravel-based CLT supplier management application for managing Suppliers, CLT Layups, and CLT Layers.

This project was built as part of a feature test assignment using Laravel 11 and Tailwind CSS.

---

# Features Implemented

## Core Features

- Supplier CRUD
- CLT Layup CRUD nested under Supplier
- CLT Layer CRUD nested under Layup

Data hierarchy:

```txt
Supplier
 └── CLT Layups
      └── CLT Layers
```

---

# Import / Export

## Export by Supplier

The application supports exporting supplier data into JSON format.

Exported data includes:
- Supplier
- All related Layups
- All related Layers

---

## Import by Supplier

The application supports importing supplier data using JSON files.

The importer:
- Creates new Layups
- Creates new Layers
- Updates existing Layups
- Detects layer conflicts

---

# Conflict Resolution

## Conflict Detection Rules

A conflict is detected when:

- A Layup with the same `name` already exists under the same Supplier
- AND a Layer with the same `layer_order` exists
- BUT one or more values differ:
  - `thickness`
  - `width`
  - `angle`

---

## Conflict Resolution Strategy

This implementation uses:

```txt
Overwrite Existing
```

Behavior:
- Existing layer data is replaced by imported data
- Conflicts are counted during import
- A conflict report is displayed after import

---

# Conflict Report UI

After import, the application displays:
- Layup name
- Layer order
- Existing values
- Incoming values
- Resolution strategy

This provides visibility into overwritten conflicts.

---

# Dashboard

The application includes a dashboard overview showing:
- Total Suppliers
- Total Layups
- Total Layers
- Recent Suppliers

---

# Laravel Best Practices Used

- Form Request Validation
- Route Model Binding
- Nested Resource Routing
- Eloquent Relationships
- Clean Controller Structure
- Pagination
- Flash Success Messages

---

# Tech Stack

- Laravel 11
- PHP 8.2
- Tailwind CSS
- Blade Templates
- SQLite / MySQL compatible

---

# Database Structure

## Suppliers

```txt
id
name
timestamps
```

## CLT Layups

```txt
id
supplier_id
name
timestamps
```

## CLT Layers

```txt
id
clt_layup_id
layer_order
thickness
width
angle
timestamps
```

---

# Import JSON Example

```json
{
    "supplier": {
        "name": "Nordic Timber"
    },
    "layups": [
        {
            "name": "L-2023-X",
            "layers": [
                {
                    "layer_order": 1,
                    "thickness": 12,
                    "width": 100,
                    "angle": 45
                }
            ]
        }
    ]
}
```

---

# Setup Instructions

## 1. Clone Repository

```bash
git clone <repository-url>
```

---

## 2. Install Dependencies

```bash
composer install
npm install
```

---

## 3. Environment Setup

Copy environment file:

```bash
cp .env.example .env
```

Generate application key:

```bash
php artisan key:generate
```

---

## 4. Configure Database

Update `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cltmanagerdb
DB_USERNAME=root
DB_PASSWORD=
```

---

## 5. Run Migrations

```bash
php artisan migrate
```

---

## 6. Start Development Server

```bash
php artisan serve
npm run dev
```

---

# Demo Flow

## Supplier Management
- Create Supplier
- Edit Supplier
- Delete Supplier

## Layup Management
- Create Layup
- Edit Layup
- Delete Layup

## Layer Management
- Create Layer
- Edit Layer
- Delete Layer

## Import / Export
- Export Supplier JSON
- Import JSON
- Trigger conflict overwrite
- Review conflict report

---

# UI Notes

The UI was designed to follow the provided Figma reference while maintaining a clean and compact enterprise dashboard style.

---

# Author

Feature Test Submission  
Built with Laravel 11 + Tailwind CSS
