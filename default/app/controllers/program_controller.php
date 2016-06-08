<?php

class ProgramController extends AppController {
    public function programas($tipo = 0) {
        $this->programas = 1;
        $programas = Input::request('tipoProg');
        
        /* Tipos 
            0 -> Todos
            1 -> Técnico Laborales
            2 -> Administración de Gestión del Talento Humano
            3 -> Gestión Contable y Financiero
            4 -> Preparación Física y Entrenamiento Deportivo
            5 -> Sistemas
            6 -> Vigilancia, Seguridad y Control de Instalaciones
            7 -> Ingles Por Niveles */
        
        $this->tipoProg = $tipo;
        
        if($programas > 0){
            View::template(NULL);
        }
    }
    
    public function tecnicos() {
        View::template(NULL);
    }
    
    public function ingles() {
        View::template(NULL);
    }
    
    public function detallePrograma() {
        View::template(NULL);
        
        $this->idPrograma = Input::request('idPrograma');
        $this->nomPrograma = Input::request('nomPrograma');
    }
}
