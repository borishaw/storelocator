<?php
//Basic HTTP Authentication
if (!isset($_SERVER['PHP_AUTH_USER'])) {
    header("WWW-Authenticate: Basic realm=\"Private Area\"");
    header("HTTP/1.0 401 Unauthorized");
    print "Sorry - you need valid credentials to be granted access!\n";
    exit;
} else {
    if (($_SERVER['PHP_AUTH_USER'] == 'john') && ($_SERVER['PHP_AUTH_PW'] == 'smith')) {
//        print "Welcome to the private area!";
    } else {
        header("WWW-Authenticate: Basic realm=\"Private Area\"");
        header("HTTP/1.0 401 Unauthorized");
        print "Sorry - you need valid credentials to be granted access!\n";
        exit;
    }
}

require '../vendor/autoload.php';
DB::$user = 'root';
DB::$password = 'root';
DB::$dbName = 'hd_stores';