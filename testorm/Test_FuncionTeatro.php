<?php
        include_once '../orm/Funcion.php';
        include_once '../orm/FuncionTeatro.php';

        $funcion = new FuncionTeatro();
        $funcion->Buscar(4);

        echo $funcion;