<?php

class CadastroUsuarioForm {
    private $nome;
    private $departamento;
    private $nivel;
    private $senha;

    public function __construct($nome, $departamento, $nivel, $senha) {
        $this->nome = $nome;
        $this->departamento = $departamento;
        $this->nivel = $nivel;
        $this->senha = $senha;
    }
    
    public function getNome() {
        return $this->nome;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function getDepartamento() {
        return $this->departamento;
    }

    public function setDepartamento($departamento) {
        $this->departamento = $departamento;
    }

    public function getNivel() {
        return $this->nivel;
    }

    public function setNivel($nivel) {
        $this->nivel = $nivel;
    }

    public function getSenha() {
        return $this->senha;
    }

    public function setSenha($senha) {
        $this->senha = $senha;
    }
}

?>
