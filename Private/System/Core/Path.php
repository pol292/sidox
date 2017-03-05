<?php

namespace Sidox\Core;
/**
 * This is constant of system interface
 */
interface Path {

    const base        = BASE_PATH;
    const public_dir  = self::base . 'Public' . DS;
    const private_dir = self::base . 'Private' . DS;
    const system = self::private_dir . 'System' . DS;
    const core = self::system . 'Core' . DS;
    const app = self::private_dir . 'Application' . DS;
}

