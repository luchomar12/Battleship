<?php

require_once("./vendor/autoload.php");
include("./Battleship.php");

use PHPUnit\Framework\TestCase;
final class BattleshipTest extends TestCase{


    function testAndaTodo(){
        $this->assertTrue(True);
    }
    function testExisteBattleship(){
        $this->assertTrue(class_exists("Battleship"));
    }
    function testConstruirBattleship(){
        $battleship=new Battleship(20,20,10);
        $this->assertTrue(!empty($battleship));
    }
    function testMostrarTablero1(){
        $battleship=new Battleship(2,2,10);
        $mostrar=$battleship->mostrarTableroJugador1();
        $this->assertEquals([[0,0],[0,0]],$mostrar);
    }
    function testMostrarTablero2(){
        $battleship=new Battleship(2,2,10);
        $mostrar=$battleship->mostrarTableroJugador2();
        $this->assertEquals([[0,0],[0,0]],$mostrar);
    }
    function testColocarNave1(){
        $battleship=new Battleship(3,3,1);//tengo sólo un barco para disponible para poner.
        $battleship->colocarNaveJugador1(2,1);
        $battleship->colocarNaveJugador1(2,2);//para asegurar que no puedo poner mas de un barcoo pruebo poniendo dos.
        $mostrar=$battleship->mostrarTableroJugador1();
        $this->assertEquals([[0,0,0],[0,0,0],[0,1,0]],$mostrar);//aca compruebo que sólo se puso el primer barco luego ya no tengo barcos restantes.
    }
    function testColocarNave2(){
        $battleship=new Battleship(3,3,1);
        $battleship->colocarNaveJugador2(2,1);
        $battleship->colocarNaveJugador2(2,2);
        $mostrar=$battleship->mostrarTableroJugador2();
        $this->assertEquals([[0,0,0],[0,0,0],[0,1,0]],$mostrar);
    }
    function testDisparoJugador1(){
        $battleship=new Battleship(3,3,10);
        $battleship->disparoTurnoJugador1(1,1);
        $mostrar=$battleship->mostrarTirosJugador1();
        $this->assertEquals([[0,0,0],[0,8,0],[0,0,0]],$mostrar);       
    }
    function testAciertoJugador1(){
        $battleship=new Battleship(3,3,10);
        $battleship->colocarNaveJugador2(1,1);
        $battleship->disparoTurnoJugador1(1,1);
        $mostrar1=$battleship->mostrarTirosJugador1();
        $mostrar2=$battleship->mostrarTableroJugador2();
        $this->assertEquals([[0,0,0],[0,2,0],[0,0,0]],$mostrar1);
        $this->assertEquals([[0,0,0],[0,2,0],[0,0,0]],$mostrar2);
    }
    function testDisparoJugador2(){
        $battleship=new Battleship(3,3,10);
        $battleship->disparoTurnoJugador1(1,1);
        $battleship->disparoTurnoJugador2(1,1);
        $mostrar=$battleship->mostrarTirosJugador2();
        $this->assertEquals([[0,0,0],[0,8,0],[0,0,0]],$mostrar);       
    }
    function testAciertoJugador2(){
        $battleship=new Battleship(3,3,10);
        $battleship->colocarNaveJugador1(1,1);
        $battleship->disparoTurnoJugador1(1,1);//el jugador 2 no puede jugar hasta que el primer jugador no haya hecho un disparo.
        $battleship->disparoTurnoJugador2(1,1);
        $mostrar1=$battleship->mostrarTirosJugador2();
        $mostrar2=$battleship->mostrarTableroJugador1();
        $this->assertEquals([[0,0,0],[0,2,0],[0,0,0]],$mostrar1);
        $this->assertEquals([[0,0,0],[0,2,0],[0,0,0]],$mostrar2);
    }
    function testGanoJugador1(){
        $battleship=new Battleship(3,3,2);
        $battleship->colocarNaveJugador1(0,0);
        $battleship->colocarNaveJugador1(0,1);
        $battleship->colocarNaveJugador2(0,0);
        $battleship->colocarNaveJugador2(0,1);
        $battleship->disparoTurnoJugador1(0,0);
        $battleship->disparoTurnoJugador2(1,1);
        $battleship->disparoTurnoJugador1(0,1);
        $gano1=$battleship->ganoJugador1();
        $mostrar1=$battleship->mostrarTableroJugador1();
        $tiros1=$battleship->mostrarTirosJugador1();
        $mostrar2=$battleship->mostrarTableroJugador2();
        $tiros2=$battleship->mostrarTirosJugador2();
        $this->assertEquals([[1,1,0],[0,0,0],[0,0,0]],$mostrar1);
        $this->assertEquals([[2,2,0],[0,0,0],[0,0,0]],$tiros1);
        $this->assertEquals([[2,2,0],[0,0,0],[0,0,0]],$mostrar2);
        $this->assertEquals([[0,0,0],[0,8,0],[0,0,0]],$tiros2);
        $this->assertEquals(true,$gano1);
    }
    function testGanoJugador2(){
        $battleship=new Battleship(3,3,2);
        $battleship->colocarNaveJugador2(0,0);
        $battleship->colocarNaveJugador2(0,1);
        $battleship->colocarNaveJugador1(0,0);
        $battleship->colocarNaveJugador1(0,1);
        $battleship->disparoTurnoJugador1(1,2);
        $battleship->disparoTurnoJugador2(0,0);
        $battleship->disparoTurnoJugador1(1,1);
        $battleship->disparoTurnoJugador2(0,1);
        $gano2=$battleship->ganoJugador2();
        $mostrar2=$battleship->mostrarTableroJugador2();
        $tiros2=$battleship->mostrarTirosJugador2();
        $mostrar1=$battleship->mostrarTableroJugador1();
        $tiros1=$battleship->mostrarTirosJugador1();
        $this->assertEquals([[1,1,0],[0,0,0],[0,0,0]],$mostrar2);
        $this->assertEquals([[2,2,0],[0,0,0],[0,0,0]],$tiros2);
        $this->assertEquals([[2,2,0],[0,0,0],[0,0,0]],$mostrar1);
        $this->assertEquals([[0,0,0],[0,8,8],[0,0,0]],$tiros1);
        $this->assertEquals(true,$gano2);
    }
    function testTerminoElJuego(){
        $battleship=new Battleship(3,3,2);
        $battleship->colocarNaveJugador2(0,0);
        $battleship->colocarNaveJugador2(0,1);
        $battleship->colocarNaveJugador1(0,0);
        $battleship->colocarNaveJugador1(0,1);
        $battleship->disparoTurnoJugador1(1,2);
        $battleship->disparoTurnoJugador2(0,0);
        $battleship->disparoTurnoJugador1(1,1);
        $battleship->disparoTurnoJugador2(0,1);
        $gano2=$battleship->ganoJugador2();
        $mostrar2=$battleship->mostrarTableroJugador2();
        $tiros2=$battleship->mostrarTirosJugador2();
        $mostrar1=$battleship->mostrarTableroJugador1();
        $tiros1=$battleship->mostrarTirosJugador1();
        $termino=$battleship->terminoElJuego();
        $this->assertEquals([[1,1,0],[0,0,0],[0,0,0]],$mostrar2);
        $this->assertEquals([[2,2,0],[0,0,0],[0,0,0]],$tiros2);
        $this->assertEquals([[2,2,0],[0,0,0],[0,0,0]],$mostrar1);
        $this->assertEquals([[0,0,0],[0,8,8],[0,0,0]],$tiros1);
        $this->assertEquals(true,$gano2);
        $this->assertEquals(true,$termino);
    }
    function testCuantosTurnosPasaron(){
        $battleship=new Battleship(3,3,2);
        $battleship->colocarNaveJugador2(0,0);
        $battleship->colocarNaveJugador2(0,1);
        $battleship->colocarNaveJugador1(0,0);
        $battleship->colocarNaveJugador1(0,1);
        $battleship->disparoTurnoJugador1(1,2);
        $battleship->disparoTurnoJugador2(0,0);
        $battleship->disparoTurnoJugador1(1,1);
        $battleship->disparoTurnoJugador2(0,1);
        $turnos=$battleship->cuantosTurnosPasaron();
        $this->assertEquals(4,$turnos);
    }
    function testNoDispararMasDeUnaVezPorJugador(){
        $battleship=new Battleship(3,3,5);
        $battleship->colocarNaveJugador2(0,0);
        $battleship->colocarNaveJugador2(0,1);
        $battleship->colocarNaveJugador1(0,0);
        $battleship->colocarNaveJugador1(0,1);
        $battleship->disparoTurnoJugador1(1,1);
        $battleship->disparoTurnoJugador2(0,0);
        $battleship->disparoTurnoJugador2(0,1);
        $tiros2=$battleship->mostrarTirosJugador2();
        $this->assertEquals([[2,0,0],[0,0,0],[0,0,0]],$tiros2);//aca me aseguro de que el jugador 2 no ha hecho mas de un disparo en su turno.
    }



}