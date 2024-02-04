<?php

namespace App\Exceptions;

enum SQLInsertError
{
    case DuplicateEntry;
}
