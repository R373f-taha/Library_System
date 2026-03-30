<?php
readonly class test {

public string $name;

}

enum HttpStatus:int{

case Ok =200;
case NotFound=404;
case NotAuthorized=401;

}

$http=HttpStatus::Ok;

echo $http->name. ' = '.$http->value;

