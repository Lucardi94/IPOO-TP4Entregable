<?php
        include_once '../orm/Funcion.php';
        include_once '../orm/FuncionMusical.php';

        $funcion = new FuncionMusical();
        $funcion->Buscar(2);

        echo $funcion;