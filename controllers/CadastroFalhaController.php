<?php

class Falha {
    private $solicitante;

    public function __construct($solicitante) {
        $this->solicitante = $solicitante;
    }

    public function getSolicitante() {
        return $this->solicitante;
    }
}
?>
