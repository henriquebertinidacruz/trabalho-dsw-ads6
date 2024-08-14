<?php
class Chamado {
    private $idDoChamado;
    private $solucaoProblema;
    private $descricaoProblema;
    private $tecnicoResponsavel;

    public function __construct($idDoChamado, $solucaoProblema, $descricaoProblema, $tecnicoResponsavel) {
        $this->idDoChamado = $idDoChamado;
        $this->solucaoProblema = $solucaoProblema;
        $this->descricaoProblema = $descricaoProblema;
        $this->tecnicoResponsavel = $tecnicoResponsavel;
    }

    public function getIdDoChamado() {
        return $this->idDoChamado;
    }

    public function getSolucaoProblema() {
        return $this->solucaoProblema;
    }

    public function getDescricaoProblema() {
        return $this->descricaoProblema;
    }
    
    public function getTecnicoResponsavel() {
        return $this->tecnicoResponsavel;
    }
}
?>
