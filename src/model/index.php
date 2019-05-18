<?php
    include_once("paginas.php");
    include_once("redirect.php");
    
    $paginaAtual = 1;
    $quantidadeItensPorPagina = 7;
    $itensPaginaAtual = itensDaPagina($paginaAtual, $quantidadeItensPorPagina);
    refresh($paginaAtual, $quantidadeItensPorPagina, $itensPaginaAtual);
?>