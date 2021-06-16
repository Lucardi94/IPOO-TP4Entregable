<?php
        include_once '../orm/Funcion.php';
        include_once '../orm/FuncionCine.php';
        include_once '../orm/FuncionMusical.php';
        include_once '../orm/FuncionTeatro.php';

        $funcion = new Funcion();
        $colFuncion = $funcion->listar();

        foreach ($colFuncion as $funcion){
            echo $funcion;
        }

    

