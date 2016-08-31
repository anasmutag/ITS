<?php

class EvaluationController extends AppController {
    public function evaluacionDocente() {
        View::template('grade');
        
        $this->view = 3;
        $this->titulosc = "EVALUACIÓN DOCENTE";
    }
}
