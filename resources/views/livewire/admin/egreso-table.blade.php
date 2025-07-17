<div class="w-full py-8 px-4 sm:px-6 lg:px-8" x-data="egresoTable()">
    {{-- Notificaciones --}}
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
                customClass: { popup: 'rounded-lg shadow-lg' }
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
                customClass: { popup: 'rounded-lg shadow-lg text-left' }
            });
        </script>
    @endif

    <div class="w-full bg-zinc-900 rounded-xl shadow-2xl overflow-hidden p-6 border border-zinc-800">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-white">Lista de Egresos</h1>
            <div class="flex space-x-4">
                <a href="{{ route('admin.egreso.exportPdf') }}" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                    Exportar PDF
                </a>
                <a href="{{ route('admin.egreso.exportExcel') }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                    Exportar Excel
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-zinc-800">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-300 uppercase">#</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-300 uppercase">Fecha</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-300 uppercase">Monto (S/.)</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-300 uppercase">Tipo</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-300 uppercase">Descripción</th>
                        <th class="px-4 py-3 text-right text-sm font-medium text-zinc-300 uppercase">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-800">
                    @foreach ($egresos as $egreso)
                        <tr>
                            <td class="px-4 py-4 text-sm text-zinc-300">{{ $loop->iteration }}</td>
                            <td class="px-4 py-4 text-sm text-zinc-300">{{ \Carbon\Carbon::parse($egreso->fecha)->format('d/m/Y') }}</td>
                            <td class="px-4 py-4 text-sm text-zinc-300">S/ {{ number_format($egreso->monto, 2) }}</td>
                            <td class="px-4 py-4 text-sm text-zinc-300">{{ $egreso->tipo_egreso }}</td>
                            <td class="px-4 py-4 text-sm text-zinc-300">{{ $egreso->descripcion ?? '---' }}</td>
                            <td class="px-4 py-4 text-sm text-right">
                                <button @click="openModal({{ $egreso->id }}, '{{ addslashes($egreso->tipo_egreso) }}', '{{ addslashes($egreso->descripcion ?? '') }}', '{{ $egreso->fecha }}', '{{ $egreso->monto }}')" class="text-blue-500 hover:text-blue-400 mr-3">
                                    ✎
                                </button>
                                <button onclick="confirmDelete({{ $egreso->id }})" class="text-red-500 hover:text-red-400">
                                    🗑️
                                </button>
                                <form id="delete-form-{{ $egreso->id }}" action="{{ route('admin.egreso.destroy', $egreso->id) }}" method="POST" class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if ($egresos->hasPages())
            <div class="mt-6">
                {{ $egresos->links() }}
            </div>
        @endif
    </div>

    <!-- Modal Edición -->
    <template x-teleport="body">
        <div x-show="isOpen" x-cloak x-transition class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen px-4 py-12">
                <div class="fixed inset-0 bg-black opacity-75" @click="closeModal"></div>
                <div class="relative bg-zinc-900 rounded-lg w-full max-w-lg p-8 shadow-xl border border-zinc-800 z-50">
                    <h3 class="text-xl font-bold text-white mb-6">Editar Egreso</h3>
                    <form :action="'/admin/egreso/' + currentId" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label class="block text-sm text-zinc-300 mb-1">Fecha</label>
                            <input type="date" x-model="fecha" name="fecha" class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg text-white" required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm text-zinc-300 mb-1">Monto (S/.)</label>
                            <input type="number" x-model="monto" step="0.01" name="monto" class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg text-white" required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm text-zinc-300 mb-1">Tipo de Egreso</label>
                            <input type="text" x-model="tipo_egreso" name="tipo_egreso" class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg text-white" required>
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm text-zinc-300 mb-1">Descripción</label>
                            <textarea x-model="descripcion" name="descripcion" rows="3" class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg text-white"></textarea>
                        </div>

                        <div class="flex justify-end space-x-3">
                            <button type="button" @click="closeModal" class="text-zinc-400 hover:text-white px-4 py-2">
                                Cancelar
                            </button>
                            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                Guardar Cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </template>
</div>

<script>
    function confirmDelete(id) {
        Swal.fire({
            title: '¿Eliminar egreso?',
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
            customClass: { popup: 'rounded-lg shadow-lg' }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }

    function egresoTable() {
        return {
            isOpen: false,
            currentId: null,
            fecha: '',
            monto: '',
            tipo_egreso: '',
            descripcion: '',

            openModal(id, tipo, descripcion, fecha, monto) {
                this.currentId = id;
                this.tipo_egreso = tipo;
                this.descripcion = descripcion;
                this.fecha = fecha;
                this.monto = monto;
                this.isOpen = true;
                document.body.classList.add('overflow-hidden');
            },

            closeModal() {
                this.isOpen = false;
                document.body.classList.remove('overflow-hidden');
            }
        }
    }
</script>
