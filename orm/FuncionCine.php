<?php
    include_once '../orm/FuncionCine.php';
    include_once "../orm/BaseDatos.php";
    class FuncionCine extends Funcion {
        /***
         *  Representacion de la clase Cine.
         *  - Atributos:
         *      + nombre string
         *      + precio float
         *      + inicio array (mes, dia, hora, minuto)
         *      + duracion array (hora, minuto)
         *      + género String 
         *      + país de origen String 
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
        private $genero;
        private $paisOrigen;

        public function __construct(){
            parent::__construct();
            $this->genero = "";
            $this->paisOrigen = "";
        }

        public function cargar($funcion){
            parent::cargar($funcion);
            $this->setGenero($funcion['genero']);
            $this->setPaisOrigen($funcion['paisorigen']);
        }
        
        public function getGenero(){
            return $this->genero;
        }
        public function getPaisOrigen(){
            return $this->paisOrigen;
        }
        public function getmensajeoperacion(){
            return $this->mensajeoperacion;
        }
 
        public function setGenero($nGen){
            $this->genero = $nGen;
        }
        public function setPaisOrigen($nPaiOri){
            $this->paisOrigen = $nPaiOri;
        }
        public function setmensajeoperacion($msj){
            $this->mensajeoperacion=$msj;
        }

        public function Buscar($id){
            $base=new BaseDatos();
            $consulta="Select * from funcioncine where idfuncion=".$id;
            $resp= false;
            if($base->Iniciar()){
                if($base->Ejecutar($consulta)){
                    if($row2=$base->Registro()){
                        parent::Buscar($id);
                        $this->setGenero($row2['genero']);
                        $this->setPaisOrigen($row2['paisorigen']);
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
            $consulta="Select * from funcioncine ";
            if ($condicion!=""){
                $consulta.=" where ".$condicion;
            }
            $consulta.=" order by idfuncion ";
            if($base->Iniciar()){
                if($base->Ejecutar($consulta)){	
                    while($row2=$base->Registro()){                                                
                        $objFuncion=new FuncionCine();
                        $objFuncion->Buscar($row2['idfuncion']);
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
                $consulta="INSERT INTO funcioncine(idfuncion,genero,paisorigen)
                    VALUES (".$this->getIdFuncion().",".$this->getGenero().",'".$this->getPaisOrigen()."')";
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
                $consulta="UPDATE funcioncine SET idfuncion='".$this->getIdFuncion()."' genero='".$this->getGenero()."' paisorigen='".$this->getPaisOrigen()."' WHERE idfuncion='". $this->getIdFuncion();
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
                    $consulta="DELETE FROM funcioncine WHERE idfuncion=".$this->getIdFuncion();
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
            $text.="\nGenero: ".$this->getGenero().
            "\nPais de Origen: ".$this->getPaisOrigen();
            return $text;
        }
    }
