<?php

declare(strict_types=1);

return [
    // Master switch. When false the package registers no routes at all, so
    // /browserconfig.xml and /favicon.ico stay 404.
    'enabled' => true,

    // Path (resolvable by Vite) to the favicon.ico served at /favicon.ico.
    // Leave empty/null to skip registering the /favicon.ico route.
    'favicon' => 'resources/favicon/favicon.ico',

    // URL emitted in the `msapplication-config` <meta> of the head view and
    // pointing at the browserconfig.xml endpoint. Override when the route is
    // mounted under a path prefix.
    'browserconfig_url' => '/browserconfig.xml',

    // Colour of the legacy Windows pinned tile (msapplication-TileColor meta +
    // the browserconfig.xml <TileColor>).
    'tile_color' => '#ffffff',
];
