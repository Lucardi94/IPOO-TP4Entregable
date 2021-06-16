<?php
    include_once '../orm/FuncionTeatro.php';
    include_once '../orm/FuncionMusical.php';
    include_once '../orm/FuncionCine.php';
    include_once '../orm/Teatro.php';
    include_once "../orm/BaseDatos.php";
class FuncionMusical extends Funcion{
        /***
         *  Representacion de la clase Musical.
         *  - Atributos:
         *      + nombre string
         *      + precio float
         *      + inicio array (mes, dia, hora, minuto)
         *      + duracion array (hora, minuto)
         *      + director String
         *      + cantidad de personas en escena int
         *  - Fuciones:
         *      + darCosto()
         *      + calcularFin()
         *          - ultimoDiaMes($mes)
         *      + inicioPosible($otraFuncion)
         *          - mismaFecha($fechaA, $fechaB) 
         *          - horarioPosible($otroIni, $otroFin)
         *              + horaMayorFin($hora, $min)
         *              + horaMenorFin($hora, $min)
         *              + dentroHorario($hora1, $min1, $hora2, $min2)
         *              + dentroHorarioDos($hora1, $min1, $hora2, $min2)            
         *      + to_string()
         *          - mostrarFecha($fecha)
         *          - mostrarHora($tiempo)
         */
        private $director;
        private $cantidadPersonas;

        public function __construct(){
            parent::__construct();
            $this->director = "";
            $this->cantidadPersonas = "";
        }

        public function cargar($funcion){
            parent::cargar($funcion);
            $this->setDirector($funcion['director']);
            $this->setCantidadPersonas($funcion['cantidadpersonas']);
        }
        
        public function getDirector(){
                return $this->director;
        }
        public function getCantidadPersonas(){
                return $this->cantidadPersonas;
        }
        public function getmensajeoperacion(){
            return $this->mensajeoperacion;
        }

        public function setDirector($nDir){
                $this->director = $nDir;
        }
        public function setCantidadPersonas($nCanPer){
                $this->cantidadPersonas = $nCanPer;
        }     
        public function setmensajeoperacion($msj){
            $this->mensajeoperacion=$msj;
        }

        public function Buscar($id){
            $base=new BaseDatos();
            $consulta="Select * from funcionmusical where idfuncion=".$id;
            $resp= false;
            if($base->Iniciar()){
                if($base->Ejecutar($consulta)){
                    if($row2=$base->Registro()){
                        parent::Buscar($id);
                        $this->setDirector($row2['director']);
                        $this->setCantidadPersonas($row2['cantidadpersonas']);
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
            $consulta="Select * from funcionmusical ";
            if ($condicion!=""){
                $consulta.=' where '.$condicion;
            }
            $consulta.=" order by idfuncion ";
            if($base->Iniciar()){
                if($base->Ejecutar($consulta)){	
                    while($row2=$base->Registro()){                                                
                        $objFuncion=new FuncionMusical();
                        $objFuncion->Buscar($row2['idfuncion']);;
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
            if(parent::insertar()){
                $consulta="INSERT INTO funcionmusical(idfuncion,director,cantidadpersonas)
                    VALUES (".$this->getIdFuncion().",".$this->getDirector().",'".$this->getCantidadPersonas()."')";
                if($base->Iniciar()){
                    if($base->Ejecutar($consulta)){
                        $resp=  true;
                    } else {
                        $this->setmensajeoperacion($base->getError());
                    }
                } else {
                    $this->setmensajeoperacion($base->getError());
                }
             }
            return $resp;
        }

        public function modificar(){
            $resp =false; 
            $base=new BaseDatos();
            if(parent::modificar()){
                $consulta="UPDATE funcionmusical SET idfuncion='".$this->getIdFuncion()."' director='".$this->getDirector()."' cantidadpersonas='".$this->getCantidadPersonas()."' WHERE idfuncion='". $this->getIdFuncion();
                if($base->Iniciar()){
                    if($base->Ejecutar($consulta)){
                        $resp=  true;
                    }else{
                        $this->setmensajeoperacion($base->getError());                        
                    }
                }else{
                    $this->setmensajeoperacion($base->getError());                    
                }
            }            
            return $resp;
        }

        public function eliminar(){
            $base=new BaseDatos();
            $resp=false;
            if($base->Iniciar()){
                    $consulta="DELETE FROM funcionmusical WHERE idfuncion=".$this->getIdFuncion();
                    if($base->Ejecutar($consulta)){
                        if(parent::eliminar()){
                            $resp=  true;
                        }
                    } else {
                            $this->setmensajeoperacion($base->getError());                        
                    }
            } else {
                    $this->setmensajeoperacion($base->getError());                
            }
            return $resp; 
        }

        public function __toString(){
            $text = parent::__toString();
            $text.="\nDirector: ".$this->getDirector().
            "\nCantidad de Personas en escenas: ".$this->getCantidadPersonas();
            return $text;
        }
    }