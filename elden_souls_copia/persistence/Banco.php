<?php

class Banco
{
    private $url;
    private $usuario;
    private $senha;
    private $database;
    private $con;
    private $connected = false;

    public function __construct()
    {
        $this->url = "localhost";
        $this->usuario = "root";
        $this->senha = "";
        $this->database = "eldensouls";

        $this->con = new mysqli(
            $this->url,
            $this->usuario,
            $this->senha,
            $this->database
        );

        if ($this->con->connect_error) {
            die("Erro de conexão: " . $this->con->connect_error);
        }

        $this->con->set_charset("utf8mb4");

        $this->connected = true;
    }


    public function executar($sql)
        {
            if($this->con->query($sql)){
                return true;
            }else{
                return false;   
        }
        }
 

     public function conectar()
    {
        if (!$this->connected || !$this->con) {
            $this->__construct();
        }

        return $this->con;
    }


    public function consultar($sql)
    {
        $this->conectar();

        $consulta = $this->con->query($sql);

        if (!$consulta) {
            die("Erro SQL (consultar): " . $this->con->error);
        }

        return $consulta;
    }

    public function desconectar()
    {
        if ($this->con instanceof mysqli) {
            $this->con->close();
            $this->connected = false;
            $this->con = null;
        }
    }
}

?>