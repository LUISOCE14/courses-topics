//configuración ruta API
const API_URL = import.meta.env.VITE_API_URL;

document.addEventListener('DOMContentLoaded', function () {
    const fechaInput = document.getElementById('fecha_publicacion');
    const btnGuardar = document.getElementById('createTopicBtn');
    const btnEditar = document.getElementById('actualizarTemaBtn');

    // Si existe el botón de editar, agregar el evento
    if (btnEditar) {
        btnEditar.addEventListener('click', function (event) {
            event.preventDefault();
            if (validaciones()) {
                editarTema();
            }
        });
    }


    // Si existe el botón de guardar, agregar el evento
    if (btnGuardar) {
        btnGuardar.addEventListener('click', function (event) {
            event.preventDefault();
            if (validaciones()) {
                crearTema();
            }
        });
    }

    if (fechaInput) {
        flatpickr(fechaInput, {
            locale: 'es', // Configura el idioma a español
            dateFormat: 'Y-m-d', // Formato de fecha
            minDate: 'today', // Fecha mínima es hoy
            maxDate: new Date().fp_incr(365) // Fecha máxima es un año a partir de hoy
        });
    }
});

//validaciones de los inputs
function validaciones() {
    const nombreInput = document.getElementById('nombre');
    const descripcionInput = document.getElementById('descripcion');
    const fechaPublicacionInput = document.getElementById('fecha_publicacion');
    const esObligatorioInput = document.getElementById('es_obligatorio');

    // Limpiar todos los errores previos al inicio de la validación
    limpiarError(nombreInput);
    limpiarError(descripcionInput);
    limpiarError(fechaPublicacionInput);
    const checkboxErrorDiv = document.getElementById('error-es_obligatorio');
    if (checkboxErrorDiv) {
        checkboxErrorDiv.innerText = '';
        checkboxErrorDiv.style.display = 'none';
    }

    let isValid = true; // Variable para rastrear si todas las validaciones pasan

    const titulo = nombreInput.value.trim();
    const descripcion = descripcionInput.value.trim();
    const fechaPublicacion = fechaPublicacionInput.value;

    // Validaciones y muestra de errores
    if (titulo === '') {
        mostrarError(nombreInput, 'El título es obligatorio.');
        isValid = false; // Marcar como inválido pero continuar
    }

    if (descripcion === '') {
        mostrarError(descripcionInput, 'La descripción es obligatoria.');
        isValid = false; // Marcar como inválido pero continuar
    }

    if (fechaPublicacion === '') {
        mostrarError(fechaPublicacionInput, 'La fecha de publicación es obligatoria.');
        isValid = false; // Marcar como inválido pero continuar
    }

    return isValid; // Devolver el estado final de la validación
}



async function deleteTopic(topicId) {
    console.log(`Eliminando el tema con ID: ${topicId}`);
    
    // Confirmación elegante con SweetAlert2
    const result = await Swal.fire({
        title: '¿Estás seguro?',
        text: "Esta acción no se puede deshacer",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
        reverseButtons: true
    });

    if (!result.isConfirmed) {
        return;
    }
    
    try {
        showLoader();
        const response = await axios.delete(`${API_URL}/api/courses-topics/${topicId}`);
        
        if(response.status == 200) {
            const row = document.querySelector(`tr[data-topic-id="${topicId}"]`);
            if (row) {
                row.style.transition = 'all 0.3s ease';
                row.style.opacity = '0';
                row.style.transform = 'translateX(-100px)';
                
                setTimeout(() => {
                    row.remove();
                    updateTopicCounters(); // Corregido el nombre de la función
                    checkIfTableEmpty();
                }, 300);
            }
        }
        
        // Mensaje de éxito con SweetAlert2
        Swal.fire({
            title: '¡Eliminado!',
            text: 'El tema ha sido eliminado correctamente.',
            icon: 'success',
            timer: 2000,
            showConfirmButton: false
        });
        
    } catch (error) {
        console.error('Error al eliminar el tema:', error);
        Swal.fire({
            title: 'Error',
            text: 'No se pudo eliminar el tema. Inténtalo de nuevo.',
            icon: 'error'
        });
    } finally {
        hideLoader();
    }
}

async function editarTema() {
    const topicId = document.querySelector('.card').getAttribute('data-tema-id');
    const titulo = document.getElementById('nombre').value;
    const descripcion = document.getElementById('descripcion').value;
    const fechaPublicacion = document.getElementById('fecha_publicacion').value;
    const esObligatorio = document.getElementById('es_obligatorio').checked ? 1 : 0;

    const data = {
        nombre: titulo,
        descripcion: descripcion,
        fecha_publicacion: fechaPublicacion,
        es_obligatorio: esObligatorio
    }

    showLoader();
    try {
        const response = await axios.put(`${API_URL}/api/courses-topics/${topicId}`, data);
        console.log('Tema editado:', response.data);

        // OPCIÓN RECOMENDADA: Alert de Bootstrap
        mostrarMensajeExito('¡Tema editado correctamente!');
        limpiarFormulario();

        // Redirigir después de 2 segundos
        setTimeout(() => {
            window.location.href = "/";
        }, 2000);

    } catch (error) {
        console.log('Error al editar el tema:', error);
        mostrarMensajeError('Error al editar el tema. Por favor, inténtalo de nuevo.');
    } finally {
        hideLoader();
    }
}

// Aquí pegas la función que elijas del código anterior
async function crearTema() {
    const titulo = document.getElementById('nombre').value;
    const descripcion = document.getElementById('descripcion').value;
    const fechaPublicacion = document.getElementById('fecha_publicacion').value;
    const esObligatorio = document.getElementById('es_obligatorio').checked ? 1 : 0;

    const data = {
        nombre: titulo,
        descripcion: descripcion,
        fecha_publicacion: fechaPublicacion,
        es_obligatorio: esObligatorio
    }

    showLoader();
    try {
        const response = await axios.post(`${API_URL}/api/courses-topics`, data);
        console.log('Tema creado:', response.data);

        // OPCIÓN RECOMENDADA: Alert de Bootstrap
        mostrarMensajeExito('¡Tema creado correctamente!');
        limpiarFormulario();

        // Redirigir después de 2 segundos
        setTimeout(() => {
            window.location.href = "/";
        }, 2000);

    } catch (error) {
        console.log('Error al crear el tema:', error);
        mostrarMensajeError('Error al crear el tema. Por favor, inténtalo de nuevo.');
    } finally {
        hideLoader();
    }
}

function mostrarMensajeExito(mensaje) {
    const alertaExistente = document.querySelector('.alert-success-custom');
    if (alertaExistente) {
        alertaExistente.remove();
    }

    const alerta = document.createElement('div');
    alerta.className = 'alert alert-success alert-dismissible fade show alert-success-custom';
    alerta.innerHTML = `
        <i class="bi bi-check-circle-fill me-2"></i>
        ${mensaje}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;

    const container = document.querySelector('.container-fluid');
    container.insertBefore(alerta, container.firstChild);

    setTimeout(() => {
        if (alerta) {
            alerta.remove();
        }
    }, 5000);
}

function mostrarMensajeError(mensaje) {
    const alertaExistente = document.querySelector('.alert-danger-custom');
    if (alertaExistente) {
        alertaExistente.remove();
    }

    const alerta = document.createElement('div');
    alerta.className = 'alert alert-danger alert-dismissible fade show alert-danger-custom';
    alerta.innerHTML = `
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        ${mensaje}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;

    const container = document.querySelector('.container-fluid');
    container.insertBefore(alerta, container.firstChild);

    setTimeout(() => {
        if (alerta) {
            alerta.remove();
        }
    }, 5000);
}

function limpiarFormulario() {
    document.getElementById('nombre').value = '';
    document.getElementById('descripcion').value = '';
    document.getElementById('fecha_publicacion').value = '';
    document.getElementById('es_obligatorio').checked = false;
}

// =====================================================
// Aplicar errores a input
// =====================================================

// Función para animación que muestra los errores en los INPUT y SELECT
function aplicarAnimacion(input) {
    // Si es un SELECT2, animar el contenedor visible
    const select2Container = document.querySelector(
        `#${input.id} + .select2 .select2-selection`
    );
    const elementoAnimar = select2Container || input;

    // Quitar animación previa para poder reiniciarla
    elementoAnimar.style.animation = "none";

    // Forzar reflow para que el navegador reinicie la animación
    void elementoAnimar.offsetWidth;

    // Aplicar animación CSS definida en estilos
    elementoAnimar.style.animation = "shake-horizontal 1.0s";

    // Limpiar animación para que se pueda aplicar nuevamente después
    setTimeout(() => {
        elementoAnimar.style.animation = "";
    }, 1000); // Duración debe coincidir con la animación CSS
}

function mostrarError(input, mensaje) {
    const errorDiv = document.getElementById(`error-${input.id}`);
    input.classList.add("is-invalid");

    if (errorDiv) {
        errorDiv.innerText = mensaje;
        errorDiv.style.display = "block";
    }

    aplicarAnimacion(input);

    // Si es Select2, también aplicar clase al contenedor generado por Select2
    const select2Container = document.querySelector(`#${input.id} + .select2`);
    if (select2Container) {
        select2Container.classList.add("select2-invalid");
    }
}

function limpiarError(input) {
    const errorDiv = document.getElementById(`error-${input.id}`);
    input.classList.remove("is-invalid");

    if (errorDiv) {
        errorDiv.innerText = "";
        errorDiv.style.display = "none";
    }

    const select2Container = document.querySelector(`#${input.id} + .select2`);
    if (select2Container) {
        select2Container.classList.remove("select2-invalid");
    }
}

// =============================================
// FUNCIÓN PARA ACTUALIZAR TODOS LOS CONTADORES
// =============================================

function updateTopicCounters() {
    // Contar filas restantes (excluyendo el mensaje de vacío)
    const remainingRows = document.querySelectorAll('#topicsTableBody tr[data-topic-id]');
    const totalCount = remainingRows.length;
    
    // Actualizar contador total
    const totalTopicsElement = document.getElementById('totalTopics');
    if (totalTopicsElement) {
        totalTopicsElement.textContent = totalCount;
    }
    
    // Contar obligatorios y opcionales de las filas restantes
    let mandatoryCount = 0;
    let optionalCount = 0;
    
    remainingRows.forEach(row => {
        const badgeElement = row.querySelector('.badge');
        if (badgeElement) {
            const badgeText = badgeElement.textContent.toLowerCase();
            if (badgeText.includes('obligatorio')) {
                mandatoryCount++;
            } else if (badgeText.includes('opcional')) {
                optionalCount++;
            }
        }
    });
    
    // Actualizar contadores específicos
    const mandatoryTopicsElement = document.getElementById('mandatoryTopics');
    if (mandatoryTopicsElement) {
        mandatoryTopicsElement.textContent = mandatoryCount;
    }
    
    const optionalTopicsElement = document.getElementById('optionalTopics');
    if (optionalTopicsElement) {
        optionalTopicsElement.textContent = optionalCount;
    }
    
    // Actualizar publicados (en tu caso es igual al total)
    const publishedTopicsElement = document.getElementById('publishedTopics');
    if (publishedTopicsElement) {
        publishedTopicsElement.textContent = totalCount;
    }
}

// =============================================
// FUNCIÓN PARA VERIFICAR SI LA TABLA ESTÁ VACÍA
// =============================================

function checkIfTableEmpty() {
    const tbody = document.getElementById('topicsTableBody');
    const dataRows = tbody.querySelectorAll('tr[data-topic-id]');
    
    if (dataRows.length === 0) {
        // Remover cualquier mensaje existente
        tbody.innerHTML = '';
        
        // Agregar mensaje de tabla vacía
        const emptyRow = document.createElement('tr');
        emptyRow.innerHTML = `
            <td colspan="6" class="text-center py-4">
                <div class="text-muted">
                    <i class="bi bi-inbox fs-1 mb-3 d-block"></i>
                    <p class="mb-0 fw-bold">No hay temas de curso registrados</p>
                    <small>¡Comienza creando tu primer tema!</small>
                </div>
            </td>
        `;
        tbody.appendChild(emptyRow);
    }s
}

// IMPORTANTE: Hacer la función global
window.deleteTopic = deleteTopic;