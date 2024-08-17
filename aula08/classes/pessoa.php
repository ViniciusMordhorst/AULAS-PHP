<?php 
  
    class Pessoa implements gerarHtml {
        private $id;
        private $nome;
        private $email;
        private $senha;

        public function __construct($nome, $email, $senha){
            $this->nome = $nome;
            $this->email = $email;
            $this->senha = $senha;
        }

        public function setId($id){
            $this->id = $id;
        }

        public function getId(){
            return $this->id;
        }

        public function setNome($nome){
            $this->nome = $nome;
        }

        public function getNome(){
            return $this->nome;
        }

        public function setEmail($email){
            $this->email = $email;
        }

        public function getEmail(){
            return $this->email;
        }

        public function setSenha($senha){
            $this->senha = $senha;
        }

        public function getSenha(){
            return $this->senha;
        }

        public function toString(){
            return "Id: " . $this->getId() .
                   "<br>Nome: " . $this->getNome() .
                   "<br>Email: " . $this->getEmail();
        }

        public function getHtml(){
            return "<strong>Id:</strong> " . $this->getId() .
            "<br><strong>Nome:</strong> " . $this->getNome() .
            "<br><strong>Email:</strong> " . $this->getEmail();

        }

    }
?>
