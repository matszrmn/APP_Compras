<?php
    include("produto.php");
    
    function totalDePaginas($quantidadeItensPorPagina) {
        $connection = getDataBaseInstance();
        $numeroTotalDeProdutos = numeroTotalDeProdutos();
        $numeroTotalDePaginas = ceil($numeroTotalDeProdutos / $quantidadeItensPorPagina);
        return $numeroTotalDePaginas;
    }
    function itensDaPagina($pagina, $quantidadeItensPorPagina) {
        $connection = getDataBaseInstance();
        $limInferior = ($pagina - 1) * $quantidadeItensPorPagina;
        $query = "SELECT * FROM produto LIMIT ".$limInferior.",".$quantidadeItensPorPagina.";";
        $result = mysqli_query($connection, $query);
        return $result;
    }
    function mudarDePagina($paginaAtual, $quantidadeItensPorPagina, $operacao) {
        $connection = getDataBaseInstance();
        $GLOBALS['paginaAtual'] = $paginaAtual;
        $GLOBALS['quantidadeItensPorPagina'] = $quantidadeItensPorPagina;
        
        $totalDePaginas = totalDePaginas($quantidadeItensPorPagina); //Atualizacao
        $GLOBALS['totalDePaginas'] = $totalDePaginas;
        
        if($operacao == 1 && $paginaAtual > 1) { //Pagina anterior
            $paginaAtual = $paginaAtual-1;
        }
        else if($operacao == 2 && $totalDePaginas > $paginaAtual) { //Pagina posterior
            $paginaAtual = $paginaAtual+1;
        }
        $itensPaginaAtual = itensDaPagina($paginaAtual, $quantidadeItensPorPagina);
        include('redirect.php');
        refresh($paginaAtual, $quantidadeItensPorPagina, $itensPaginaAtual);
    }
    function removerProdutoEatualizar($nomeProduto, $paginaAtual, $quantidadeItensPorPagina) {
        removerProduto($nomeProduto);
        $itensPaginaAtual = itensDaPagina($paginaAtual, $quantidadeItensPorPagina);
        include('redirect.php');
        refresh($paginaAtual, $quantidadeItensPorPagina, $itensPaginaAtual);
    }
    if (isset($_GET['paginaAtual']) && isset($_GET['quantidadeItensPorPagina']) && isset($_GET['operacao'])) {
        mudarDePagina($_GET['paginaAtual'], $_GET['quantidadeItensPorPagina'], $_GET['operacao']);
    }
    if (isset($_GET['nomeProduto']) && isset($_GET['paginaAtual']) && isset($_GET['quantidadeItensPorPagina'])) {
        removerProdutoEatualizar($_GET['nomeProduto'], $_GET['paginaAtual'], $_GET['quantidadeItensPorPagina']);
    }
?>