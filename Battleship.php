<?php

//resolví el ejercicio creando 4 tableros, dos para cada jugador; uno para mostrar el tablero en donde pone SUS barcos y 
//recibe los tiros del otro jugador, y otro tablero para anotar todos los disparos que el jugador realizó al contrincante.

class Battleship{
    private $tableroNaves1=array();
    private $tableroTiros1=array();
    private $tableroNaves2=array();
    private $tableroTiros2=array();
    private $cantBarcos;
    private $barcosJugador1;// por cada barco que pone disminuye en 1 hasta acabar la cantidad de barcos que pueden ponerse.
    private $barcosJugador2;
    private $turno=0;// el valor de esta variable va itinerando de 0 a 1 cada vez que pasa un turno.
                    //el primer jugador sólo puede disparar si la variable está en 0, el segundo sólo si está en 1.


    function __construct($filas, $columnas, $barcos){
        $this->cantBarcos=$barcos;
        $this->barcosJugador1=$barcos;
        $this->barcosJugador2=$barcos;

        for($i=0;$i<$filas;$i=$i+1){
            $this->tableroNaves1[$i]=array();
            for($j=0;$j<$columnas;$j=$j+1){
                $this->tableroNaves1[$i][$j]=0;
            }
        }
        for($i=0;$i<$filas;$i=$i+1){
            $this->tableroTiros1[$i]=array();
            for($j=0;$j<$columnas;$j=$j+1){
                $this->tableroTiros1[$i][$j]=0;
            }
        }
        for($i=0;$i<$filas;$i=$i+1){
            $this->tableroNaves2[$i]=array();
            for($j=0;$j<$columnas;$j=$j+1){
                $this->tableroNaves2[$i][$j]=0;
            }
        }
        for($i=0;$i<$filas;$i=$i+1){
            $this->tableroTiros2[$i]=array();
            for($j=0;$j<$columnas;$j=$j+1){
                $this->tableroTiros2[$i][$j]=0;
            }
        }


    }
    function mostrarTableroJugador1(){
        return $this->tableroNaves1;
    }
    function mostrarTableroJugador2(){
        return $this->tableroNaves2;
    }
    function mostrarTirosJugador1(){
        return $this->tableroTiros1;
    }
    function mostrarTirosJugador2(){
        return $this->tableroTiros2;
    }
    function colocarNaveJugador1($filas,$columnas){
        $cant=$this->barcosJugador1;
        if($cant>0 and $this->tableroNaves1[$filas][$columnas]==0){
            $this->tableroNaves1[$filas][$columnas]=1;
            $this->barcosJugador1=$this->barcosJugador1-1;
        }
    }
    function colocarNaveJugador2($filas,$columnas){
        $cant=$this->barcosJugador2;
        if($cant>0 and $this->tableroNaves2[$filas][$columnas]==0){
            $this->tableroNaves2[$filas][$columnas]=1;
            $this->barcosJugador2=$this->barcosJugador2-1;
        }
    }
    function disparoTurnoJugador1($filas,$columnas){
        if($this->turno==0){//si el valor de turno está en 0 puedo jugar.
            if($this->tableroNaves2[$filas][$columnas]==1){
                $this->tableroTiros1[$filas][$columnas]=2;//marco en mi tablero de tiros con un 2 si acerté el disparo.
                $this->tableroNaves2[$filas][$columnas]=2;//el otro jugador marca en su tablero de barcos con un 2 el barco hundido.
            }else {
                $this->tableroTiros1[$filas][$columnas]=8;//marco en mi tablero de tiros con un 8 si erré el disparo.
            }
            $this->turno=1;//paso el turno de 0 a 1 para habilitar a jugar al otro jugador.
        }

    }
    function disparoTurnoJugador2($filas,$columnas){
        if($this->turno==1){
            if($this->tableroNaves1[$filas][$columnas]==1){
                $this->tableroTiros2[$filas][$columnas]=2;
                $this->tableroNaves1[$filas][$columnas]=2;
            }else {
                $this->tableroTiros2[$filas][$columnas]=8;
            }
            $this->turno=0;
        }
    }
    function ganoJugador1(){
        $barcos=$this->cantBarcos;//si la cantidad de barcos que puse en el constructor es igual al valor del contador gana dicho jugador.
        $contador=0;
        foreach($this->tableroNaves2 as $k => $v){
            foreach($this->tableroNaves2[$k] as $i => $j){
                if($this->tableroNaves2[$k][$i]==2){//busca los barcos hunidos en el tablero del jugador 2.
                    $contador=$contador+1;//si encuentra barcos hundidos aumenta el contador.
                    if($contador==$barcos){//si luego, el contador es igual a la cantidad de barcos disponibles retorna TRUE.
                        return True;
                    }
                }
            }
        }
        return false;
    }
    function ganoJugador2(){
        $barcos=$this->cantBarcos;
        $contador=0;
        foreach($this->tableroNaves1 as $k => $v){
            foreach($this->tableroNaves1[$k] as $i => $j){
                if ($this->tableroNaves1[$k][$i]==2){
                    $contador=$contador+1;
                    if($contador==$barcos){
                        return True;
                    }
                }
            }
        }
        return false;
    }
    function terminoElJuego(){
        if($this->ganoJugador1()==true or $this->ganoJugador2()==true){
            return true;
        }
        return false;
    }
    function cuantosTurnosPasaron(){
        $turnos1=0;
        $turnos2=0;
        foreach($this->tableroTiros1 as $k => $v){
            foreach($this->tableroTiros1[$k] as $i => $j){
                if($j==2 or $j==8){
                    $turnos1=$turnos1+1;//cuenta la cantidad de veces que el jugador 1 ha efectuado un disparo
                                        //representa entonces la candiad de turnos que el jugador 1 jugó.
                }
            }
        }
        foreach($this->tableroTiros2 as $k => $v){
            foreach($this->tableroTiros2[$k] as $i => $j){
                if($j==2 or $j==8){
                    $turnos2=$turnos2+1;//cuenta la cantidad de veces que el jugador 2 ha efectuado un disparo
                                         //representa entonces la candiad de turnos que el jugador 2 jugó.

                }
            }
        }
        return $turnos1+$turnos2;//retorna la cantidad de turnos total que han pasado.
    }

}