<div class="w-full py-8 px-4 sm:px-6 lg:px-8" x-data="detallePedidoTable()">

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

    {{-- Tabla --}}
    <div class="w-full bg-zinc-900 rounded-xl shadow-2xl p-6 border border-zinc-800">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-white">Detalle de Pedidos</h1>
            <div class="flex space-x-2">
                <button onclick="exportTableToExcel('detalleTabla')" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                    📄 Exportar Excel
                </button>
                <button onclick="exportTableToPDF()" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                    🧾 Exportar PDF
                </button>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table id="detalleTabla" class="w-full">
                <thead class="bg-zinc-800">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-300 uppercase">#</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-300 uppercase">Pedido</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-300 uppercase">Tipo Lavado</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-300 uppercase">Tipo Ropa</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-300 uppercase">Cantidad</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-300 uppercase">Subtotal</th>
                        <th class="px-4 py-3 text-right text-sm font-medium text-zinc-300 uppercase">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-800">
                    @foreach ($detallepedidos as $detalle)
                        <tr>
                            <td class="px-4 py-4 text-sm text-zinc-300">{{ $loop->iteration }}</td>
                            <td class="px-4 py-4 text-sm text-zinc-300">{{ $detalle->pedido->id ?? '-' }}</td>
                            <td class="px-4 py-4 text-sm text-zinc-300">{{ $detalle->tipoLavado->nombre ?? '-' }}</td>
                            <td class="px-4 py-4 text-sm text-zinc-300">{{ $detalle->tipoRopa->nombre ?? '-' }}</td>
                            <td class="px-4 py-4 text-sm text-zinc-300">{{ $detalle->cantidad }}</td>
                            <td class="px-4 py-4 text-sm text-zinc-300">S/ {{ number_format($detalle->subtotal, 2) }}</td>
                            <td class="px-4 py-4 text-sm text-right">
                                <button
                                    @click="openModal({{ $detalle->id }}, {{ $detalle->cantidad }}, {{ $detalle->subtotal }})"
                                    class="text-blue-500 hover:text-blue-400 mr-3">✏️</button>
                                <button onclick="confirmDelete({{ $detalle->id }})"
                                    class="text-red-500 hover:text-red-400">🗑️</button>
                                <form id="delete-form-{{ $detalle->id }}"
                                    action="{{ route('admin.detallepedido.destroy', $detalle->id) }}" method="POST"
                                    class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Modal --}}
    <template x-teleport="body">
        <div x-show="isOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen">
                <div class="absolute inset-0 bg-black opacity-70" @click="closeModal"></div>
                <div
                    class="bg-zinc-900 border border-zinc-800 rounded-lg p-6 w-full max-w-lg z-50 shadow-xl transition-all">
                    <form :action="'/admin/detallepedido/' + currentId" method="POST">
                        @csrf
                        @method('PUT')

                        <h2 class="text-xl font-semibold text-white mb-6">Editar Detalle</h2>

                        <div class="mb-4">
                            <label class="block text-sm text-zinc-300 mb-1">Cantidad</label>
                            <input type="number" name="cantidad" x-model="currentCantidad" min="1" required
                                class="w-full px-4 py-2 bg-zinc-800 border border-zinc-700 rounded-lg text-white">
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm text-zinc-300 mb-1">Subtotal</label>
                            <input type="number" name="subtotal" x-model="currentSubtotal" step="0.01" required
                                class="w-full px-4 py-2 bg-zinc-800 border border-zinc-700 rounded-lg text-white">
                        </div>

                        <div class="flex justify-end space-x-4">
                            <button type="button" @click="closeModal" class="text-zinc-300 hover:text-white">
                                Cancelar
                            </button>
                            <button type="submit"
                                class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                Guardar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </template>
</div>

{{-- Scripts --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.28/jspdf.plugin.autotable.min.js"></script>

<script>
    function confirmDelete(id) {
        Swal.fire({
            title: '¿Eliminar detalle?',
            text: "Esta acción no se puede deshacer",
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

    function detallePedidoTable() {
        return {
            isOpen: false,
            currentId: null,
            currentCantidad: null,
            currentSubtotal: null,

            openModal(id, cantidad, subtotal) {
                this.currentId = id;
                this.currentCantidad = cantidad;
                this.currentSubtotal = subtotal;
                this.isOpen = true;
                document.body.classList.add('overflow-hidden');
            },

            closeModal() {
                this.isOpen = false;
                document.body.classList.remove('overflow-hidden');
            }
        }
    }

    function exportTableToExcel(tableID) {
        const table = document.getElementById(tableID);
        const wb = XLSX.utils.table_to_book(table, { sheet: "DetallePedidos" });
        XLSX.writeFile(wb, 'detalle_pedidos.xlsx');
    }

    async function exportTableToPDF() {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();

        doc.autoTable({
            html: '#detalleTabla',
            theme: 'grid',
            headStyles: {
                fillColor: [24, 24, 27],
                textColor: [244, 244, 245],
            },
            bodyStyles: {
                textColor: [33, 33, 33]
            },
            styles: {
                fontSize: 9
            },
            margin: { top: 20 }
        });

        doc.save('detalle_pedidos.pdf');
    }
</script>
