<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <!-- Mensaje de éxito (Toast) -->
                    @if(session('status'))
                        <div id="toast-message" class="fixed top-5 right-5 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg">
                            {{ session('status') }}
                        </div>
                    @endif

                    <!-- Botón Agregar Proyecto alineado a la derecha -->
                    <div class="mb-4 flex justify-end">
                        <a href="{{ route('projects.create') }}" class="inline-flex items-center bg-blue-600 text-white py-2 px-6 rounded-lg shadow-md hover:bg-blue-700 focus:outline-none transition ease-in-out duration-300 transform hover:scale-105">
                            <i class="fas fa-plus mr-2 text-lg"></i> {{ __('Agregar Proyecto') }}
                        </a>
                    </div>

                    <!-- Tabla de Proyectos -->
                    <div class="overflow-x-auto bg-gray-50 shadow-md rounded-lg">
                        <table id="projects-table" class="min-w-full text-sm text-left text-gray-600">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-200 border-b">
                            <tr>
                                <th scope="col" class="px-6 py-3 font-semibold text-center text-gray-700">
                                    {{ __('Nombre del Proyecto') }}
                                </th>
                                <th scope="col" class="px-6 py-3 font-semibold text-center text-gray-700">
                                    {{ __('Estudiante') }}
                                </th>
                                <th scope="col" class="px-6 py-3 font-semibold text-center text-gray-700">
                                    {{ __('Profesor') }}
                                </th>
                                <th scope="col" class="px-6 py-3 font-semibold text-center text-gray-700">
                                    {{ __('Estado') }}
                                </th>
                                <th scope="col" class="px-6 py-3 font-semibold text-center text-gray-700">
                                    {{ __('Acciones') }}
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($projects as $project)
                                <tr class="bg-white border-b hover:bg-gray-100 transition-colors duration-300">
                                    <td class="px-6 py-4 font-medium text-gray-900 text-center">
                                        {{ $project->name }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-700 text-center">
                                        {{ $project->student->name }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-700 text-center">
                                        {{ $project->professor->name }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <!-- Etiqueta de Estado con Color -->
                                        <span class="px-3 py-1 rounded-full text-white
                                                {{ $project->status == 'activo' ? 'bg-green-500' : 'bg-gray-500' }}">
                                                {{ ucfirst($project->status) }}
                                            </span>
                                    </td>
                                    <td class="text-sm text-center">
                                        <!-- Botón Ver -->
                                        <a href="{{ route('projects.show', $project->id) }}" class="text-blue-600 hover:text-blue-800 transition-colors duration-300 text-xl">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        <!-- Botón Editar -->
                                        <a href="{{ route('projects.edit', $project->id) }}" class="text-yellow-500 hover:text-yellow-700 transition-colors duration-300 text-xl">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <!-- Botón Eliminar -->
                                        <button class="text-red-600 hover:text-red-800 transition-colors duration-300 delete-btn text-xl" data-project-id="{{ $project->id }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <!-- Paginación -->
                        <div class="mt-6 mb-4 mr-4 ml-4">
                            {{ $projects->links('pagination::tailwind') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Confirmar Eliminación -->
    <div id="confirm-delete-modal" class="fixed inset-0 flex justify-center items-center bg-black bg-opacity-50 hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
            <h3 class="text-lg font-semibold text-gray-700">{{ __('¿Estás seguro de que deseas eliminar este proyecto?') }}</h3>
            <p class="mt-2 text-sm text-gray-600">{{ __('Esta acción no se puede deshacer.') }}</p>
            <div class="mt-4 flex justify-end space-x-4">
                <button id="cancel-delete" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400">
                    {{ __('Cancelar') }}
                </button>
                <form id="delete-form" method="POST" action="" class="inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700">
                        {{ __('Eliminar') }}
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Mostrar el Toast cuando hay un mensaje de éxito
        if (document.getElementById('toast-message')) {
            setTimeout(function() {
                document.getElementById('toast-message').classList.add('hidden');
            }, 3000); // 3 segundos
        }

        // Obtén los elementos relevantes para el modal
        const deleteButtons = document.querySelectorAll('.delete-btn');
        const modal = document.getElementById('confirm-delete-modal');
        const cancelButton = document.getElementById('cancel-delete');
        const deleteForm = document.getElementById('delete-form');

        // Mostrar el modal de confirmación
        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const projectId = this.getAttribute('data-project-id');
                deleteForm.action = `/projects/${projectId}`;  // Configura la acción del formulario para eliminar el proyecto

                modal.classList.remove('hidden');
            });
        });

        // Cerrar el modal sin eliminar
        cancelButton.addEventListener('click', function() {
            modal.classList.add('hidden');
        });
    </script>
</x-app-layout>
