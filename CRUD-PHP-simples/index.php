<?php

    require_once 'Cadastro.php';

    $c = new Cadastro("crud_php_simples", "localhost", "root", "");

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>CRUD PHP Simples</title>
</head>
<body>

    <?php

        if(isset($_POST['nome'])) {

            if(isset($_GET['id_up']) && !empty($_GET['id_up'])) {

                $id_update = addslashes($_GET['id_up']);
                $nome = addslashes($_POST['nome']);
                $telefone = addslashes($_POST['telefone']);
                $email = addslashes($_POST['email']);

                if (!empty($nome) && !empty($telefone) && !empty($email)) {

                    if ($c->updateUser($id_update, $nome, $telefone, $email)) {

                        echo "<div id='msg-sucesso'><p>E-mail atualizado com sucesso!</p></div>";

                        header("location: index.php");

                    }

                } else {

                    echo "<div id='msg-erro'><p>Preencha todos os campos!</p></div>";

                }

            } else {

                $nome = addslashes($_POST['nome']);
                $telefone = addslashes($_POST['telefone']);
                $email = addslashes($_POST['email']);

                if (!empty($nome) && !empty($telefone) && !empty($email)) {

                    if ($c->registerUser($nome, $telefone, $email)) {

                        echo "<div id='msg-sucesso'><p>E-mail cadastrado com sucesso!</p></div>";


                    } else {

                        echo "<div id='msg-erro'><p>E-mail já cadastrado</p></div>";

                    } 

                } else {

                    echo "<div id='msg-erro'><p>Preencha todos os campos!</p></div>";

                }

            }

        }

    ?>

    <?php

        if(isset($_GET['id_up'])) {

            $id_update = addslashes($_GET['id_up']);

            $data_update = $c->getDataUser($id_update);

        }

    ?>

    <section class="esquerda">

        <form action="" method="POST">

            <h2>CADASTRAR PESSOA</h2>

            <label for="nome">Nome</label>
            <input type="text" name="nome" id="nome" value="<?php if(isset($data_update)){echo $data_update['nome'];} ?>">

            <label for="telefone">Telefone</label>
            <input type="text" name="telefone" id="telefone" value="<?php if(isset($data_update)){echo $data_update['telefone'];} ?>">

            <label for="email">E-mail</label>
            <input type="mail" name="email" id="email" value="<?php if(isset($data_update)){echo $data_update['email'];} ?>">

            <input type="submit" value="<?php if(isset($data_update)){echo "Atualizar";}else{echo "Cadastrar";} ?>">

        </form>

    </section>

    <section class="direita">

        <table>

            <tr id="titulo">

                <td>NOME</td>
                <td>TELEFONE</td>
                <td colspan="2">E-MAIL</td>

            </tr>

        <?php

            $data = $c->getData();

           /*echo "<pre>";
            print_r($data);
            echo "</pre>";*/

            if (!empty($data)) {

                for ($i = 0; $i < count($data); $i++) {

                    echo "<tr>";

                    foreach ($data[$i] as $key => $value) {

                        if ($key != "id") {

                            echo "<td>$value</td>";

                        }


                    }
                ?>

                    <td>
                        <a href="index.php?id_up=<?php echo $data[$i]['id']; ?>">Editar</a>

                        <a href="index.php?id=<?php echo $data[$i]['id']; ?>">Excluir</a>
                    </td>

                <?php

                    echo "</tr>";

                }

            } else {

        ?>

        </table>

            <?php

                echo "<div id='msg-erro-1'><p>Ainda não há pessoas cadastradas!</p></div>";

            }

            ?>

    </section>
    
</body>
</html>

<?php

    if(isset($_GET['id'])) {

        $id_user = addslashes($_GET['id']);

        $c->deleteUser($id_user);

        header("location: index.php");

    }

?>