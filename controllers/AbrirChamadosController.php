<?php

class Chamado {
    private $solicitante;
    private $linhaAtendimento;
    private $local;
    private $item;
    private $descricaoProblema;
    private $observacao;
    private $filial;
    private $departamento;

    public function __construct($solicitante, $linhaAtendimento, $local, $item, $descricaoProblema, $observacao, $filial, $departamento) {
        $this->solicitante = $solicitante;
        $this->linhaAtendimento = $linhaAtendimento;
        $this->local = $local;
        $this->item = $item;
        $this->descricaoProblema = $descricaoProblema;
        $this->observacao = $observacao;
        $this->filial = $filial;
        $this->departamento = $departamento;
    }

    public function getSolicitante() {
        return $this->solicitante;
    }

    public function getLinhaAtendimento() {
        return $this->linhaAtendimento;
    }

    public function getlocal() {
        return $this->local;
    }

    public function getitem() {
        return $this->item;
    }

    public function getDescricaoProblema() {
        return $this->descricaoProblema;
    }

    public function getObservacao() {
        return $this->observacao;
    }

    public function getFilial() {
        return $this->filial;
    }

    public function getDepartamento() {
        return $this->departamento;
    }
}
?>
