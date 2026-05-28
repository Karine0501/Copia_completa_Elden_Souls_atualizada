<?php
class pedido{
    private $cod_ped;
    private $cod_cli;
    private $data_ped;
    private $total;  
    private $status;
   

   public function setCodPed($cod_ped)
    {
        $this->cod_ped = $cod_ped;
    }
    public function getCodPed()
    {
        return $this->cod_ped;
    }



    public function setCodCli($cod_cli)
    {
        $this->cod_cli = $cod_cli;
    }
    public function getCodCli()
    {
        return $this->cod_cli;

    }



    public function setDataPed($data_ped)
    {
        $this->data_ped = $data_ped;
    }
    public function getDataPed()
    {
        return $this->data_ped;
    }



    public function setTotal($total)
    {
        $this->total = $total;
    }
    public function getTotal()
    {
        return $this->total;
    }



    public function setStatus($status)
    {
        $this->status = $status;
    }
    public function getStatus()
    {
        return $this->status;
    }

    
}

?>