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
            7 -> Cursos */
        
        $this->tipoProg = $tipo;
        
        if($programas > 0){
            View::template(NULL);
        }
    }
    
    public function tecnicos() {
        View::template(NULL);
    }
    
    public function cursos() {
        View::template(NULL);
    }
    
    public function detallePrograma() {
        View::template(NULL);
        
        $idPrograma = Input::request('idPrograma');
        
        $this->idPrograma = $idPrograma;
        $this->nomPrograma = Input::request('nomPrograma');
        
        switch ($idPrograma) {
            case 2:
                $this->certificado = "Técnico Laboral en Gestión de la Administración del Talento Humano";
                $this->desempeno = ["Apoyar administravamente empresas y organizaciones de cualquier sector, en sus procesos de selección de personal,reclutamiento, bienestar laboral, contratación, ómina, liquidación de contratos, seguridad social y desarrollo organizacional, con una debida orientación a la capacidad de análisis y trabajo en equipo"];
                $this->area = ["Relaciones Laborales", "Contabilidad (Nomina)", "Atención Al Cliente", "Legislación Laboral", "Selección Personal", "Ofimática", "Base de Datos", "Recursos Humanos", "Administración Organizacional", "Clima Laboral", "Legislación Comercial", "Contracción Personal", "Salud Ocupacional", "Proyecto Empresarial"];
                $this->valorsemestre = 1000000;
                
                break;
            case 3:
                $this->certificado = "Técnico Laboral en Gestión Contable y Financiero";
                $this->desempeno = ["Técnico Laboral en Contabilidad", "Técnico Laboral en Finanzas", "Asistente de Presupuesto", "Asistente de Cuentas por Pagar", "Asistente de Contabilidad", "Asistente de Tesorería", "Asistente de Cuentas por Cobrar", "Asistente de Costos", "Asistente de Facturación"];
                $this->area = ["Relaciones Laborales", "Contabilidad", "Atención Al Cliente", "Legislación Laboral", "Matemáticas Financiera", "Ofimática", "Bases de Datos", "Laboratorio Contable", "Administración Organizacional", "Clima Laboral", "Legislación Comercial", "Contabilidad Sistematizada", "Finanzas", "Proyecto Empresarial"];
                $this->valorsemestre = 1000000;
                
                break;
            case 4:
                $this->certificado = "Técnico Laboral en Preparación Fisica y Entrenamiento Deportivo";
                $this->desempeno = ["Entrenador y Preparador Físico", "Instructor de Gimnasios", "Entrenador de Formación Integral Deportiva", "Asesor Desarrollo Planes Deportivos", "Juez y Arbitro", "Recreacionista"];
                $this->area = ["Entrenamiento Deportivo I, II y III", "Fisiología del Movimiento", "Primeros Auxilios", "Alternativa metodológica", "Administración Deporiva", "Deportes en Conjunto (Baloncesto, Futbol de Salón, Futbol)", "Deporte Individual (Atletismo)", "Deporte Individual Modalidad Entrenamiento Fitnes", "Preparación Física I, II, III", "Anatomía", "Pedagogía", "Recreación", "Ingles"];
                $this->valorsemestre = 1000000;
                
                break;
            case 5:
                $this->certificado = "Técnico Laboral en Sistemas";
                $this->desempeno = ["Técnico en Sistemas", "Técnico en Centros de Cómputo", "Técnico en Mantenimiento de Computadores y Redes", "Asesor en Equipos de Cómputo", "Asistente de Diseño Gráfico", "Desarrollador de Páginas Web, Bases de Datos, Apoyo en Software y Hardware a Nivel Personal y Empresarial"];
                $this->area = ["Sistemas Operativos", "Tic's", "Diseño Gráfico", "Programación", "Ingles Técnico", "Mantenimiento de Computadores y Portátiles", "Software (Formateo, Particiones, Instalación)", "Redes (Instalación, Configuración y Administración)", "Ofimática (Word, Excel)", "Bases de Datos", "Diseño Web", "Proyecto Empresarial", "Deporte Formativo"];
                $this->valorsemestre = 1000000;
                
                break;
            case 6:
                $this->certificado = "Técnico Laboral en Vigilancia, Seguridad y Control de Instalaciones";
                $this->desempeno = ["Técnico Laboral en Vigilancia, Seguridad y Control de Instalaciones", "Jefe de Departamento de Seguridad", "Supervisor", "Técnico en Medios Tecnológicos", "Guarda de Seguridad", "Asesor de Empresas en Seguridad Privada"];
                $this->area = ["Electrónica (Alarmas, Sensores)", "Técnica Investigativa (Criminalística)", "Técnicas Brigadas de emergencia", "Observación y Descripción", "Humanidades", "Primeros Auxilios", "Derecho Constitucional", "Administración (Suervisor, Jefe Seguridad)", "Plan de Evacuación, Manejo de Riesgos, Catástrofes", "Medios Tecnológicos (Monitoreo de Cámaras)", "Técnica (Tonfa – Defensa Personal)", "Control de Accesos en Instalaciones", "Acción y Reacción", "Procedimientos", "Salud Ocupacional", "Derecho Penal"];
                $this->valorsemestre = 1000000;
                
                break;
            default:
                break;
        }
    }
}
