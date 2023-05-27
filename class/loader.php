<?php

    foreach (scandir(dirname(__FILE__)) as $filename) {
        $path = dirname(__FILE__) . '/' . $filename;
        if (is_file($path) && str_ends_with($path, ".class.php")) {
            include_once($path);
        }
    }


?>