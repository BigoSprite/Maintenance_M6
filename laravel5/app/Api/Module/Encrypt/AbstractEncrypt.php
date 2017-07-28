<?php

namespace App\Api\Module\Encrypt;


abstract class AbstractEncrypt
{
    abstract public function doEncrypt($var);

    abstract public function doDecrypt($var);
}