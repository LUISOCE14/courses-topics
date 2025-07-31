<?php

namespace App\Http\Controllers;

use App\Models\CourseTopic;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;

class ViewController extends Controller
{
    /**
     * Mostrar listado de todos los temas de curso
     */
    public function index()
    {
        try {
            $courseTopics = CourseTopic::orderBy('fecha_publicacion', 'desc')->get();

            return view('index', compact('courseTopics'));
        } catch (Exception $e) {
            Log::error('Error al cargar la lista de temas de curso: ' . $e->getMessage(), [
                'file' => basename($e->getFile()),
                'line' => $e->getLine(),
                'user_id' => auth()->id() ?? 'guest',
                'url' => request()->fullUrl(),
                'method' => request()->method()
            ]);

            // Mostrar vista con colección vacía y error
            $courseTopics = [];
            return view('index', compact('courseTopics'))
                ->withErrors(['error' => 'Ocurrió un error al cargar los temas del curso.']);
        }
    }

    /**
     * Mostrar formulario para crear nuevo tema de curso
     */
    public function create()
    {
        try {
            return view('create');
        } catch (Exception $e) {
            Log::error('Error al cargar la página de creación de tema: ' . $e->getMessage(), [
                'file' => basename($e->getFile()),
                'line' => $e->getLine(),
                'user_id' => auth()->id() ?? 'guest',
                'url' => request()->fullUrl(),
                'method' => request()->method()
            ]);

            return redirect()
                ->route('index')
                ->withErrors(['error' => 'Ocurrió un error al cargar la página de creación de tema.']);
        }
    }

    /**
     * Mostrar formulario para editar tema existente
     */
    public function edit($id)
    {
        try {
            $courseTopic = CourseTopic::findOrFail($id);

            return view('edit', compact('courseTopic'));
        
        } catch (Exception $e) {
            Log::error('Error al cargar formulario de edición: ' . $e->getMessage(), [
                'file' => basename($e->getFile()),
                'line' => $e->getLine(),
                'course_topic_id' => $id,
                'user_id' => auth()->id() ?? 'guest',
                'url' => request()->fullUrl(),
                'method' => request()->method()
            ]);

            return redirect()
                ->route('index')
                ->withErrors(['error' => 'Ocurrió un error al cargar el formulario de edición.']);
        }
    }
}
