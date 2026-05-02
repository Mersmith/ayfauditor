composer require laravel-lang/lang --dev
php artisan lang:add es

composer require barryvdh/laravel-dompdf
php artisan vendor:publish --provider="Barryvdh\DomPDF\ServiceProvider"

composer require maatwebsite/excel
php artisan make:import ComprobantePagoAntiguoImport

composer require spatie/laravel-permission
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"

composer require "spatie/laravel-medialibrary"
php artisan vendor:publish --provider="Spatie\MediaLibrary\MediaLibraryServiceProvider" --tag="medialibrary-migrations"

php artisan permission:cache-reset
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan optimize:clear