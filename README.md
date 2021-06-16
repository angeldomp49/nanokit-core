# Nanokit #

This is a library open source it have simplies functionalities for develop an small web php application.

### requirements ###

First you need have installed php.

### get started ###

### 1. Register a route ###
Supposed you have php installed in the global environement, go to the __app/routes.php__ file and register a new route to receive like:

    `Route::get( 'home', [ HomeController::class, 'home' ] );`

the Route::get() function register a uri and bind this with the controller function passed as second parameter.

### 2. create a controller with his function ###

Go to __src/Controllers__ directory and create a new file with the controller class name like __HomeController__, then define a function that will be called when the registered uri is called. The namespace should be __App\Controllers__.

    <?php
    namespace App\Controllers;

    class HomeController{
        public function home(){
            // your code here
        }
    }


### 3. Redirecting to a view. ###

use the global function __view()__ for insert a view file inside the controller, this function also supports send parameters like an array.

    public function home(){
        view( 'home', [ 'firstParam' => 'hello world' ] );
    }

Then, create a view file in the __src/Views__, and add custom php or html code, also you can get the sended parameter from the controller.

`<?php echo( $firstParam ); ?>`

### 4. start the development server. ###


Open a terminal and enter in your current directory, then use the next command:

`php composer.phar dump-autoload`

This command register all your class files created and remove the requirement of use __include()__ function.

Then use:


`php -S localhost:8000 -t public/`

This command start a development server in the localhost with the 8000 port, the root directory called is inside public/.

you should see something like:

<p>hello world</p>


## Uri's with parameters ##

For catch *GET* parameters you need register the route defining his names using __curly brackets__.

`Route::get( 'home/{user}/dashboard/{resource}' );`

In your controller you only need receive it like a function parameter.

`public function home( $user, $resource ){`