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

    const base        = BASE_PATH;
    const public_dir  = self::base . 'Public' . DS;
    const private_dir = self::base . 'Private' . DS;
    const system = self::private_dir . 'System' . DS;
    const core = self::system . 'Core' . DS;
    const app = self::private_dir . 'Application' . DS;
}