<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Practica11Controller extends Controller
{
    public function calcularSueldo(Request $request){
        $data = $request->all();
        $sueldoPorHora = $data["pago"];
        $horasTrabajadas = $data["horas"];
        if ($horasTrabajadas >= 40) {
            $sueldoSemanal = $sueldoPorHora * 40;
            $horas = $horasTrabajadas - 40;
            $sueldoPorHora *= 2;
            $sueldoSemanal += ($horas * $sueldoPorHora);
        } else {
            $sueldoSemanal = $horasTrabajadas * $sueldoPorHora;
        }
        return view('sueldo_semanal')->with('sueldo', $sueldoSemanal);
    }

    public function calcularRegalo(Request $request) {
        $data = $request->all();
        $dinero = $data["dinero"];
        if($dinero <= 10){
            return view('febrero14')->with('regalo', "Tarjeta");
        }else if($dinero >= 11 && $dinero <= 100){
            return view('febrero14')->with('regalo', "Chocolates");
        }else if($dinero >= 101 && $dinero <= 250){
            return view('febrero14')->with('regalo', "Flores");
        }else{
            return view('febrero14')->with('regalo', "Joyas");
        }
    }
    public function calcularDescuento(Request $request) {
        $data = $request->all();
        $costoInicial = $data["costo"];
        $costoProducto = $costoInicial;
        $descuento = 0;
        if ($costoProducto >= 200) {
            $descuento = .15;
            $descuento = $descuento * $costoProducto;
            $costoProducto = $costoProducto - $descuento;
        } elseif($costoProducto >= 100 && $costoProducto < 200) {
            $descuento = .12;
            $descuento = $descuento * $costoProducto;
            $costoProducto = $costoProducto - $descuento;
        }else{
            $descuento = .1;
            $descuento = $descuento * $costoProducto;
            $costoProducto = $costoProducto - $descuento;
        }
        return view('descuento')->with('costo', $costoInicial)->with('descuento', $descuento)->with('total', $costoProducto);
    }
    public function calcularBeca(Request $request) {
        $data = $request->all();
        $edadAlumno = $data["edad"];
        $promedioAlumno = $data["promedio"];
        if ($edadAlumno > 18) {
            if($promedioAlumno >= 9){
                $beca = 2000;
            }else if($promedioAlumno >= 7.5){
                $beca = 1000;
            }else if($promedioAlumno < 7.5 && $promedioAlumno >= 6){
                $beca = 500;
            }else{
                $beca = "Estudiele mas chavo";
            }
        } else{
            if($promedioAlumno >= 9){
                $beca = 3000;
            }else if($promedioAlumno >= 8 && $promedioAlumno < 9){
                $beca = 2000;
            }else if($promedioAlumno < 8 && $promedioAlumno >= 6){
                $beca = 100;
            }else{
                $beca = "Estudiele mas chavo";
            }
        }
        return view('becas')->with('beca', $beca);
    }
}
