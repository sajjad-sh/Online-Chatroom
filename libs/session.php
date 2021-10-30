<?php

    session_start();

    function setSession($name, $value = null) {
        $_SESSION[$name] = $value;
    }