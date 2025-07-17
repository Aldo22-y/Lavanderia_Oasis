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
            setTimeout(() => { Swal.close(); }, 3000);
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
        <h1 class="text-2xl font-bold text-white mb-6">Registrar Cierre de Caja</h1>
        <form action="{{ route('admin.cierrecaja.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- ID Caja -->
            <div>
                <label for="id_caja" class="block text-sm font-medium text-zinc-300 mb-1">
                    ID Caja <span class="text-red-500">*</span>
                </label>
                <input type="text" id="id_caja" name="id_caja" required
                    class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg text-white"
                    placeholder="Ej. 1234">
                @error('id_caja')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Fecha -->
            <div>
                <label for="fecha" class="block text-sm font-medium text-zinc-300 mb-1">
                    Fecha <span class="text-red-500">*</span>
                </label>
                <input type="date" id="fecha" name="fecha" required
                    class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg text-white">
                @error('fecha')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Observaciones -->
            <div>
                <label for="observaciones" class="block text-sm font-medium text-zinc-300 mb-1">
                    Observaciones
                </label>
                <textarea id="observaciones" name="observaciones" rows="4"
                    class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg text-white"
                    placeholder="Ingrese alguna observación (opcional)"></textarea>
                @error('observaciones')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="text-sm text-zinc-500 mb-6">
                Campos marcados con <span class="text-red-500 font-bold">*</span> son obligatorios
            </div>

            <div class="flex justify-end">
                <button type="submit"
                    class="px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-all">
                    Registrar Cierre
                </button>
            </div>
        </form>
    </div>
</div>
