<?php
    function IsNullOrEmptyString($str){
        return (!isset($str) || trim($str) === '' || strlen($str) == 0 || !is_null($str) || !empty($str));
    }
?>