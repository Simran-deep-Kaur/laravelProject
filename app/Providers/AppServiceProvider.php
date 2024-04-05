<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Blade::directive('markdown', function () {
            return "<?php echo(Str::markdown(<<<HEREDOC";
        });

        Blade::directive('endmarkdown', function () {
            return "HEREDOC)); ?>";
        });

    }
}
