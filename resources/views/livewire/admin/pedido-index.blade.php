<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<div class="w-full py-8 px-4 sm:px-6 lg:px-8">
    {{-- Alerta --}}
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
            setTimeout(() => { Swal.close(); }, 3000); // Cierra la alerta después de 3 segundos
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

    <div class="w-full bg-zinc-900 rounded-xl shadow-2xl overflow-hidden p-6 border border-zinc-800">
        <h1 class="text-2xl font-bold text-white mb-6">Registrar Nuevo Pedido</h1>
        <form action="{{ route('admin.pedido.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Cliente -->
            <div>
                <label for="id_cliente" class="block text-sm font-medium text-zinc-300 mb-1">
                    Cliente <span class="text-red-500">*</span>
                </label>
                <select id="id_cliente" name="id_cliente" required
                    class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg text-white">
                    <option value="" disabled selected>Seleccione un cliente</option>
                    @foreach ($clientes as $cliente)
                        <option value="{{ $cliente->id }}">{{ $cliente->nombres }} {{ $cliente->apellidos }}</option>
                    @endforeach
                </select>
                @error('id_cliente')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Fechas -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="fecha_ingreso" class="block text-sm font-medium text-zinc-300 mb-1">Fecha de Ingreso <span class="text-red-500">*</span></label>
                    <input type="date" id="fecha_ingreso" name="fecha_ingreso" required
                        class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg text-white">
                    @error('fecha_ingreso')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="fecha_entrega" class="block text-sm font-medium text-zinc-300 mb-1">Fecha de Entrega <span class="text-red-500">*</span></label>
                    <input type="date" id="fecha_entrega" name="fecha_entrega" required
                        class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg text-white">
                    @error('fecha_entrega')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Total -->
            <div>
                <label for="total" class="block text-sm font-medium text-zinc-300 mb-1">Total (S/.) <span class="text-red-500">*</span></label>
                <input type="number" id="total" name="total" step="0.01" min="0" required
                    class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg text-white" placeholder="0.00">
                @error('total')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Estado -->
            <div>
                <label for="status" class="block text-sm font-medium text-zinc-300 mb-1">Estado</label>
                <select id="status" name="status"
                    class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg text-white">
                    <option value="1" selected>Activo</option>
                    <option value="0">Inactivo</option>
                </select>
                @error('status')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="text-sm text-zinc-500 mb-6">
                Campos marcados con <span class="text-red-500 font-bold">*</span> son obligatorios
            </div>

            <div class="flex justify-end">
                <button type="submit"
                    class="px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-all">
                    Registrar Pedido
                </button>
            </div>
        </form>
    </div>
</div>
