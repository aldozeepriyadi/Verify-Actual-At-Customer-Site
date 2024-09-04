<?php

spl_autoload_register(function ($class) {
    // Base directories for the namespace prefix
    $base_dirs = [
        'Ratchet\\' => __DIR__ . '/ratchet/src/Ratchet/',
        'React\\' => __DIR__ . '/react/',
    ];

    // Iterate through base directories
    foreach ($base_dirs as $prefix => $base_dir) {
        // Check if the class uses the namespace prefix
        $len = strlen($prefix);
        if (strncmp($prefix, $class, $len) !== 0) {
            continue;
        }

        // Get the relative class name
        $relative_class = substr($class, $len);

        // Replace the namespace prefix with the base directory, replace namespace
        // separators with directory separators in the relative class name, append
        // with .php
        $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

        // If the file exists, require it
        if (file_exists($file)) {
            require $file;
            return;
        }
    }
});
