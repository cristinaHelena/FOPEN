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

            $this->setData($results[0]);

            //$this-> setUsuario($row['idusuario']);
            //$this-> setDeslogin($row['deslogin']);
            //$this-> setDessenha($row['dessenha']);
            //$this-> setDtCadastro(new Datetime($row['dtcadastro']));       
         }                                
    }

    public static function getList(){
       
        $sql = new Sql();

        return $sql->select("SELECT * FROM tb_usuarios ORDER BY deslogin;");

    }


    public static function search($login){
       
        $sql = new Sql();

        return $sql->select("SELECT * FROM tb_usuarios where deslogin like :SEARCH ORDER BY deslogin;",array(':SEARCH'=>"%".$login."%"));

    }

    public function login($Login, $password){

        $sql = new Sql();
 
        $results = $sql->select("SELECT * FROM tb_usuarios WHERE deslogin = :LOGIN AND dessenha = :PASSWORD", array(
            ":LOGIN" => $Login,
            ":PASSWORD" => $password
        ));

        if (count($results) > 0){

           $row = $results[0];

               
        } else {

            throw new Exception("Login e/ou senha inválidos.");
        }                                

    }


    public function setData($data){

        $this-> setUsuario($data['idusuario']);
        $this-> setDeslogin($data['deslogin']);
        $this-> setDessenha($data['dessenha']);
        $this-> setDtCadastro(new Datetime($data['dtcadastro']));  

    }

    public function insert(){

        $sql = new Sql();

        $results = $sql->select("CALL sp_usuarios_insert(:LOGIN, :PASSWORD)",array(
            ":LOGIN" =>$this->getDeslogin(),
            ":PASSWORD" =>$this->getDessenha()
        ));

        if (count($results) > 0){
            $this->setData($results[0]);
        }


    }

    public function update($Login, $password){
        $this->setDeslogin($Login);
        $this->setDessenha($password);
        
        $sql = new Sql();
        $sql->query("UPDATE tb_usuarios SET deslogin = :LOGIN, dessenha = :PASSWORD WHERE idusuario = :ID", array(
            ':LOGIN'=>$this->getDeslogin(),
            ':PASSWORD'=>$this->getDessenha(),
            ':ID'=>$this->getUsuario()
        ));
    }

    public function delete(){
       
        $sql = new Sql();
        $sql->query("DELETE from tb_usuarios WHERE idusuario = :ID", array(
            ':ID'=>$this->getUsuario()
        ));
        
        $this->setUsuario(0);
        $this->setDeslogin("");
        $this->setDessenha("");
        $this->setDtCadastro(new DateTime());
    }



    public function __construct($Login = "",$password = ""){

        $this->setDeslogin($Login);
        $this->setDessenha($password);

    }

    public function __toString(){

        return json_encode(array(
            "idusuario"=>$this->getUsuario(),
            "deslogin"=>$this->getDeslogin(),
            "desenha"=>$this->getDessenha(),
            "dtcadastro"=>$this->getDtCadastro()->format("d/m/Y H:i:s")
        ));
    }

}

?>
