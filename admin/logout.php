<?php
include 'config.php';
include 'function.php';
session_start();
session_unset();
session_destroy();
changepage('');
