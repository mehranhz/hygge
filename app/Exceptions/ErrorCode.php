<?php

namespace App\Exceptions;


enum ErrorCode: int
{
    // general
    case Unknown = 0;

    // Database
    case SQLDuplicateEntry = 101;

    // Authentication and Authorization


    // Resource not found
    case ResourceNotFound = 404;
    case UserNotFound = 452;
}
