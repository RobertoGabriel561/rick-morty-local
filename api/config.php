<?php
// api/config.php

ini_set('session.use_cookies', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_samesite', 'None');
ini_set('session.cookie_secure', 1);

require_once __DIR__ . '/db.php';