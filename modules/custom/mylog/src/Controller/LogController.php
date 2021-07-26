<?php 
namespace Drupal\mylog\Controller;
use Symfony\Component\HttpFoundation\Response;
class LogController {

    public static function test(){
        print_r("tetetetetet");
        write_logs("Madhuri Test ");
        return new Response();

    }
}