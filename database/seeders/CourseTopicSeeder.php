<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CourseTopic; // Asegúrate de que la ruta a tu modelo es correcta

class CourseTopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // Elimina los datos existentes para evitar duplicados al re-ejecutar el seeder
        CourseTopic::truncate();

        $topics = [
            [
                'nombre' => 'Introducción a Laravel 11',
                'descripcion' => 'Un vistazo general al framework, su instalación, estructura de directorios y el ciclo de vida de una petición.',
                'fecha_publicacion' => '2024-01-15',
                'es_obligatorio' => true
            ],
            [
                'nombre' => 'Rutas y Controladores',
                'descripcion' => 'Aprende a definir rutas web y de API, y a organizar la lógica de tu aplicación utilizando controladores.',
                'fecha_publicacion' => '2024-01-22',
                'es_obligatorio' => true
            ],
            [
                'nombre' => 'Vistas con Blade',
                'descripcion' => 'Domina el motor de plantillas de Laravel, Blade, para crear vistas dinámicas y reutilizables con layouts, componentes y directivas.',
                'fecha_publicacion' => '2024-02-05',
                'es_obligatorio' => true
            ],
            [
                'nombre' => 'Eloquent ORM Básico',
                'descripcion' => 'Interactúa con tu base de datos de forma fluida y expresiva. Aprende a definir modelos, relaciones y a realizar consultas básicas.',
                'fecha_publicacion' => '2024-02-19',
                'es_obligatorio' => true
            ],
            [
                'nombre' => 'Validación de Formularios',
                'descripcion' => 'Asegura la integridad de los datos de tu aplicación implementando reglas de validación robustas tanto en el backend como en el frontend.',
                'fecha_publicacion' => '2024-03-04',
                'es_obligatorio' => true
            ],
            [
                'nombre' => 'Autenticación con Breeze',
                'descripcion' => 'Implementa un sistema completo de autenticación (registro, login, reseteo de contraseña) en minutos usando Laravel Breeze.',
                'fecha_publicacion' => '2024-03-18',
                'es_obligatorio' => false
            ],
            [
                'nombre' => 'Pruebas Unitarias y TDD',
                'descripcion' => 'Escribe pruebas para tu código para garantizar su correcto funcionamiento y facilitar el mantenimiento futuro. Introducción a PHPUnit y Pest.',
                'fecha_publicacion' => '2024-04-01',
                'es_obligatorio' => false
            ],
            [
                'nombre' => 'Desarrollo de APIs RESTful',
                'descripcion' => 'Crea APIs robustas y escalables para que tus aplicaciones frontend o móviles puedan consumir los datos de tu backend.',
                'fecha_publicacion' => '2024-04-15',
                'es_obligatorio' => true
            ],
            [
                'nombre' => 'Manejo de Colas y Trabajos',
                'descripcion' => 'Aprende a diferir tareas que consumen mucho tiempo, como el envío de correos electrónicos, para ejecutarlas en segundo plano y mejorar la velocidad de respuesta de tu app.',
                'fecha_publicacion' => '2024-05-06',
                'es_obligatorio' => false
            ],
            [
                'nombre' => 'Frontend con Vite',
                'descripcion' => 'Integra y compila tus assets de frontend (CSS y JavaScript) de manera moderna y ultra-rápida utilizando Vite.',
                'fecha_publicacion' => '2024-05-20',
                'es_obligatorio' => true
            ]
        ];

        // Itera sobre el array y crea cada registro
        foreach ($topics as $topic) {
            CourseTopic::create($topic);
        }
    }
}