<?php
    include_once '../orm/FuncionTeatro.php';
    include_once '../orm/FuncionMusical.php';
    include_once '../orm/FuncionCine.php';
    include_once '../orm/Teatro.php';
    include_once "../orm/BaseDatos.php";
    class Funcion{
        /***
         *  Representacion de la clase Funcion.
         *  - Atributos:
         *      + nombre string
         *      + precio float
         *      + horaInicio array (mes, dia, hora, minuto)
         *      + duracion array (hora, minuto)
         *  - Fuciones:
         *      + darCosto()
         *      + calcularFin()
         *          - ultimoDiaMes($mes)
         *      + horaInicioPosible($otraFuncion)
         *          - mismaFecha($fechaA, $fechaB) 
         *          - horarioPosible($otroIni, $otroFin)
         *              + horaMayorFin($hora, $min)
         *              + horaMenorFin($hora, $min)
         *              + dentroHorario($hora1, $min1, $hora2, $min2)
         *              + dentroHorarioDos($hora1, $min1, $hora2, $min2)            
         *      + to_string()
         *          - mostrarFecha($fecha)
         *          - mostrarHora($tiempo)
         * */
        private $idFuncion;
        private $nombre;
        private $precio;
        private $horaInicio; // datetime ('aaaa-mm-dd hh:mm')
        private $duracion; // minutos
        private $objTeatro;
        private $mensajeOperacion;

        public function __construct()
        {
            $this->idFuncion = "";
            $this->nombre = "";
            $this->precio = "";
            $this->horaInicio = "";
            $this->duracion = "";
            $this->objTeatro = "";
        }

        public function cargar($funcion){
            $this->setIdFuncion($funcion['idfuncion']);
            $this->setNombre($funcion['nombre']);
            $this->setPrecio($funcion['precio']);
            $this->setHoraInicio($funcion['horainicio']);
            $this->setDuracion($funcion['duracion']);
            $this->setObjTeatro($funcion['objTeatro']);
        }

        public function getIdFuncion(){
            return $this->idFuncion;
        }
        public function getNombre(){
            return $this->nombre;
        }
        public function getPrecio(){
            return $this->precio;
        }
        public function getHoraInicio(){
            return $this->horaInicio;
        }
        public function getDuracion(){
            return $this->duracion;
        }
        public function getObjTeatro(){
            return $this->objTeatro;
        }
        public function getmensajeoperacion(){
            return $this->mensajeoperacion;
        }

        public function setIdFuncion($nid){
            $this->idFuncion = $nid;
        }
        public function setNombre($nNom){
            $this->nombre = $nNom;
        }
        public function setPrecio($nPre){
            $this->precio = $nPre;
        }
        public function setHoraInicio($nIni){
            $this->horaInicio = $nIni;
        }
        public function setDuracion($nDur){
            $this->duracion = $nDur;
        }
        public function setObjTeatro($nObjT){
            $this->objTeatro = $nObjT;
        }
        public function setmensajeoperacion($msj){
            $this->mensajeoperacion=$msj;
        }

        public function Buscar($id){
            $base=new BaseDatos();
            $consulta="Select * from funcion where idfuncion=".$id;
            $resp= false;
            if($base->Iniciar()){
                if($base->Ejecutar($consulta)){
                    if($row2=$base->Registro()){
                        $this->setIdFuncion($id);
                        $this->setNombre($row2['nombre']);
                        $this->setPrecio($row2['precio']);
                        $this->setHoraInicio($row2['horainicio']);
                        $this->setDuracion($row2['duracion']);

                        $objTeatro = new Teatro();
                        $objTeatro->Buscar($row2['idteatro']);
                        $this->setObjTeatro($objTeatro);
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
            $colFuncion = array ();
            $base=new BaseDatos();
            $consulta="Select * from funcion ";
            if ($condicion!=""){
                $consulta.=' where '.$condicion;
            }
            $consulta.=" order by idfuncion ";
            if($base->Iniciar()){
                if($base->Ejecutar($consulta)){
                    while($row2=$base->Registro()){
                        $objTeatro = new Teatro();
                        $objTeatro->Buscar($row2['idteatro']);
                        $row2['objTeatro'] = $objTeatro;

                        $objFuncion=new Funcion();
                        $objFuncion->cargar($row2);
                        array_push($colFuncion,$objFuncion);
                    }                
                } else {
                    $this->setmensajeoperacion($base->getError());    
                }
            } else {
                $this->setmensajeoperacion($base->getError());
            }	
            return $colFuncion;
        }

        public function insertar(){
            $base=new BaseDatos();
            $resp= false;
            $consulta="INSERT INTO funcion(idfuncion,nombre,precio,horainicio,duracion,idteatro) 
                    VALUES (".NULL.",'".$this->getNombre()."','".$this->getPrecio()."','".$this->getHoraInicio()."','".$this->getDuracion()."','".$this->getObjTeatro()->getIdTeatro()."')";            
            if($base->Iniciar()){    
                if($id = $base->devuelveIDInsercion($consulta)){
                    $this->setIdFuncion($id);
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
            $consulta="UPDATE funcion SET idfuncion='".$this->getIdFuncion()."',nombre='".$this->getNombre()."',precio='".$this->getPrecio()."'
            ,horainicio='".$this->getHoraInicio()."',duracion='".$this->getDuracion()."',idteatro=". $this->getObjTeatro()->getIdTeatro()." WHERE id".$this->getIdFuncion();
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
                $consulta="DELETE FROM funcion WHERE idfuncion=".$this->getIdFuncion();
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


        public function __toString()
        {
            return "\nId: ".$this->getIdFuncion().
            "\nFuncion: ".$this->getNombre().
            "\nPrecio: ".$this->getPrecio().
            "\nHora Inicio: ".$this->getHoraInicio().
            "\nDuracion: ".$this->getDuracion().
            "\nTeatro: ".$this->getObjTeatro()->getNombre();
        }
    }