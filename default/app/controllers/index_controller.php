<?php

class IndexController extends AppController {
    public function index($banInicio = 0) {
        (Input::request('banInicio') > 0)?View::template(NULL):'';
    }
    
    public function institucion($tipo = 0) {
        $this->institucion = 1;
        $institucion = Input::request('tipoIns');
        
        /* Tipos 
            0 -> General
            1 -> Misión y Visión
            2 -> Visítanos */
        
        $this->tipoIns = $tipo;
        
        if($institucion > 0){
            View::template(NULL);
        }
        
        //View::template(NULL);
    }
    
    public function informacion() {
        View::template(NULL);
        
        /*$this->institucion = 1;
        
        if($banInformacion > 0){
            View::template(NULL);
        }*/
    }
    
    public function visitanos() {
        View::template(NULL);
        
        /*$this->institucion = 1;
        
        if($banVisitanos > 0){
            View::template(NULL);
        }*/
    }
}
