
# get started #

download from https://github.com/angeldomp49/nanokit

## Modules ##

-> Util
-> Translations
-> Database
-> Routing
-> Mail

## global functions ##

    void view( String $view, Array $params )

Extract the array values in $params and include the specified view name located in src/Views directory

    String rightPath( String $filename )

The $filename should be referenced from the base directory 

## Util ##

By default Util module functions file is loaded.

class Logger

static methods

    public static void log( String $message )

Display the message in p html tag

    public static void logDump( Object $obj )

Display var_dump in p html tag

    public static void logBool( Bool $condition )

Display support for booleans in p html tag

    public static void err( String $err )

Trigger an user error message like Notice



##  ##