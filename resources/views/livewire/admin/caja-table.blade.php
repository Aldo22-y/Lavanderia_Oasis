<div class="w-full py-8 px-4 sm:px-6 lg:px-8" x-data="cajaTable()">
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
            <h1 class="text-2xl font-bold text-white">Lista de Cajas</h1>
            <div class="flex space-x-4">
                <a href="{{ route('admin.caja.export-pdf') }}" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                    Exportar PDF
                </a>
                <a href="{{ route('admin.caja.export-excel') }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                    Exportar Excel
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-zinc-800">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-300 uppercase">#</th>
                        <th class="px-4 py-3 text-left text-sm text-zinc-300">Apertura</th>
                        <th class="px-4 py-3 text-left text-sm text-zinc-300">Cierre</th>
                        <th class="px-4 py-3 text-left text-sm text-zinc-300">Ingresos</th>
                        <th class="px-4 py-3 text-left text-sm text-zinc-300">Egresos</th>
                        <th class="px-4 py-3 text-left text-sm text-zinc-300">Saldo Final</th>
                        <th class="px-4 py-3 text-right text-sm text-zinc-300">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-800">
                    @foreach ($cajas as $caja)
                        <tr>
                            <td class="px-4 py-4 text-sm text-zinc-300">{{ $loop->iteration }}</td>
                            <td class="px-4 py-4 text-sm text-zinc-300">{{ $caja->fecha_apertura }}</td>
                            <td class="px-4 py-4 text-sm text-zinc-300">{{ $caja->fecha_cierre ?? '—' }}</td>
                            <td class="px-4 py-4 text-sm text-zinc-300">S/ {{ number_format($caja->total_ingresos, 2) }}</td>
                            <td class="px-4 py-4 text-sm text-zinc-300">S/ {{ number_format($caja->total_egresos, 2) }}</td>
                            <td class="px-4 py-4 text-sm text-zinc-300 font-semibold">S/ {{ number_format($caja->saldo_final, 2) }}</td>
                            <td class="px-4 py-4 text-sm text-right">
                                <button @click="openModal({{ $caja->id }}, '{{ $caja->fecha_apertura }}', '{{ $caja->fecha_cierre }}', {{ $caja->total_ingresos }}, {{ $caja->total_egresos }}, {{ $caja->saldo_final }})"
                                    class="text-blue-500 hover:text-blue-400 mr-3">✎</button>

                                <button onclick="confirmDelete({{ $caja->id }})" class="text-red-500 hover:text-red-400">🗑️</button>

                                <form id="delete-form-{{ $caja->id }}" action="{{ route('admin.caja.destroy', $caja->id) }}" method="POST" class="hidden">
                                    @csrf @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if ($cajas->hasPages())
            <div class="mt-6">
                {{ $cajas->links() }}
            </div>
        @endif
    </div>

    <!-- Modal Edición -->
    <template x-teleport="body">
        <div x-show="isOpen" x-cloak x-transition class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen px-4 py-12">
                <div class="fixed inset-0 bg-black opacity-75" @click="closeModal"></div>

                <div class="relative bg-zinc-900 rounded-lg w-full max-w-md p-8 shadow-xl border border-zinc-800 z-50">
                    <h3 class="text-xl font-bold text-white mb-6">Editar Caja</h3>

                    <form :action="'/admin/caja/' + currentId" method="POST">
                        @csrf @method('PUT')

                        <div class="mb-4">
                            <label class="block text-sm text-zinc-300 mb-1">Fecha Apertura</label>
                            <input type="datetime-local" x-model="currentApertura" name="fecha_apertura" class="w-full bg-zinc-800 text-white rounded px-3 py-2" required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm text-zinc-300 mb-1">Fecha Cierre</label>
                            <input type="datetime-local" x-model="currentCierre" name="fecha_cierre" class="w-full bg-zinc-800 text-white rounded px-3 py-2">
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm text-zinc-300 mb-1">Total Ingresos</label>
                            <input type="number" step="0.01" x-model="currentIngresos" name="total_ingresos" class="w-full bg-zinc-800 text-white rounded px-3 py-2" required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm text-zinc-300 mb-1">Total Egresos</label>
                            <input type="number" step="0.01" x-model="currentEgresos" name="total_egresos" class="w-full bg-zinc-800 text-white rounded px-3 py-2" required>
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm text-zinc-300 mb-1">Saldo Final</label>
                            <input type="number" step="0.01" x-model="currentSaldo" name="saldo_final" class="w-full bg-zinc-800 text-white rounded px-3 py-2" required>
                        </div>

                        <div class="flex justify-end space-x-3">
                            <button type="button" @click="closeModal" class="text-zinc-400 hover:text-white px-4 py-2">Cancelar</button>
                            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Guardar Cambios</button>
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
            title: '¿Eliminar caja?',
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

    function cajaTable() {
        return {
            isOpen: false,
            currentId: null,
            currentApertura: '',
            currentCierre: '',
            currentIngresos: 0,
            currentEgresos: 0,
            currentSaldo: 0,

            openModal(id, apertura, cierre, ingresos, egresos, saldo) {
                this.currentId = id;
                this.currentApertura = apertura;
                this.currentCierre = cierre;
                this.currentIngresos = ingresos;
                this.currentEgresos = egresos;
                this.currentSaldo = saldo;
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
