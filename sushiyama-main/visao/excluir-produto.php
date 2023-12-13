<!doctype html>
<?php

include '..\repositorio\conexao.php';
include '..\Modelo\Produto.php';
include '..\Repositorio\ProdutoRepositorio.php';

$produtosRepositorio = new ProdutoRepositorio($conn);
$excluiProduto = $produtosRepositorio->excluirProdutoPorId($_POST['id']);
 $_SESSION['nomeusuario'] = $_POST['nomeusuario'];
 $_SESSION['usuario'] = $_POST['usuario'];
?>
<html lang="pt-br">

<head>
  <title>IFSP - Exclusão de Produto</title>
</head>

<body>
  <main>
    <section class="container-admin-banner">
      <img src="../img/logo-ifsp-removebg.png" class="logo-admin" alt="logo-serenatto">
      <?php
      if ($excluiProduto) {

      ?>
        <h1>Produto excluído com sucesso</h1>
        <img class="ornaments" src="../img/ornaments-coffee.png" alt="ornaments">
    </section>
    <section class="container-form">
      <form action="admin.php" method="post">
        <input type="submit" name="voltar" class="botao-cadastrar" value="voltar" />
        <input type='hidden' name='nomeusuario' value="<?= $_SESSION['nomeusuario']; ?>">
        <input type='hidden' name='usuario' value="<?= $_SESSION['usuario']; ?>">

      </form>
    <?php } else {
        echo "erro ao excluir produto";
      } ?>

    </section>
  </main>
</body>

</html>