<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<div class="w-full py-8 px-4 sm:px-6 lg:px-8" x-data="cierrecajaTable()">
    <!-- Notificaciones -->
    @if (session('success'))
        <script>
            Swal.fire({
                icon: "success",
                title: "¡Éxito!",
                text: "{{ session('success') }}",
                background: '#18181b',
                color: '#f4f4f5',
                iconColor: '#22c55e',
                confirmButtonColor: '#3b82f6',
                customClass: {
                    popup: 'rounded-lg shadow-lg'
                }
            });
        </script>
    @endif

    @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                html: '<ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>',
                background: '#18181b',
                color: '#f4f4f5',
                iconColor: '#ef4444',
                confirmButtonColor: '#3b82f6',
                customClass: {
                    popup: 'rounded-lg shadow-lg text-left'
                }
            });
        </script>
    @endif

    <!-- Tabla de Cierres de Caja -->
    <div class="w-full bg-zinc-900 rounded-xl shadow-2xl overflow-hidden p-6 border border-zinc-800">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-white">Lista de Cierres de Caja</h1>
            <div class="space-x-2">
                <a href="{{ route('admin.cierrecaja.export-pdf') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Exportar PDF</a>
                <a href="{{ route('admin.cierrecaja.export-excel') }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">Exportar Excel</a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-zinc-800">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-300 uppercase">#</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-300 uppercase">ID Caja</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-300 uppercase">Fecha</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-300 uppercase">Observaciones</th>
                        <th class="px-4 py-3 text-right text-sm font-medium text-zinc-300 uppercase">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-800">
                    @foreach ($cierres as $cierre)
                        <tr>
                            <td class="px-4 py-4 text-sm text-zinc-300">{{ $loop->iteration }}</td>
                            <td class="px-4 py-4 text-sm text-zinc-300">{{ $cierre->id_caja }}</td>
                            <td class="px-4 py-4 text-sm text-zinc-300">{{ \Carbon\Carbon::parse($cierre->fecha)->format('d/m/Y') }}</td>
                            <td class="px-4 py-4 text-sm text-zinc-300">{{ $cierre->observaciones ?? '---' }}</td>
                            <td class="px-4 py-4 text-sm text-right">
                                <button onclick="confirmDelete({{ $cierre->id }})" class="text-red-500 hover:text-red-400">
                                    🖑️
                                </button>
                                <form id="delete-form-{{ $cierre->id }}" action="{{ route('admin.cierrecaja.destroy', $cierre->id) }}" method="POST" class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if ($cierres->hasPages())
            <div class="mt-6">
                {{ $cierres->links() }}
            </div>
        @endif
    </div>
</div>

<script>
    function confirmDelete(id) {
        Swal.fire({
            title: '¿Eliminar cierre?',
            text: "¡No podrás revertir esto!",
            icon: 'warning',
            background: '#18181b',
            color: '#f4f4f5',
            iconColor: '#ef4444',
            confirmButtonColor: '#3b82f6',
            cancelButtonColor: '#6b7280',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            customClass: {
                popup: 'rounded-lg shadow-lg'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }

    function cierrecajaTable() {
        return {
            isOpen: false,
            currentId: null,
            closeModal() {
                this.isOpen = false;
                document.body.classList.remove('overflow-hidden');
            }
        }
    }
</script>
