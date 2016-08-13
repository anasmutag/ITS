<?php

class GradeController extends AppController {
    public function consultaNotas() {
        View::template('grade');
    }
    
    private function validarCodigoEstudiante($codigo) {
        /*$arr['res'] = 'fail';
        $arr['msg'] = '';*/
        
        $codigo = filter_var(Input::request('codigo'), FILTER_SANITIZE_STRING);
        
        return true;
    }
    
    public function consultarNotas() {
        View::select('mostrarNotas', NULL);
        
        $codigo = filter_var(Input::request('codigo'), FILTER_SANITIZE_STRING);
        
        if($this->validarCodigoEstudiante($codigo)){
            $this->codigo = $codigo;
        }
    }
    
    public function registroNotas() {
        View::template('grade');
    }
}
