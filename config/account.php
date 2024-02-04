<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Email verification success redirect route
    |--------------------------------------------------------------------------
    |
    | This value is the redirect path of email verification process when email
    | is successfully verified.  Email verification services for verifying users
    | account will use this value to redirect user to a page that will inform
    | them that their email have been successfully verified.
    |
    */

    "email_verification_success_redirect_address" => env('APP_URL') . "/email-verified",

    /*
    |--------------------------------------------------------------------------
    | Email verification failure redirect route
    |--------------------------------------------------------------------------
    |
    | This value is the redirect path of email verification process when email
    | process have been failed.  Email verification services for verifying users
    | account will use this value to redirect user to a page that will inform
    | them that their email verification have been failed.
    |
    */

    "email_verification_failure_redirect_address" => env('APP_URL') . "/email-verification-failed",

];
