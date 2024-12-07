<x-app-layout>
    <!-- Main Content -->
    <div class="flex-1 p-6 bg-gray-100">
        <div class="bg-white p-4 rounded-lg shadow-lg">
            <h3 class="text-xl font-semibold text-gray-900">{{ __('Bienvenido al Dashboard') }}</h3>
            <p class="mt-2 text-sm text-gray-700">{{ __("¡Estás logueado y listo para gestionar los proyectos!") }}</p>

            <!-- Sección de Notificaciones -->
            <div class="mt-6">
                <h4 class="text-lg font-semibold">{{ __('Notificaciones') }}</h4>
                <p class="text-xs text-gray-500">{{ __('Aquí puedes ver las últimas actualizaciones.') }}</p>
            </div>

            <!-- Sección de Comentarios -->
            <div class="mt-6" id="comments-section">
                <h4 class="text-lg font-semibold">{{ __('Últimos Comentarios') }}</h4>

                <!-- Aquí se mostrarán los comentarios dinámicamente -->
                <div id="comments-container" class="space-y-3 mt-4">
                    @foreach($comments as $comment)
                        <div class="comment p-3 bg-gray-50 rounded-lg shadow-sm transition duration-200 transform hover:scale-100">
                            <p class="text-xs text-gray-600">{{ $comment->content }}</p>
                            <div class="mt-1 flex justify-between items-center text-xs text-gray-500">
                                <span>Por {{ $comment->user->name }}</span>
                                <span>{{ $comment->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Botón para cargar más comentarios -->
                <button id="load-more-comments" class="mt-4 px-3 py-1.5 bg-blue-500 text-white text-sm rounded-lg hover:bg-blue-600 transition duration-200">
                    {{ __('Cargar más comentarios') }}
                </button>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    let page = 1;

    document.getElementById('load-more-comments').addEventListener('click', function() {
        fetch(`/dashboard?page=${page + 1}`, {
            method: 'GET',
            headers: { 'Accept': 'application/json' }
        })
            .then(response => response.json())
            .then(data => {
                if (data.comments.length) {
                    data.comments.forEach(comment => {
                        document.getElementById('comments-container').insertAdjacentHTML('beforeend', `
                        <div class="comment p-3 bg-gray-50 rounded-lg shadow-sm transition duration-200 transform hover:scale-100">
                            <p class="text-xs text-gray-600">${comment.content}</p>
                            <div class="mt-1 flex justify-between items-center text-xs text-gray-500">
                                <span>Por ${comment.user.name}</span>
                                <span>${comment.created_at}</span>
                            </div>
                        </div>
                    `);
                    });
                    page++;
                } else {
                    let btn = document.getElementById('load-more-comments');
                    btn.disabled = true;
                    btn.textContent = "No hay más comentarios";
                }
            })
            .catch(error => console.error('Error:', error));
    });
</script>
