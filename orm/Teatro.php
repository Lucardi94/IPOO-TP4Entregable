<?php
    include_once '../orm/FuncionTeatro.php';
    include_once '../orm/FuncionMusical.php';
    include_once '../orm/FuncionCine.php';
    include_once '../orm/Funcion.php';
    include_once "../orm/BaseDatos.php";
    class Teatro{
        /***
         * Representacion de la clase teatro.
         *  - Atributos:
         *      + string nombre
         *      + string dirección
         *      + array funciones al día (4)
         *  - Funciones:
         *      + darCostoMensual($mes)
         *      + cambiarNombre($nuevoNombre)
         *      + cambiarDirección($nuevaDireccion)
         *      + CambiarNombreFunción($nuevoNombre, $i)
         *      + CambiarPrecioFuncion($nuevoPrecio, $i)
         *      + seleccionFuncion()
         *      + mostrarFunciones()
         *      + cargarFucion()
         *          - verificarHorario($otraFuncion)
         *      + tooString()
         *          - mostrarFunciones()
         */

        private $idTeatro;
        private $nombre;
        private $direccion;
        private $listaObjFuncion;
        private $mensajeOperacion;

        public function __construct()
        {
            $this->idTeatro = 0;
            $this->nombre = "";
            $this->direccion = "";
            $this->listaObjFuncion = "";
        }

        public function cargar($funcion){
            $this->setIdTeatro($funcion['idteatro']);
            $this->setNombre($funcion['nombre']);
            $this->setDireccion($funcion['direccion']);
            $this->setListaObjFuncion($funcion['listaobjfuncion']);
        }

        public function getIdTeatro(){
            return $this->idTeatro;
        }
        public function getNombre(){
             return $this->nombre;
        }
        public function getDireccion(){
            return $this->direccion;
        }
        public function getListaObjFuncion(){
            return $this->listaObjFuncion;
        }
        public function getmensajeoperacion(){
            return $this->mensajeOperacion;
        }
        
        public function setIdTeatro($nId){
            $this->idTeatro = $nId;
        }
        public function setNombre($nom){
            $this->nombre = $nom;
        }
        public function setDireccion($dir){
            $this->direccion = $dir;
        }
        public function setListaObjFuncion($lisOF){
            $this->listaObjFuncion = $lisOF;
        }
        public function setmensajeoperacion($mensajeoperacion){
            $this->mensajeOperacion = $mensajeoperacion;
        }

        public function Buscar($id){
            $base=new BaseDatos();
            $consulta="Select * from teatro where idteatro=".$id;
            $resp= false;
            if($base->Iniciar()){
                if($base->Ejecutar($consulta)){
                    if($row2=$base->Registro()){
                        $this->setIdTeatro($id);
                        $this->setNombre($row2['nombre']);
                        $this->setDireccion($row2['direccion']);

                        $objCine = new FuncionCine();
                        $colCine = $objCine->listar("'idTeatro='".$id);
                        $objMusical = new FuncionMusical();
                        $colMusical = $objMusical->listar("'idTeatro='".$id);
                        $objTeatro = new FuncionTeatro();
                        $colTea = $objTeatro->listar("'idTeatro='".$id);
                        $this->setListaObjFuncion(array_merge($colCine,$colMusical,$colTea));

                        $resp= true;
                    }                
                } else {
                    $this->setmensajeoperacion($base->getError());                     
                }
            } else {
                $this->setmensajeoperacion($base->getError());                 
            }		
            return $resp;
        }	
        
    
        public function listar($condicion=""){
            $colTeatro = array ();
            $base=new BaseDatos();
            $consulta="Select * from teatro ";
            if ($condicion!=""){
                $consulta.=' where '.$condicion;
            }
            $consulta.=" order by idteatro ";
            if($base->Iniciar()){
                if($base->Ejecutar($consulta)){
                    while($row2=$base->Registro()){

                        $cond = ' idteatro='.$row2['idteatro'].";";
                        $objCine = new FuncionCine();
                        $colCine = $objCine->listar($cond);
                        $objMusical = new FuncionMusical();
                        $colMusical = $objMusical->listar($cond);
                        $objTeatro = new FuncionTeatro();
                        $colTea = $objTeatro->listar($cond);
                        $row2['listaobjfuncion'] = array_merge($colCine,$colMusical,$colTea);

                        $objTeatro = new Teatro();
                        $objTeatro->cargar($row2);
                        array_push($colTeatro,$objTeatro);
                    }                
                } else {
                    $this->setmensajeoperacion($base->getError());    
                }
            } else {
                $this->setmensajeoperacion($base->getError());
            }	
            return $colTeatro;
        }

        public function insertar(){
            $base=new BaseDatos();
            $resp= false;
            $consulta="INSERT INTO teatro(idteatro,nombre,direccion) 
                    VALUES (".NULL.",'".$this->getNombre()."','".$this->getDireccion()."')";            
            if($base->Iniciar()){    
                if($id = $base->devuelveIDInsercion($consulta)){
                    $this->setIdTeatro($id);
                    $resp=  true;    
                } else {
                    $this->setmensajeoperacion($base->getError());                        
                }    
            } else {
                    $this->setmensajeoperacion($base->getError());                
            }
            return $resp;
        }
        
        public function modificar(){
            $resp =false; 
            $base=new BaseDatos();
            $consulta="UPDATE teatro SET idteatro='".$this->getIdTeatro()."',nombre='".$this->getNombre()."',direccion='".$this->getDireccion()." WHERE id".$this->getIdTeatro();
            if($base->Iniciar()){
                if($base->Ejecutar($consulta)){
                    $resp=  true;
                } else{
                    $this->setmensajeoperacion($base->getError());                    
                }
            } else{
                    $this->setmensajeoperacion($base->getError());                
            }
            return $resp;
        }
        
        public function eliminar(){
            $base=new BaseDatos();
            $resp=false;
            if($base->Iniciar()){
                $consulta="DELETE FROM teatro WHERE idteatro=".$this->getIdTeatro();
                if($base->Ejecutar($consulta)){
                    $resp=  true;
                }else{
                    $this->setmensajeoperacion($base->getError());                        
                }
            }else{
                $this->setmensajeoperacion($base->getError());                
            }
            return $resp; 
        }
        
        public function mostrar(){
            $col = $this->getListaObjFuncion();
            foreach ($col as $funcion){
                echo $funcion."\n";
            }
        }

        public function __toString(){
            return "Id: ".$this->getIdTeatro().
            "\nTeatro: ".$this->getNombre().
            "\nDireccion: ".$this->getDireccion().
            "\n[Funciones]\n".$this->mostrar();
        }

    }