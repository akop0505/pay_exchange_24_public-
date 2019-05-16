<?php

use himiklab\yii2\recaptcha\ReCaptcha;


Yii::$container->set(\himiklab\yii2\recaptcha\ReCaptchaValidator::class, [
    'secret' => '6LekwFUUAAAAALowIx2sq6_CIjLFPRm88B2ZRd9X',
    'uncheckedMessage' => 'Подтвердите, что Вы не робот.',
]);

Yii::$container->set(ReCaptcha::class, [
    'siteKey' => '6LekwFUUAAAAAEO_a8XrDNKHzoHd9NQdcRrOY8xj',
]);