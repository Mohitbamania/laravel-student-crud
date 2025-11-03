<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
  </a>
</p>

<h2 align="center">🎓 Laravel Student Management CRUD System</h2>

<p align="center">
  A simple Laravel web application to manage student records — built with CRUD operations and enhanced with DataTables for searching, sorting, and pagination.
</p>

---

## 🚀 Features

- ➕ Add new student details  
- ✏️ Edit student information  
- ❌ Delete student records  
- 🖼️ Upload & manage profile images  
- 📋 Display all students in a dynamic DataTable with:
  - 🔍 Search
  - ↕️ Sort
  - 📄 Pagination

---

## 🧩 Technologies Used

- **Laravel** – PHP web framework  
- **MySQL** – Database  
- **Bootstrap 5** – Frontend styling  
- **jQuery DataTables** – For dynamic tables  
- **Blade** – Laravel templating engine  

---

## 🛠️ Installation & Setup

Follow the steps below to set up the project locally:

### 1️⃣ Clone the Repository
```bash
git clone https://github.com/mohitbamania/student-crud-laravel.git
cd student-crud-laravel

2️⃣ Install Dependencies
composer install
npm install && npm run dev

3️⃣ Configure Environment
cp .env.example .env

Then update your database credentials:
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password

4️⃣ Generate Application Key
php artisan key:generate

5️⃣ Run Database Migrations
php artisan migrate

6️⃣ Start the Application
php artisan serve


