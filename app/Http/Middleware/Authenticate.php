<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    protected function redirectTo($request)
    {
        return route('user.login');
    }
}
/*

Composer is a tool for dependency management in PHP. It allows you to declare the libraries your project depends on and it will manage (install/update) them for you.on a per-project basis,To start using Composer in your project, all you need is a composer.json file. This file describes the dependencies of your project and may contain other metadata as well.
The first (and often only) thing you specify in composer.json is the require key. You are simply telling Composer which packages your project depends on.--require-dev: Development requirements, see --require.



namespaces are a way of encapsulating items.in any operating system directories serve to group related files, and act as a namespace for the files within them
shorten) Extra_Long_Names designed.Now you can use namespaces to keep your function name separate from anyone else's function name, and you won't have to make extra_long_named functions to get around the name collision problem.


If you want a middleware to run during every HTTP request to your application, list the middleware class in the $middleware property of your app/Http/Kernel.php class.
*/