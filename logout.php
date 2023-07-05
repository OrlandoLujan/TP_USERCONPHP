<?php

session_start();

session_unset();

session_destroy();

header('Location: /PHP_LOGIN_2023');

?>