<?php
    function refresh($paginaAtual, $quantidadeItensPorPagina, $itensPaginaAtual) {
        $GLOBALS['paginaAtual'] = $paginaAtual;
        $GLOBALS['quantidadeItensPorPagina'] = $quantidadeItensPorPagina;
        $GLOBALS['itensPaginaAtual'] = $itensPaginaAtual;
        include('../view/view.html');
    }
?>