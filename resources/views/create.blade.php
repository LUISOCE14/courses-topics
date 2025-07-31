@extends('app')

@section('css')

@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-xl-10">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="d-flex align-items-center">
                    <div>
                        <h1 class="h2 mb-1 fw-bold text-dark">Crear un tema</h1>
                        <p class="text-muted mb-0">Rellena los campos para añadir un nuevo tema al curso.</p>
                    </div>
                </div>
                <a href="{{ route('course-topics.index') }}" class="btn btn-outline-secondary rounded-pill px-3">
                    <i class="bi bi-arrow-left-circle me-1"></i>
                    Volver
                </a>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="card-title mb-0 fw-semibold">Datos del Tema</h5>
                </div>

                <div class="card-body p-4">
                   

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nombre" class="form-label fw-bold">Nombre del Tema</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" value="" placeholder="Ej: Introducción a Laravel 11">
                                <div id="error-nombre" class="invalid-feedback" style="display: none;"></div>
                            </div>

                            <div class="mb-3">
                                <label for="fecha_publicacion" class="form-label fw-bold">Fecha de Publicación</label>
                                <input type="date" class="form-control text-center" id="fecha_publicacion" name="fecha_publicacion" value="">
                                <div id="error-fecha_publicacion" class="invalid-feedback" style="display: none;"></div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="descripcion" class="form-label fw-bold">Descripción</label>
                                <textarea class="form-control" id="descripcion" name="descripcion" rows="5" placeholder="Ej: Un vistazo general al framework, su instalación, estructura de directorios..."></textarea>
                                <div id="error-descripcion" class="invalid-feedback" style="display: none;"></div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="mb-4 form-check">
                                <input type="checkbox" class="form-check-input" id="es_obligatorio" name="es_obligatorio" value="1">
                                <label class="form-check-label" for="es_obligatorio">
                                    ¿Es un tema obligatorio?
                                </label>
                                <div id="error-es_obligatorio" class="invalid-feedback" style="display: none;"></div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end pt-3 border-top">
                        <a href="{{ route('course-topics.index') }}" class="btn btn-secondary me-3">Cancelar</a>
                        <button type="button" class="btn btn-primary fw-bold" id="createTopicBtn">
                            <i class="bi bi-check-circle me-2"></i>
                            Crear tema
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@push('scripts')
@vite(['resources/js/index.js'])
@endpush
