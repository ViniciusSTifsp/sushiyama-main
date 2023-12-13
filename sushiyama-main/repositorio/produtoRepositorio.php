<?php
class produtoRepositorio {
    private $conn; // Sua conexão com o banco de dados
    
    public function __construct($conn) {
        $this->conn = $conn;
    }
    
    public function listarProdutos() {
        $sql = "SELECT * FROM produtos";
        $result = $this->conn->query($sql);
        
        $produtos = array();
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $produto = new Produto(
                    $row['cod_produto'],
                    $row['nome'],
                    $row['descricao'],
                    $row['preco'],
                    $row['imagem'],
                    $row['tipo']
                );
                $produtos[] = $produto;
            }
        }
        
        return $produtos;
    }

    public function cadastrar(Produto $produto)
    {
        $sql = "INSERT INTO produtos (nome, descricao, preco, imagem, tipo) VALUES (?,?,?,?,?)";
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            // O prepare() não foi executado com sucesso
            die("Ocorreu um erro ao preparar a consulta SQL.");
        }

        $stmt->bind_param("sssss", $produto->getNome(), $produto->getDescricao(), $produto->getPreco(), $produto->getImagem(),$produto->getTipo());
        $stmt->execute();
        $stmt->close();
    }

    public function excluirProdutoPorId($id)
    {
        $sql = "DELETE FROM produtos WHERE  
             cod_produto = ?";

        // Prepara a declaração SQL
        $stmt = $this->conn->prepare($sql);

        // Vincula o parâmetro
        $stmt->bind_param('i', $id);

        // Executa a consulta preparada
        $success = $stmt->execute();

        // Fecha a declaração
        $stmt->close();

        return $success;
    }

    public function listarPorId($cod_produto, $tipo)
    {
        $sql = "SELECT * FROM produtos WHERE tipo = ?
            AND cod_produto = ? ORDER BY preco LIMIT 1";

        // Prepara a declaração SQL
        $stmt = $this->conn->prepare($sql);

        // Vincula o parâmetro
        $stmt->bind_param('is', $cod_produto, $tipo);

        // Executa a consulta preparada
        $stmt->execute();

        // Obtém os resultados
        $result = $stmt->get_result();

        $produto = null;

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            $produto = new Produto(
                $row['cod_produto'],
                $row['tipo'],
                $row['nome'],
                $row['descricao'],$row['preco'],
                $row['imagem']
                
            );
        }

        // Fecha a declaração
        $stmt->close();

        return $produto;
    }
}
?>