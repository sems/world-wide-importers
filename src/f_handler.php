<?php
    /*
    * Include form (in _GET)
    */
    include('forms/'.filter_input(INPUT_GET, "form_handler", FILTER_SANITIZE_STRING));
?>