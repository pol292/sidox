<?php

namespace Sidox\Core;

/**
 * ***************************************
 *               Class File              *
 * This is abastract class of controller *
 * ***************************************
 * @version 05/03/2017
 * @author Pol Bogopolsky <pol292@gmail.com>
 */
abstract class Controller {

    const PATH = Path::app . 'Controllers' . DS;

    public function __construct() {
        View::init();
    }

}
