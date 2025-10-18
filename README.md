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
- الصفحة الرئيسية بتعرض نظرة شاملة على النظام، مع إحصائيات ورسوم بيانية توضيحية.
* 💡 (Features) المميزات
  - 🔐 نظام تسجيل الدخول: مبني باستخدام Laravel Breeze Package لتجهيز نظام Authentication جاهز.
  - 🌐 تعدد اللغات: واجهة عربية بالكامل، مع دعم الترجمة باستخدام Mcamara Laravel Localization Package.
  - 📊 إحصائيات سريعة: عرض عدد المشرفين، عدد المنتجات، عدد العملاء، وعدد الطلبات في النظام.
  - 📈 رسم بياني عمودي (Bar Chart): لعرض المبيعات اليومية، الشهرية، والسنوية باستخدام Chart.js.
  - 🥧 رسم بياني دائري (Pie Chart): يوضّح حالات الطلبات (مكتملة – قيد الانتظار – ملغية).

#### 🔵 (Users) المشرفين
- نظام إدارة المستخدمين والمشرفين يتضمن إضافة، تعديل، حذف، وتعيين الأدوار والصلاحيات.
* 💡 (Features) المميزات
    - 🧍‍♂️ صفحة إضافة المشرف: تحتوي على صورة، اسم، بريد إلكتروني، دور وصلاحيات.
    - 🧰 التحكم في الأدوار والصلاحيات: تم باستخدام Laratrust Package.
    - ♻️ UploadTrait: تم استخدامه لتطبيق مبدأ Don’t Repeat Yourself (DRY) في البرمجة كائنية التوجه (OOP).
    - 🖼️ ضغط الصور: تم باستخدام Intervention Image Package لضغط الصور قبل رفعها وحفظها على السيرفر.
    - 🔗 علاقة Polymorphic: تُستخدم في Laravel لحفظ الصور المرتبطة بالمشرفين.
    - 📋 صفحة عرض المشرفين: تتضمن Pagination لعرضهم بشكل منظم.
    - 🔍 البحث: إمكانية البحث باسم المشرف أو البريد الإلكتروني أو الدور.
    - ✏️ تعديل المشرف: صفحة لتحديث بيانات المشرفين.
    - ❌ حذف المشرف: زر منفصل لحذف مشرف واحد.
    - 🗑️ حذف متعدد: يمكن حذف أكثر من مشرف في وقت واحد عبر تحديدهم باستخدام Checkbox.
    - ⚡ تنبيهات تفاعلية: باستخدام SweetAlert Package عند الإضافة أو التعديل أو الحذف.

#### 🟡 (Categories) الأقسام
- إدارة الأقسام والمنتجات داخل نظام (مثل نظام المطعم).
* 💡 (Features) المميزات
    - 🧩 التحكم في الأقسام: المشرف الذي يمتلك الصلاحية يمكنه إضافة، تعديل، أو حذف قسم و ذلك باستخدام ال Laratrust Package.
    - 🔗 العلاقات بين الأقسام: يوجد علاقة One To Many بين القسم الرئيسي و القسم الفرعي.
    - 🖼️ رفع الصور: يمكن رفع صورة لكل قسم باستخدام علاقة ال Polymorphic لحفظ الصور.
    - 🌍 الترجمة المتعددة: اسم ووصف القسم (name & description) يمكن ترجمتهم بلغات متعددة.
    - 📝 محرر النصوص: استخدام ال CKEditor Package لكتابة وصف القسم بشكل منسق.
    - 🗃️ تفعيل / إلغاء تفعيل القسم: استخدام ال Soft Delete لتفعيل أو إلغاء تفعيل القسم و يتم تحديد حالة القسم من خلال العمود deleted_at.
    - 🔍 البحث: يمكن البحث باسم أو وصف القسم أو باسم القسم الأب.
    - 🧾 إدارة متعددة: إمكانية حذف قسم واحد أو عدة أقسام باستخدام الـ Checkbox. لا يمكن لأي مستخدم حذف أو تعديل قسم إلا إذا كانت لديه الصلاحية لذلك.
    - 📦 عرض المنتجات داخل القسم: يوجد زر لعرض جميع المنتجات المرتبطة بالقسم المحدد.
    - 📤 تصدير البيانات: يمكن تصدير جميع الأقسام إلى ملف Excel باستخدام Maatwebsite/Laravel-Excel Package.

#### 🟢 (Products) المنتجات


#### 🔵 (Clients) العملاء
#### 🟠 (Orders) الطلبات

---------------

### 🎬 Project Video Link
[POS Project](https://drive.google.com/file/d/1WH4ec-jLSF05SltngXP8eZ4fd6IN9XwS/view?usp=drive_link)
