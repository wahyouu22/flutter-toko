<?php 
namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        // Jika request mengharapkan JSON, jangan redirect
        if ($request->expectsJson()) {
            return null;
        }

        // Redirect berdasarkan prefix URI
        if ($request->is('backend/*')) {
            return route('backend.login');  // Login backend
        } elseif ($request->is('frontend/*')) {
            // Frontend login, jika sudah ada di masa mendatang
            return route('frontend.login'); 
        }

        // Default redirect (ubah ke frontend jika perlu di masa depan)
        return route('backend.login'); 
    }
}
