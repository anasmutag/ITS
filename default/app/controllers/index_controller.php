<?php

Load::models('Correo');

class IndexController extends AppController {
    public function index($banInicio = 0) {
        (Input::request('banInicio') > 0)?View::template(NULL):'';
    }
    
    public function institucion($tipo = 0) {
        $this->institucion = 1;
        $institucion = Input::request('tipoIns');
        
        /* Tipos 
            0 -> Defecto
            1 -> Misión y Visión
            2 -> Visítanos
            3 -> General */
        
        $this->tipoIns = $tipo;
        
        if($institucion > 0){
            View::template(NULL);
        }
    }
    
    public function informacion() {
        View::template(NULL);
    }
    
    public function visitanos() {
        View::template(NULL);
    }
    
    public function contactenos() {
        $this->contactenos = 1;
    }
    
    public function enviarCorreoElectronico() {
        View::select(null, null);
        
        $correo = new Correo();
        
        $arr['res'] = 'fail';
        $arr['msg'] = '';
        
        $nombre = filter_var(Input::request('nombre'), FILTER_SANITIZE_STRING);
        $email = filter_var(Input::request('email'), FILTER_SANITIZE_STRING);
        $asunto = filter_var(Input::request('asunto'), FILTER_SANITIZE_STRING);
        $mensaje = filter_var(Input::request('mensaje'), FILTER_SANITIZE_STRING);
        
        if(!filter_var($email, FILTER_VALIDATE_EMAIL) === false){
            //echo("$email is a valid email address");
            
            if($correo->enviarSolicitud($nombre,$email,$asunto,$mensaje)){
                $arr['res'] = 'ok';
                $arr['msg'] = 'Solicitud de información enviada con exito.';
            }else{
                $arr['msg'] = 'Ocurrio un error al enviar tu solicitud. Intenta nuevamente.';
            }
        }else{
            //echo("$email is not a valid email address");
            
            $arr['msg'] = 'Correo electrónico no valido.';
        }
        
        exit(json_encode($arr));
    }
    
    public function map() {
        View::template(NULL);
        
        $this->sede = Input::request('sede');
    }
}
