<?php 

namespace App\Enums;

enum HttpStatusEnum: int 
{
   case SUCCESS = 200;
   case ERROR = 400;
   case UNAUTHORIZED = 401;
   case FORBIDDEN = 403;
   case NOT_FOUND = 404;
   case SERVER_ERROR = 500;
}