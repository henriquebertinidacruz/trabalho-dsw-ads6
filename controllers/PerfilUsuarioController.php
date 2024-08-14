<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/trabalho-dsw-ads6/models/PerfilUsuarioModel.php');

class PerfilUsuarioController
{
    private $perfilUsuarioModel;

    public function __construct()
    {
        $this->perfilUsuarioModel = new PerfilUsuarioModel();
    }

    public function returnUserProfile()
    {
        if (isset($_SESSION['username'])) {
            $username = $_SESSION['username'];
            $user = $this->perfilUsuarioModel->returnUsersDatas($username);
            if ($user) {
                require_once($_SERVER['DOCUMENT_ROOT'] . '/trabalho-dsw-ads6/views/PerfilUsuario.php');
            } else {
                echo 'Usuário não encontrado.';
            }
        } else {
            echo 'Você precisa estar logado para ver o perfil.';
        }
    }
}
