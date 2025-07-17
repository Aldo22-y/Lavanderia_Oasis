<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<div class="w-full py-8 px-4 sm:px-6 lg:px-8">
    {{-- Alerta de éxito --}}
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

    {{-- Alerta de errores --}}
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
        <h1 class="text-2xl font-bold text-white mb-6">Registrar Nuevo Ingreso</h1>
        <form action="{{ route('admin.ingreso.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Pedido -->
            <div>
                <label for="id_pedido" class="block text-sm font-medium text-zinc-300 mb-1">
                    Pedido <span class="text-red-500">*</span>
                </label>
                <select id="id_pedido" name="id_pedido" required
                    class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg text-white">
                    <option value="" disabled selected>Seleccione un pedido</option>
                    @foreach ($pedidos as $pedido)
                        <option value="{{ $pedido->id }}">#{{ $pedido->id }} - {{ $pedido->cliente->nombres ?? 'Cliente desconocido' }}</option>
                    @endforeach
                </select>
                @error('id_pedido')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Fecha -->
            <div>
                <label for="fecha" class="block text-sm font-medium text-zinc-300 mb-1">Fecha <span class="text-red-500">*</span></label>
                <input type="date" id="fecha" name="fecha" required
                    class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg text-white">
                @error('fecha')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Monto -->
            <div>
                <label for="monto" class="block text-sm font-medium text-zinc-300 mb-1">Monto (S/.) <span class="text-red-500">*</span></label>
                <input type="number" id="monto" name="monto" step="0.01" min="0" required
                    class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg text-white">
                @error('monto')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Descripción -->
            <div>
                <label for="descripcion" class="block text-sm font-medium text-zinc-300 mb-1">Descripción</label>
                <textarea id="descripcion" name="descripcion" rows="3"
                    class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg text-white resize-none"></textarea>
                @error('descripcion')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="text-sm text-zinc-500 mb-6">
                Campos marcados con <span class="text-red-500 font-bold">*</span> son obligatorios
            </div>

            <div class="flex justify-end">
                <button type="submit"
                    class="px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-all">
                    Registrar Ingreso
                </button>
            </div>
        </form>
    </div>
</div>
