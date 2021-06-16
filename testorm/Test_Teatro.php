<?php 
    include_once '../orm/Teatro.php';
    include_once '../orm/Funcion.php';
    include_once '../orm/FuncionCine.php';
    include_once '../orm/FuncionMusical.php';
    include_once '../orm/FuncionTeatro.php';

    $teatro = new Teatro();
    $teatro->Buscar(2);

    echo $teatro;