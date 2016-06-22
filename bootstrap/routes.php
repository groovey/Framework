<?php

$app->mount('/', new App\Controllers\Main());
$app->mount('/prototype', new App\Controllers\Prototype());

return $app;
