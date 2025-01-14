# Laravel Widget System

A simple widget system built with Laravel that can be embedded on any website.

## Prerequisites

- PHP >= 8.1
- Composer
- Laravel >= 9.x
- Web server (Apache/Nginx)

## Installation

1. Clone the repository:

git clone <repository-url>
cd <project-folder>

3. Copy the environment file:
```bash
cp .env.example .env
```

4. Generate application key:
```bash
php artisan key:generate
```

## Setting up the Widget System

1. Create the necessary middleware:

Create file `app/Http/Middleware/Cors.php`:
```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Cors
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        
        $origin = $request->header('Origin');
        
        $allowedOrigins = [
            'http://localhost',
            'http://localhost:8080',
            'http://127.0.0.1',
            'http://127.0.0.1:8080'
        ];
        
        if (in_array($origin, $allowedOrigins)) {
            $response->headers->set('Access-Control-Allow-Origin', $origin);
            $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, PATCH, DELETE, OPTIONS');
            $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, X-Requested-With, Authorization, X-CSRF-TOKEN');
            $response->headers->set('Access-Control-Allow-Credentials', 'true');
            $response->headers->set('Access-Control-Max-Age', '86400');
        }

        if ($request->isMethod('OPTIONS')) {
            return response()->json('OK', 200)->withHeaders($response->headers->all());
        }
        
        return $response;
    }
}
```

2. Create the widget views:

Create directory and files:
```bash
mkdir -p resources/views/widgets
touch resources/views/widgets/{embed.blade.php,script.blade.php,styles.blade.php}
```

3. Update your routes in `routes/web.php`:
```php
Route::prefix('widget')->group(function () {
    Route::get('render', [WidgetController::class, 'render']);
    Route::get('script.js', [WidgetController::class, 'script']);
    Route::get('styles.css', [WidgetController::class, 'styles']);
    Route::get('data', [WidgetController::class, 'data']);
    Route::post('action', [WidgetController::class, 'action']);
});
```

4. Update CSRF configuration in `app/Http/Middleware/VerifyCsrfToken.php`:
```php
protected $except = [
    'widget/*'
];
```

## Testing the Widget

1. Start the Laravel development server:
```bash
php artisan serve
```

2. Create a test HTML file (test.html):
```html
<!DOCTYPE html>
<html>
<head>
    <title>Widget Test</title>
    <link rel="stylesheet" href="http://127.0.0.1:8000/widget/styles.css">
</head>
<body>
    <div id="laravel-widget"></div>

    <script src="http://127.0.0.1:8000/widget/script.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            LaravelWidget.init('laravel-widget', {
                apiUrl: 'http://127.0.0.1:8000/widget',
                theme: 'light',
                title: 'My Laravel Widget'
            });
        });
    </script>
</body>
</html>
```

3. Serve the test file:
```bash
php -S localhost:8080
```

4. Visit http://localhost:8080/test.html in your browser to see the widget in action.

## Customization

- To modify the widget's appearance, edit `resources/views/widgets/styles.blade.php`
- To change the widget's behavior, edit `resources/views/widgets/script.blade.php`
- To update the widget's HTML structure, edit `resources/views/widgets/embed.blade.php`

## Security Considerations

- Update the `$allowedOrigins` array in the Cors middleware to include your production domains
- Implement proper authentication if needed
- Add rate limiting for the widget endpoints
- Consider implementing API keys for production use

## Troubleshooting

If you encounter CORS issues:
1. Check that the origin domain is included in `$allowedOrigins`
2. Ensure all necessary CORS headers are being set
3. Clear browser cache and reload the page

If you see 419 errors:
1. Verify the widget routes are excluded in VerifyCsrfToken middleware
2. Check that the CORS middleware is properly registered

## Production Deployment

Before deploying to production:
1. Update the allowed origins in the CORS middleware
2. Implement proper security measures
3. Configure your web server to handle CORS properly
4. Use HTTPS for all endpoints
5. Consider implementing caching for better performance

## License

```

This README provides a comprehensive guide for setting up and using the widget system. Make sure to:
1. Replace `<repository-url>` with your actual repository URL
2. Add appropriate license information
3. Update security considerations based on your specific needs
4. Add any additional customization options specific to your widget
5. Include any environment-specific configuration requirements

