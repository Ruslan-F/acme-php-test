<?php

require __DIR__.'/vendor/autoload.php';

use App\Service\Cart\Decorators\Offer\DefaultOffer;

try {
    new DefaultOffer();
    echo 'up & running, autoloader ok';

} catch (Exception $e) {
    error_log($e);
}