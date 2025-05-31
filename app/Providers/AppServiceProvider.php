<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::directive('satisfactionColor', function ($expression) {
            return "<?php 
                switch ($expression) {
                    case 'Sangat Puas':
                        return 'text-green-600';
                    case 'Puas':
                        return 'text-blue-600';
                    case 'Cukup Puas':
                        return 'text-yellow-600';
                    case 'Kurang Puas':
                        return 'text-orange-600';
                    case 'Sangat Tidak Puas':
                        return 'text-red-600';
                    case 'Sangat Tinggi': // Tambahan untuk achievement level
                        return 'text-green-600';
                    case 'Tinggi':
                        return 'text-blue-600';
                    case 'Kurang':
                        return 'text-yellow-600';
                    case 'Rendah':
                        return 'text-orange-600';
                    case 'Sangat Rendah':
                        return 'text-red-600';
                    default:
                        return 'text-gray-600'; // Warna default untuk case apapun yang tidak tercover
                }

            ?>";
        });
    }
}
