<?php
    define("DEBUG_MODE", true);

    define("FEATURE_COMMENTS", true);
    define("FEATURE_DOCUMENTS", true);
    define("FEATURE_DEADLINE", true);
    define("FEATURE_ENTITIES", true);
    define("FEATURE_NOTIFICATIONS", true);

    // alternative with constance array (7+)
    define('FEATURE', [
        'COMMENTS' => true,
        'DOCUMENTS' => true,
        'DEADLINES' => true,
        'ENTITIES' => true,
        'NOTIFICATIONS' => true,
    ]);

    define("SUBDOMAIN", 'dev');
    define("PROJECT", 'Development');

    define("SUPPORT_EMAIL", 'christoph@dragoneyes.org');
