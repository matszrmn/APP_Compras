<?php
    function getDataBaseInstance() {
        $host = '127.0.0.1';
        $user = 'matszrmn';
        $pass = '';
        $db = 'app';
        $port = 3306;
        
        $connection = mysqli_connect($host, $user, $pass, $db, $port) or die(mysql_error());
        return $connection;
    }
    
    function numeroTotalDeProdutos() {
        $connection = getDataBaseInstance();
        $totalProdutos = 0;
        $query = "SELECT COUNT(nome) AS total FROM produto;";
        $result = mysqli_query($connection, $query);
            
        while ($row = mysqli_fetch_assoc($result)) $totalProdutos = $row['total'];
        return $totalProdutos;
    }
    function quantidadeAtualProduto($nomeProduto) {
        $connection = getDataBaseInstance();
        $quantidadeAtual = -1; //Valor negativo denota que o produto não existe
        $query = "SELECT quantidade FROM produto WHERE nome='".$nomeProduto."';";
        $result = mysqli_query($connection, $query);
        
        while ($row = mysqli_fetch_assoc($result)) $quantidadeAtual = $row['quantidade'];
        return $quantidadeAtual;
    }
    function adicionarProduto($nomeProduto, $quantidadeNova) {
        $connection = getDataBaseInstance();
        $quantidadeAtual = quantidadeAtualProduto($nomeProduto);
        
        if($quantidadeAtual == -1)  { //Novo produto
            $query = "INSERT INTO produto VALUES('".$nomeProduto."',".$quantidadeNova.");";
        }
        else { //Atualizar quantidade do produto antigo
            $quantidadeNova += $quantidadeAtual;
            if($quantidadeNova > PHP_INT_MAX) return false; //Alem do limite que pode ser armazenado no banco de dados
            $query = "UPDATE produto SET quantidade=".$quantidadeNova." WHERE nome='".$nomeProduto."';";
        }
        if($connection->query($query) === TRUE) return true;
        return false;
    }
    function removerProduto($nomeProduto) {
        $connection = getDataBaseInstance();
        $query = "DELETE FROM produto WHERE nome='".$nomeProduto."';";
        if($connection->query($query) === TRUE) return true;
        return false;
    }
    if (isset($_POST['nomeProduto']) && isset($_POST['quantidade'])) {
        adicionarProduto($_POST['nomeProduto'], $_POST['quantidade']);
    }
?>