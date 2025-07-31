@extends('app')

@section('title', 'Temas de Curso')

@section('css')
    @vite(['resources/css/index.css'])
    
@endsection

@section('content')
<div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-12 col-xl-10">

           
        
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="d-flex align-items-center">
                        <div class="icon-gradient rounded-3 p-2 me-3">
                            <i class="bi bi-book text-white fs-4"></i>
                        </div>
                        <div>
                            <h1 class="h2 mb-1 fw-bold text-dark">Temas de Curso</h1>
                            <p class="text-muted mb-0">Gestiona y organiza los temas de tu curso</p>
                        </div>
                    </div>
                    <a href="{{ route('course-topics.create') }}" class="btn btn-primary btn-lg shadow-sm">
                        <i class="bi bi-plus-circle me-2"></i>
                        Nuevo Tema
                    </a>
                </div>

                <!-- Stats Cards -->
                <div class="row g-4 mb-4">
                    <div class="col-6 col-md-3">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="text-muted small mb-1">Total Temas</p>
                                        <h3 class="fw-bold mb-0" id="totalTopics">{{ $courseTopics->count() }}</h3>
                                    </div>
                                    <div class="stat-icon bg-primary bg-opacity-10 rounded-3 p-3">
                                        <i class="bi bi-book text-primary fs-4"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-6 col-md-3">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="text-muted small mb-1">Obligatorios</p>
                                        <h3 class="fw-bold mb-0" id="mandatoryTopics"> {{ $courseTopics->where('es_obligatorio', true)->count() }}</h3>
                                    </div>
                                    <div class="stat-icon bg-success bg-opacity-10 rounded-3 p-3">
                                        <i class="bi bi-check-circle text-success fs-4"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-6 col-md-3">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="text-muted small mb-1">Opcionales</p>
                                        <h3 class="fw-bold mb-0" id="optionalTopics">{{ $courseTopics->where('es_obligatorio', false)->count() }}</h3>
                                    </div>
                                    <div class="stat-icon bg-warning bg-opacity-10 rounded-3 p-3">
                                        <i class="bi bi-x-circle text-warning fs-4"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-6 col-md-3">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="text-muted small mb-1">Publicados</p>
                                        <h3 class="fw-bold mb-0" id="publishedTopics">{{ $courseTopics->count() }}</h3>
                                    </div>
                                    <div class="stat-icon bg-info bg-opacity-10 rounded-3 p-3">
                                        <i class="bi bi-calendar-check text-info fs-4"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Content Card -->
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0 fw-semibold">Lista de Temas</h5>

                        </div>
                    </div>
                    
                    <div class="card-body p-0">
                    
                        <!-- Topics Table -->
                        <div id="topicsTable" class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="fw-bold text-secondary py-4 px-4 align-middle">ID</th>
                                        <th class="fw-bold text-secondary py-4 px-4 align-middle">Nombre</th>
                                        <th class="fw-bold text-secondary py-4 px-4 align-middle">Descripción</th>
                                        <th class="fw-bold text-secondary py-4 px-4 align-middle">Fecha Publicación</th>
                                        <th class="fw-bold text-secondary py-4 px-4 align-middle">Obligatorio</th>
                                        <th class="fw-bold text-secondary text-end py-4 px-4 align-middle">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="topicsTableBody">
                                @forelse ($courseTopics as $topic)
                                        <tr data-topic-id="{{ $topic->id }}">
                                            <td class="fw-semibold text-dark py-3 px-4 align-middle">{{ $topic->id }}</td>
                                            <td class="py-3 px-4 align-middle">
                                                <strong>{{ $topic->nombre }}</strong>
                                            </td>
                                            <td class="py-3 px-4 align-middle">
                                                <span class="text-muted">
                                                    {{ Str::limit($topic->descripcion, 50) }}
                                                </span>
                                            </td>
                                            <td class="py-3 px-4 align-middle">
                                                <span class="badge bg-info py-2 px-3 rounded-3 fw-semibold text-uppercase">
                                                    {{ $topic->fecha_publicacion->format('d/m/Y') }}
                                                </span>
                                            </td>
                                            <td class="py-3 px-4 align-middle">
                                                @if($topic->es_obligatorio)
                                                    <span class="badge bg-danger py-2 px-3 rounded-3 fw-semibold text-uppercase">Obligatorio</span>
                                                @else
                                                    <span class="badge bg-secondary py-2 px-3 rounded-3 fw-semibold text-uppercase">Opcional</span>
                                                @endif
                                            </td>
                                            <td class="text-end py-3 px-4 align-middle">
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('course-topics.edit', $topic->id) }}" class="btn btn-sm btn-outline-primary me-1" title="Editar tema">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <button class="btn btn-sm btn-outline-danger" 
                                                            onclick="deleteTopic('{{ $topic->id }}')" 
                                                            title="Eliminar tema" 
                                                            data-id ="{{ $topic->id }}">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-4">
                                                <div class="text-muted">
                                                    <i class="bi bi-inbox fs-1 mb-3 d-block"></i>
                                                    <p class="mb-0 fw-bold">No hay temas de curso registrados</p>
                                                    <small>¡Comienza creando tu primer tema!</small>
                                                </div>
                                            </td>
                                        </tr>
                                @endforelse
                                </tbody>
                            </table>
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