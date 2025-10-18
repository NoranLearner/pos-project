## 🍽️  (POS Restaurant Management System) مشروع إدارة مطعم
==================================================================

### 🧩 (Project Description) نبذة عن المشروع

نظام إدارة مطعم (POS) تم تطويره لتسهيل إدارة المستخدمين، الأقسام، المنتجات، العملاء، الطلبات، والمبيعات اليومية مع واجهة عربية منظمة وسهلة الاستخدام.

---------------

### ✨ (Requirements And Technologies Used) المتطلبات و التقنيات المستخدمة 

- [XAMPP](https://www.apachefriends.org/)
- php 8.3
- mysql
- [Laravel 12](https://laravel.com/docs/12.x)
- [composer](https://getcomposer.org/)
- [node.js](https://nodejs.org/en)
- npm
- [Bootstrap](https://getbootstrap.com/docs/3.3/getting-started/)
- [jQuery](https://blog.jquery.com/)
- [Tailwind CSS](https://tailwindcss.com/)
- AdminLTE Template
- [Font Awesome](https://fontawesome.com/v4/icons/)
- [Breeze Authentication Package](https://github.com/laravel/breeze)
- [Laratrust Package](https://laratrust.santigarcor.me/docs/8.x/)
- [Mcamara Package](https://github.com/mcamara/laravel-localization)
- [Laravel Translatable Package](https://github.com/Astrotomic/laravel-translatable)
- [CKEditor Package](https://ckeditor.com/)
- [Sweet Alert Package](https://realrashid.github.io/sweet-alert/)
- [Intervention Image Package](https://image.intervention.io/v2)
- [Maatwebsite/Laravel-Excel Package](https://laravel-excel.com/)
- [Chart.js Package](https://www.chartjs.org/docs/latest/getting-started/)
- [Laravel Debugbar Package](https://github.com/barryvdh/laravel-debugbar)

---------------

### ⚙️ (Installation Instructions) تعليمات التشغيل

1. (Clone the project) انسخ المشروع
   > git clone https://github.com/NoranLearner/pos-project.git
2. (Go to the project directory) ادخل على مجلد المشروع
   > cd pos-project
3. (Install dependencies) ثبّت المتطلبات
   > composer install
   <br/> npm install
4. (Create .env file and set up database) أنشئ ملف ال .env وعدّل إعدادات قاعدة البيانات
   > cp .env.example .env
   <br/> php artisan key:generate
   <br/> (DB_DATABASE, DB_USERNAME, DB_PASSWORD)
5. (Run migrations and seeders) شغّل الـ migrations والـ seeders
   > php artisan migrate --seed
6. (Link the storage) اربط مجلد التخزين
   > php artisan storage:link
7. (Start the local server) شغّل السيرفر المحلي
   > php artisan serve
8. افتح الرابط في المتصفح:
   > http://127.0.0.1:8000

---------------

### 😎 🗂️ (Project Overview) نظرة عامة على المشروع

#### 🟣 (Home Dashboard) الصفحة الرئيسية
#### 🔵 (Users) المشرفين
#### 🟡 (Categories) الأقسام
#### 🟢 (Products) المنتجات
#### 🔵 (Clients) العملاء
#### 🟠 (Orders) الطلبات
