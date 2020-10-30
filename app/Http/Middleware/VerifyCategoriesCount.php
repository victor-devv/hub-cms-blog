<?php

namespace App\Http\Middleware;

use Closure;
use App\Category;

class VerifyCategoriesCount
{
    // A middleware is a piece of code that technically runs before a piece of code you specify
    // This middleware would verify the count of categories in the db before a user creates a post. Remember a post must belong to a category.
    // Dont forget to register your middleware in kernel.php

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Category::all()->count() === 0) {
            session()->flash('error', 'No category found. Please create a category first');

            return redirect(route('categories.create'));
        }

        return $next($request);
    }
}
