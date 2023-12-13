<?php
    require_once "../repositorio/conexao.php";
    require_once "../Modelo/Produto.php";
    require_once "../repositorio/produtoRepositorio.php";

    session_start();
    $usuario = $_SESSION['usuario'];

    if($usuario) {
        $produtoRepositorio = new produtoRepositorio($conn);
        $produtos = $produtoRepositorio->listarProdutos();
    } else {
        session_destroy();
        header("Location: ../visao/login-realizado.php");
    }

?>

<section class="container-table">
    <table>
    <thead>
        <tr>
        <th>Produto</th>
        <th>Tipo</th>
        <th>Descricão</th>
        <th>Valor</th>
        <th colspan="2">Ação</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($produtos as $produto) : ?>
        <tr>
            <td><?= $produto->getNome();  ?></td>
            <td><?= $produto->getTipo();  ?></td>
            <td><?= $produto->getDescricao();  ?></td>
            <td>R$ <?= $produto->getPreco();  ?></td>
            <td>
            <form action="editar-produto.php" method="POST">
                <input type="hidden" name="cod_produto" value="<?= $produto->getCod_produto(); ?>">
                <input type="hidden" name="nomeusuario" value="<?= $usuario; ?>">
                <input type="hidden" name="tipo" value="<?= $produto->getTipo(); ?>">
                <input type="hidden" name="usuario" value="<?= $usuario ?>">
                <input type="submit" class="botao-editar" value="Editar">
            </form>

            </td>
            <td>
            <form action="excluir-produto.php" method="POST">
                <input type="hidden" name="id" value="<?= $produto->getCod_produto(); ?>">
                <input type="hidden" name="nomeusuario" value="<?= $usuario; ?>">
                <input type="hidden" name="tipo" value="<?= $produto->getTipo(); ?>">
                <input type="hidden" name="usuario" value="<?= $usuario; ?>">
                <input type="submit" class="botao-excluir" value="Excluir">
            </form>
            </td>
        </tr>
        <?php endforeach; ?>

    </tbody>
    </table>
    <form action="cadastrar-produto.php" method="POST">
    <input type="hidden" name="nomeusuario" value="<?= $usuario;; ?>">
    <input type="hidden" name="usuario" value="<?= $usuario; ?>">
    <input type="submit" class="botao-cadastrar" name="cadastrar" value="Cadastrar produto">
    </form>
    <form action="#" method="post">
    <input type="submit" class="botao-cadastrar" value="Baixar Relatório" />
    </form>
</section>