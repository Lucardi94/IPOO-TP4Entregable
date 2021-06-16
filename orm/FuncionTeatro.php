<?php
    include_once '../orm/FuncionTeatro.php';
    include_once '../orm/FuncionMusical.php';
    include_once '../orm/FuncionCine.php';
    include_once '../orm/Teatro.php';
    include_once "../orm/BaseDatos.php";
    class FuncionTeatro extends Funcion {
        /***
         *  Representacion de la clase Cine.
         *  - Atributos:
         *      + nombre string
         *      + precio float
         *      + inicio array (mes, dia, hora, minuto)
         *      + duracion array (hora, minuto)
         */
        public function getmensajeoperacion(){
            return $this->mensajeoperacion;
        }

        public function setmensajeoperacion($msj){
            $this->mensajeoperacion=$msj;
        }

        public function __construct(){
            parent::__construct();
        }

        public function cargar($funcion){
            parent::cargar($funcion);
        }

        public function Buscar($id){
            $base=new BaseDatos();
            $consulta="Select * from funcionteatro where idfuncion=".$id;
            $resp= false;
            if($base->Iniciar()){
                if($base->Ejecutar($consulta)){
                    if($row2=$base->Registro()){
                        parent::Buscar($id);
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
            $consulta="Select * from funcionteatro ";
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
                $consulta="INSERT INTO funcionteatro(idfuncion)
                    VALUES (".$this->getIdFuncion()."')";
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
                $consulta="UPDATE funcionteatro SET idfuncion='".$this->getIdFuncion()."' WHERE idfuncion='". $this->getIdFuncion();
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
                    $consulta="DELETE FROM funcionteatro WHERE idfuncion=".$this->getIdFuncion();
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

    }