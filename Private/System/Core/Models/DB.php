<?php

namespace Sidox\Core\Models;

trait DB {

    protected $link;

    public function __construct() {
        $this->link = Singelton_DB::connect();
        mysqli_set_charset( $this->link, 'utf8' );
    }

}
