<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/alpinejs" defer></script>
</head>

<div class="w-full py-8 px-4 sm:px-6 lg:px-8" x-data="customerTable()">
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
            <h1 class="text-2xl font-bold text-white">Lista de Clientes</h1>
            <div class="space-x-2">
                <a href="{{ route('admin.cliente.export-pdf') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Exportar PDF</a>
                <a href="{{ route('admin.cliente.export-excel') }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">Exportar Excel</a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-zinc-800">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-300 uppercase">#</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-300 uppercase">Tipo de Documento</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-300 uppercase">Número de Documento</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-300 uppercase">Nombres</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-300 uppercase">Apellidos</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-300 uppercase">Teléfono</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-300 uppercase">Dirección</th>
                        <th class="px-4 py-3 text-right text-sm font-medium text-zinc-300 uppercase">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-800">
                    @foreach ($clientes as $cliente)
                        <tr>
                            <td class="px-4 py-4 text-sm text-zinc-300">{{ $loop->iteration }}</td>
                            <td class="px-4 py-4 text-sm text-zinc-300">{{ $cliente->tipo_documento }}</td>
                            <td class="px-4 py-4 text-sm text-zinc-300">{{ $cliente->numero_documento }}</td>
                            <td class="px-4 py-4 text-sm text-zinc-300">{{ Str::limit($cliente->nombres, 30) }}</td>
                            <td class="px-4 py-4 text-sm text-zinc-300">{{ Str::limit($cliente->apellidos, 30) }}</td>
                            <td class="px-4 py-4 text-sm text-zinc-300">{{ $cliente->telefono }}</td>
                            <td class="px-4 py-4 text-sm text-zinc-300">{{ Str::limit($cliente->direccion, 40) }}</td>
                            <td class="px-4 py-4 text-sm text-right">
                                <!-- Botón Editar -->
                                <button
                                    @click="openModal({{ $cliente->id }}, '{{ addslashes($cliente->tipo_documento) }}', '{{ addslashes($cliente->numero_documento) }}', '{{ addslashes($cliente->nombres) }}', '{{ addslashes($cliente->apellidos) }}', '{{ addslashes($cliente->telefono) }}', '{{ addslashes($cliente->direccion) }}', {{ isset($cliente->status) ? $cliente->status : 1 }})"
                                    class="text-blue-500 hover:text-blue-400 mr-3">
                                    <!-- ícono editar -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                    </svg>
                                </button>

                                <!-- Botón Eliminar -->
                                <button onclick="confirmDelete({{ $cliente->id }})" class="text-red-500 hover:text-red-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </button>

                                <!-- Formulario Eliminar -->
                                <form id="delete-form-{{ $cliente->id }}" action="{{ route('admin.cliente.destroy', $cliente->id) }}" method="POST" class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if ($clientes->hasPages())
            <div class="mt-6">
                {{ $clientes->links() }}
            </div>
        @endif
    </div>

    <!-- Modal -->
    <template x-teleport="body">
        <div x-show="isOpen" x-cloak x-transition:enter="ease-out duration-300" x-transition:leave="ease-in duration-200"
            class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-black opacity-75" @click="closeModal"></div>

                <div class="inline-block bg-zinc-900 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full border border-zinc-800">
                    <form :action="'/admin/cliente/' + currentId" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="px-8 py-8">
                            <h3 class="text-xl font-semibold text-white mb-6">Editar Cliente</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Tipo Documento -->
                                <div>
                                    <label class="block text-sm font-medium text-zinc-300 mb-2">Tipo de Documento</label>
                                    <select x-model="currentTipoDocumento" name="tipo_documento" class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg text-white" required>
                                        <option value="DNI">DNI</option>
                                        <option value="CE">Carné de Extranjería</option>
                                    </select>
                                </div>
                                <!-- Número Documento -->
                                <div>
                                    <label class="block text-sm font-medium text-zinc-300 mb-2">Número de Documento</label>
                                    <input type="text" x-model="currentNumeroDocumento" name="numero_documento" class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg text-white" required maxlength="8" pattern="\d{8}" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                </div>
                                <!-- Nombres -->
                                <div>
                                    <label class="block text-sm font-medium text-zinc-300 mb-2">Nombres</label>
                                    <input type="text" x-model="currentNombres" name="nombres" class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg text-white" required maxlength="100">
                                </div>
                                <!-- Apellidos -->
                                <div>
                                    <label class="block text-sm font-medium text-zinc-300 mb-2">Apellidos</label>
                                    <input type="text" x-model="currentApellidos" name="apellidos" class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg text-white" required maxlength="100">
                                </div>
                                <!-- Teléfono -->
                                <div>
                                    <label class="block text-sm font-medium text-zinc-300 mb-2">Teléfono</label>
                                    <input type="text" x-model="currentTelefono" name="telefono" class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg text-white" required maxlength="15" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                </div>
                                <!-- Dirección -->
                                <div>
                                    <label class="block text-sm font-medium text-zinc-300 mb-2">Dirección</label>
                                    <input type="text" x-model="currentDireccion" name="direccion" class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg text-white" required maxlength="200">
                                </div>
                                <!-- Estado -->
                                <input type="hidden" x-model="currentStatus" name="status">
                            </div>
                        </div>

                        <div class="px-8 py-4 bg-zinc-800 flex justify-end space-x-4">
                            <button type="button" @click="closeModal" class="px-6 py-3 text-zinc-300 hover:text-white">Cancelar</button>
                            <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Guardar Cambios</button>
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
            title: '¿Eliminar cliente?',
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

    function customerTable() {
        return {
            isOpen: false,
            currentId: null,
            currentTipoDocumento: '',
            currentNumeroDocumento: '',
            currentNombres: '',
            currentApellidos: '',
            currentTelefono: '',
            currentDireccion: '',
            currentStatus: 1,

            openModal(id, tipo_documento, numero_documento, nombres, apellidos, telefono, direccion, status) {
                this.currentId = id;
                this.currentTipoDocumento = tipo_documento;
                this.currentNumeroDocumento = numero_documento;
                this.currentNombres = nombres;
                this.currentApellidos = apellidos;
                this.currentTelefono = telefono;
                this.currentDireccion = direccion;
                this.currentStatus = status;
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
