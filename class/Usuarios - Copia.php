<?php
class Usuario {

    private $idusuario;
    private $deslogin;
    private $dessenha;
    private $dtcadastro;

//xxxxxxxxxxxxxxxxxxxxxxx

    public function getUsuario(){
        return $this->idusuario;
    }

    public function setUsuario($value){
        $this->idusuario = $value;
    }

    public function getDeslogin(){
        return $this->deslogin;
    } 

    public function setDeslogin($value){
        $this->deslogin = $value;
    }
    		
    public function getDessenha(){
        return $this->dessenha;
    }

    public function setDessenha($value){
        $this->dessenha = $value;
    	}

    public function getDtCadastro(){
        return $this->dtcadastro;
    }

    public function setDtCadastro($value){
        $this->dtcadastro = $value;
    }

    public function loadById($id){

         $sql = new Sql();
 
         $results = $sql->select("SELECT * FROM tb_usuarios WHERE idusuario = :ID", array(
             ":ID" => $id
         ));

         if (count($results) > 0){

            $row = $results[0];

            $this-> setIdusuario($row['idusuario']);
            $this-> setDeslogin($row['deslogin']);
            $this-> setDessenha($row['dessenha']);
            $this-> setDtCadastro(new Datetime($row['dtcadastro']));       
         }                                
    }

    public function __toString(){

        return json_encode(array(
            "idusuario"=>$this->getIdusuario(),
            "deslogin"=>$this->getDeslogin(),
            "desenha"=>$this->getDessenha(),
            "dtcadastro"=>$this->getDtCadastro()->format("d/m/Y H:i:s")
        ));
    }

   

}

?>
