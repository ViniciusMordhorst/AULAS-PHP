<?php

    class funcionario extends Pessoa{
        private $setor;
        private $funcao;

        public function __construct($nome,$email, $senha, $setor, $funcao){
          parent::__construct($nome,$email,$senha);
            $this->setor = $setor;
            $this->funcao = $funcao;
            
        }

            public function setSetor($setor){
                $this->setor = $setor;
            }
            public function getSetor(){
                return $this->setor;

            }

            public function setFuncao($funcao){
                $this->funcao = $funcao;
            }

            public function getFuncao(){
                return $this->funcao;
            }

            public function toString(){
                return "Id: " . $this->getId() . 
                "<br>Nome: ". $this->getNome() . 
                "<br>Email: ". $this->getEmail() . "<br>Setor: ". $this->getSetor() . "<br>Função: ". $this->getFuncao();
                

            }
        
        }
?>