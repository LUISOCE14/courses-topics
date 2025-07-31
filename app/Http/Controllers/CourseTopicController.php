<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CourseTopic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Exception;

class CourseTopicController extends Controller
{
    /**
     * Almacenar un nuevo tema de curso
     */
    public function store(Request $request)
    {
        try {
            
            // Validación de los datos de entrada
            $validator = Validator::make($request->all(), [
                'nombre' => 'required|string|max:255',
                'descripcion' => 'required|string',
                'fecha_publicacion' => 'required|date|after_or_equal:today',
                'es_obligatorio' => 'required|boolean'
            ], [
                'nombre.required' => 'El nombre del tema es obligatorio.',
                'nombre.max' => 'El nombre no puede exceder 255 caracteres.',
                'descripcion.required' => 'La descripción del tema es obligatoria.',
                'fecha_publicacion.required' => 'La fecha de publicación es obligatoria.',
                'fecha_publicacion.after_or_equal' => 'La fecha de publicación no puede ser anterior a hoy.',
                'es_obligatorio.required' => 'El campo de obligatoriedad es obligatorio.',
                'es_obligatorio.boolean' => 'El campo de obligatoriedad debe ser verdadero o falso.'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Errores de validación',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Crear un nuevo tema de curso
            $courseTopic = CourseTopic::create($request->only([
                'nombre',
                'descripcion', 
                'fecha_publicacion',
                'es_obligatorio'
            ]));
            
            return response()->json([
                'message' => 'Tema del curso creado exitosamente.',
            ], 201);

        } catch (Exception $e) {
            Log::error("Error al crear el tema del curso: {$e->getMessage()}", [
                'file' => basename($e->getFile()),
                'line' => $e->getLine(),
                'user_id' => auth()->id() ?? 'guest',
                'url' => $request->fullUrl(),
                'method' => $request->method(),
                'data' => $request->all()
            ]);

            return response()->json([
                'message' => 'Ocurrió un error al crear el tema del curso.'
            ], 500);
        }
    }

    /**
     * Actualizar un tema de curso existente
     */
    public function update(Request $request, $id)
    {
        try {
            // Validación de los datos de entrada
            $validator = Validator::make($request->all(), [
                'nombre' => 'required|string|max:255',
                'descripcion' => 'required|string',
                'fecha_publicacion' => 'required|date',
                'es_obligatorio' => 'required|boolean'
            ], [
                'nombre.required' => 'El nombre del tema es obligatorio.',
                'nombre.max' => 'El nombre no puede exceder 255 caracteres.',
                'descripcion.required' => 'La descripción del tema es obligatoria.',
                'fecha_publicacion.required' => 'La fecha de publicación es obligatoria.',
                'es_obligatorio.required' => 'El campo de obligatoriedad es obligatorio.',
                'es_obligatorio.boolean' => 'El campo de obligatoriedad debe ser verdadero o falso.'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Errores de validación',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Buscar y actualizar el tema del curso
            $courseTopic = CourseTopic::findOrFail($id);
            $courseTopic->update($request->only([
                'nombre',
                'descripcion',
                'fecha_publicacion',
                'es_obligatorio'
            ]));

            return response()->json([
                'message' => 'Tema del curso actualizado exitosamente.',
                'course_topic' => $courseTopic->fresh()
            ], 200);

        } catch (Exception $e) {
            Log::error("Error al actualizar el tema del curso: {$e->getMessage()}", [
                'file' => basename($e->getFile()),
                'line' => $e->getLine(),
                'user_id' => auth()->id() ?? 'guest',
                'url' => $request->fullUrl(),
                'method' => $request->method(),
                'course_topic_id' => $id,
                'data' => $request->all()
            ]);

            return response()->json([
                'message' => 'Ocurrió un error al actualizar el tema del curso.'
            ], 500);
        }
    }

    /**
     * Eliminar un tema de curso
     */
    public function destroy($id)
    {
        try {
            $courseTopic = CourseTopic::findOrFail($id);
            $courseTopic->delete();

            return response()->json([
                'message' => 'Tema del curso eliminado exitosamente.'
            ], 200);

        } catch (Exception $e) {
            Log::error("Error al eliminar el tema del curso: {$e->getMessage()}", [
                'file' => basename($e->getFile()),
                'line' => $e->getLine(),
                'user_id' => auth()->id() ?? 'guest',
                'url' => request()->fullUrl(),
                'method' => request()->method(),
                'course_topic_id' => $id
            ]);

            return response()->json([
                'message' => 'Ocurrió un error al eliminar el tema del curso.'
            ], 500);
        }
    }
}