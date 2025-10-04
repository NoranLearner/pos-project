<?php

return [
    App\Providers\AppServiceProvider::class,
    // ... other application service providers
    // Your package's service provider
    RealRashid\SweetAlert\SweetAlertServiceProvider::class,
    Intervention\Image\ImageServiceProvider::class,
    Maatwebsite\Excel\ExcelServiceProvider::class,
];
