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
        <h1 class="text-2xl font-bold text-white mb-6">
            Registrar Egreso
        </h1>
        <form action="{{ route('admin.egreso.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Fecha -->
            <div>
                <label for="fecha" class="block text-sm font-medium text-zinc-300 mb-1">
                    Fecha <span class="text-red-500">*</span>
                </label>
                <input type="date" id="fecha" name="fecha" required
                    class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg text-white">
                @error('fecha')
                    <p class="mt-1 text-sm text-red-500 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Monto -->
            <div>
                <label for="monto" class="block text-sm font-medium text-zinc-300 mb-1">
                    Monto (S/.) <span class="text-red-500">*</span>
                </label>
                <input type="number" step="0.01" id="monto" name="monto" required
                    class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg text-white">
                @error('monto')
                    <p class="mt-1 text-sm text-red-500 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tipo de egreso -->
            <div>
                <label for="tipo_egreso" class="block text-sm font-medium text-zinc-300 mb-1">
                    Tipo de Egreso <span class="text-red-500">*</span>
                </label>
                <input type="text" id="tipo_egreso" name="tipo_egreso" required
                    class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg text-white"
                    placeholder="Ej: Compra de insumos, Servicios, Reparaciones">
                @error('tipo_egreso')
                    <p class="mt-1 text-sm text-red-500 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Descripción -->
            <div>
                <label for="descripcion" class="block text-sm font-medium text-zinc-300 mb-1">
                    Descripción
                </label>
                <textarea id="descripcion" name="descripcion" rows="3"
                    class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg text-white placeholder-zinc-500"
                    placeholder="Ej: Pago a proveedor, repuesto de máquina, etc."></textarea>
                @error('descripcion')
                    <p class="mt-1 text-sm text-red-500 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Separador -->
            <div class="relative my-8">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-zinc-800"></div>
                </div>
            </div>

            <!-- Nota -->
            <div class="text-sm text-zinc-500 mb-6">
                Campos marcados con <span class="text-red-500 font-bold">*</span> son obligatorios
            </div>

            <!-- Botón -->
            <div class="flex justify-end">
                <button type="submit"
                    class="px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-zinc-900 transition-all duration-200 shadow-lg hover:shadow-xl">
                    Registrar Egreso
                </button>
            </div>
        </form>
    </div>
</div>
