<?php

    Class Cadastro {

        private $pdo;

        public function __construct($dbname, $host, $user, $password) {
            
            try {

                $this->pdo = new PDO("mysql:dbname=".$dbname.";host=".$host, $user, $password);

            } catch (PDOException $e) {

                echo "Erro com banco de dados: ".$e->getMessage();

                exit();

            } catch (Exception $e) {

                echo "Erro generico: ".$e->getMessage();

                exit();

            }
            

        }

        //FUNÇÃO PARA BUSCAR OS DADOS DO BANCO E COLOCAR NA TABELA AO LADO DIREITO
        public function getData() {

            $res = array();

            $select = $this->pdo->prepare("SELECT * FROM cadastro ORDER BY nome");

            $select->execute();

            $res = $select->fetchAll(PDO::FETCH_ASSOC);

            return $res;

        }

        //FUNÇÃO PARA CADASTRAR PESSOAS NO BANCO DE DADOS
        public function registerUSer($nome, $telefone, $email) {

            $select = $this->pdo->prepare("SELECT id FROM cadastro WHERE email = :e");

            $select->bindValue(":e", $email);

            $select->execute();

            if ($select->rowCount() > 0) {

                return false;

            } else {

                $insert = $this->pdo->prepare("INSERT INTO cadastro (nome, telefone, email) VALUES (:n, :t, :e)");

                $insert->bindValue(":n", $nome);
                $insert->bindValue(":t", $telefone);
                $insert->bindValue(":e", $email);

                $insert->execute();

                return true;

            }

        }

        //FUNÇÃO PARA DELETAR PESSOAS NO BANCO DE DADOS
        public function deleteUser($id) {

            $delete = $this->pdo->prepare("DELETE FROM cadastro WHERE id = :id");

            $delete->bindValue(":id", $id);

            $delete->execute();

        }

        //FUNÇÃO PARA PEGAR DADOS DE DETERMINADA PESSOA NO BANCO DE DADOS
        public function getDataUser($id) {

            $res = array();

            $select = $this->pdo->prepare("SELECT * FROM cadastro WHERE id = :id");

            $select->bindValue(":id", $id);

            $select->execute();

            $res = $select->fetch(PDO::FETCH_ASSOC);

            return $res;

        }

        //FUNÇÃO PARA ATUALIZAR PESSOA NO BANCO DE DADOS
        public function updateUser($id, $nome, $telefone, $email) {

            $update = $this->pdo->prepare("UPDATE cadastro SET nome = :n, telefone = :t, email = :e WHERE id = :id");

            $update->bindValue(":n", $nome);
            $update->bindValue(":t", $telefone);
            $update->bindValue(":e", $email);
            $update->bindValue(":id", $id);

            $update->execute();

        }

    }

?>