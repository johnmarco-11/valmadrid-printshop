<?php
ob_start();
   $root = dirname(__DIR__);
   $path = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
   if ($path === '') $path = 'index.php';
   if (is_dir("$root/$path")) $path = rtrim($path, '/') . '/index.php';

   $file = realpath("$root/$path");
   $blocked = ['/config/', '/includes/', '/database/', '/api/'];
   $ok = $file && strpos($file, $root) === 0 && substr($file, -4) === '.php';
   foreach ($blocked as $b) {
       if ($ok && strpos($file, $root . $b) === 0) $ok = false;
   }
   if (!$ok) { http_response_code(404); echo 'Not found'; exit; }

   chdir(dirname($file));
   require $file;