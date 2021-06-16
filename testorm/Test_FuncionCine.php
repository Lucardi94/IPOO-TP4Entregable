<?php
        include_once '../orm/Teatro.php';
        include_once '../orm/Funcion.php';
        include_once '../orm/FuncionCine.php';

        /*$funcion = new FuncionCine();
        $funcion->Buscar(9);
        echo $funcion;

        $col = $funcion->listar();
        foreach ($col as $fun){
            echo $fun;
        }

        $col = $funcion->listar("idteatro=1");
        foreach ($col as $fun){
            echo $fun;
        }*/

        $fun2 = new Funcion();
        $fun2->setIdFuncion(null);
        $fun2->setNombre("pepello");
        $fun2->setPrecio(1000);
        $fun2->setHoraInicio("2000-09-18 19:20");
        $fun2->setDuracion(90);
        $teatro = new Teatro();
        $teatro->Buscar(2);
        $fun2->setObjTeatro($teatro);

        if ($fun2->insertar()){
            echo "Ingreso correctamente";
        };