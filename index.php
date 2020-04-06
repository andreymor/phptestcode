<?php

require __DIR__.'/vendor/autoload.php';

use AMoretti\PhpTest\ABTesting\PromotionAbTestUseCase;

$promotionUseCase = (new PromotionAbTestUseCase())->run();

echo "Hi there, welcome to {$promotionUseCase->getVariationName()}!";

//If you like, please uncomment this line and check that the query 'text' is sent always as the same. Also, tests are making sure of it =)
//header('Location: https://www.templatemonster.com/templates.php?text='.$promotionUseCase->getVariationName());
