<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<div class="w-full py-8 px-4 sm:px-6 lg:px-8">
    {{-- Alerta de Éxito --}}
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

    {{-- Alerta de Errores --}}
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
            Registrar Nueva Caja
        </h1>

        <form action="{{ route('admin.caja.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Fecha de Apertura -->
            <div>
                <label for="fecha_apertura" class="block text-sm font-medium text-zinc-300 mb-1">
                    Fecha de Apertura <span class="text-red-500">*</span>
                </label>
                <input type="datetime-local" id="fecha_apertura" name="fecha_apertura"
                    class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg text-white"
                    required>
                @error('fecha_apertura')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Fecha de Cierre -->
            <div>
                <label for="fecha_cierre" class="block text-sm font-medium text-zinc-300 mb-1">
                    Fecha de Cierre
                </label>
                <input type="datetime-local" id="fecha_cierre" name="fecha_cierre"
                    class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg text-white">
                @error('fecha_cierre')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Total Ingresos -->
            <div>
                <label for="total_ingresos" class="block text-sm font-medium text-zinc-300 mb-1">
                    Total Ingresos <span class="text-red-500">*</span>
                </label>
                <input type="number" step="0.01" min="0" id="total_ingresos" name="total_ingresos"
                    class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg text-white"
                    required>
                @error('total_ingresos')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Total Egresos -->
            <div>
                <label for="total_egresos" class="block text-sm font-medium text-zinc-300 mb-1">
                    Total Egresos <span class="text-red-500">*</span>
                </label>
                <input type="number" step="0.01" min="0" id="total_egresos" name="total_egresos"
                    class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg text-white"
                    required>
                @error('total_egresos')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Saldo Final -->
            <div>
                <label for="saldo_final" class="block text-sm font-medium text-zinc-300 mb-1">
                    Saldo Final <span class="text-red-500">*</span>
                </label>
                <input type="number" step="0.01" min="0" id="saldo_final" name="saldo_final"
                    class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg text-white"
                    required>
                @error('saldo_final')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Línea divisora -->
            <div class="relative my-8">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-zinc-800"></div>
                </div>
            </div>

            <!-- Nota -->
            <div class="text-sm text-zinc-500 mb-6">
                Todos los campos con <span class="text-red-500 font-bold">*</span> son obligatorios
            </div>

            <!-- Botón -->
            <div class="flex justify-end">
                <button type="submit"
                    class="px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 shadow-lg">
                    Registrar Caja
                </button>
            </div>
        </form>
    </div>
</div>
