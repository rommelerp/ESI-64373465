<?php

class Connection extends Mysqli
{
    function __construct()
    {
        parent::__construct('192.168.5.50', 'rommel.rodriguez', '64373465', 'indexinc');
        $this->set_charset('utf8');
        $this->connect_error == NULL ? 'Conexión exítosa a la DB' : die('Error al conectarse a la BD');
    }
}