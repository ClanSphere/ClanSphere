<?php
global $captcha_option;
define( 'AYAH_PUBLISHER_KEY', $captcha_option['options']['areyouahuman_publisher_key']);
define( 'AYAH_SCORING_KEY', $captcha_option['options']['areyouahuman_scoring_key']);


// Set defaults for values needed by the ayah.php file.
// (Note: you do not need to change these.)
define( 'AYAH_WEB_SERVICE_HOST', 'ws.areyouahuman.com');
define( 'AYAH_TIMEOUT', 0);
define( 'AYAH_DEBUG_MODE', FALSE);
define( 'AYAH_USE_CURL', TRUE);
