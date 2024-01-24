<?php
namespace app\core\exception;
class NotFoundException extends \Exception
{
    public $code=404;
    public $message="Page not found";
}
