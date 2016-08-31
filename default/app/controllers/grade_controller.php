<?php

Load::models('Docente');

class GradeController extends AppController {
    public function consultaNotas() {
        View::template('grade');
        
        $this->view = 1;
        $this->titulosc = "CONSULTA DE CALIFICACIONES";
    }
    
    private function validarCodigoEstudiante($codigo) {
        /*$arr['res'] = 'fail';
        $arr['msg'] = '';*/
        
        $codigo = filter_var(Input::request('codigo'), FILTER_SANITIZE_STRING);
        
        return true;
    }
    
    public function consultarNotas() {
        /*View::select('mostrarNotas', NULL);*/
        View::template(NULL);
        
        $codigo = filter_var(Input::request('codigo'), FILTER_SANITIZE_STRING);
        
        if($this->validarCodigoEstudiante($codigo)){
            $this->codigo = $codigo;
        }
    }
    
    public function registroNotas() {
        View::template('grade');
        
        $this->view = 2;
        $this->titulosc = "REGISTRO DE CALIFICACIONES";
    }
    
    public function logearDocente() {
        View::select(NULL, NULL);
        
        $arr['res'] = 'fail';
        $arr['msg'] = '';
        
        $identificacion = Input::request('identificacion');
        $contrasena = Input::request('contrasena');
        
        $docente = new Docente();
        
        if($docente->validarDocente($identificacion, $contrasena)->RESUL == true){
            $auth = new Auth("model", "class: docente", "identificacion_docente: $identificacion");

            if($auth->authenticate()){
                $arr['res'] = 'ok';
            }else{
                $arr['msg'] = 'Ocurrio un error inesperado. Intenta nuevamente';
            }
        }else{
            $arr['msg'] = 'Identificacion o contraseña invalida';
        }

        exit(json_encode($arr));
    }
    
    public function salirDocente() {
        Auth::destroy_identity();
        
        Router::redirect("docentes/inicio/");
    }
    
    public function registrarNotas() {
        if(Auth::is_valid()){
            View::template('grade');
            
            $this->view = 2;
            $this->titulosc = "REGISTRO DE CALIFICACIONES";
        }else{
            Router::redirect("docentes/inicio/");
        }
    }
}
