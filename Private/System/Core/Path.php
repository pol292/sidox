<?php

namespace Sidox\Core;
/**
 * ***************************************
 *              Path interface           *
 * This is constants of system interface *
 * ***************************************
 * @version 05/03/2017
 * @author Pol Bogopolsky <pol292@gmail.com>
 */
interface Path {

    const BASE        = BASE_PATH;
    const PUBLIC_DIR  = self::BASE . 'Public' . DS;
    const PRIVATE_DIR = self::BASE . 'Private' . DS;
    const SYSTEM = self::PRIVATE_DIR . 'System' . DS;
    const CORE = self::SYSTEM . 'Core' . DS;
    const APP = self::PRIVATE_DIR . 'Application' . DS;
}