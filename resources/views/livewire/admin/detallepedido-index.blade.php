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
        <h1 class="text-2xl font-bold text-white mb-6">Registrar Detalle de Pedido</h1>

        <form action="{{ route('admin.detallepedido.store') }}" method="POST" class="space-y-6">
            @csrf

            {{-- Pedido --}}
            <div>
                <label for="id_pedido" class="block text-sm font-medium text-zinc-300 mb-1">Pedido <span class="text-red-500">*</span></label>
                <select name="id_pedido" id="id_pedido" required
                    class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg text-white focus:ring-2 focus:ring-blue-500">
                    <option value="">Seleccione un pedido</option>
                    @foreach ($pedidos as $pedido)
                        <option value="{{ $pedido->id }}">{{ $pedido->id }} - {{ $pedido->fecha_ingreso }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Tipo de Lavado --}}
            <div>
                <label for="id_tipolavado" class="block text-sm font-medium text-zinc-300 mb-1">Tipo de Lavado <span class="text-red-500">*</span></label>
                <select name="id_tipolavado" id="id_tipolavado" required
                    class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg text-white focus:ring-2 focus:ring-blue-500">
                    <option value="">Seleccione</option>
                    @foreach ($tipolavados as $lavado)
                        <option value="{{ $lavado->id }}">{{ $lavado->nombre }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Tipo de Ropa --}}
            <div>
                <label for="id_tiporopa" class="block text-sm font-medium text-zinc-300 mb-1">Tipo de Ropa <span class="text-red-500">*</span></label>
                <select name="id_tiporopa" id="id_tiporopa" required
                    class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg text-white focus:ring-2 focus:ring-blue-500">
                    <option value="">Seleccione</option>
                    @foreach ($tiporopas as $ropa)
                        <option value="{{ $ropa->id }}">{{ $ropa->nombre }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Cantidad --}}
            <div>
                <label for="cantidad" class="block text-sm font-medium text-zinc-300 mb-1">Cantidad <span class="text-red-500">*</span></label>
                <input type="number" name="cantidad" id="cantidad" min="1" required
                    class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg text-white focus:ring-2 focus:ring-blue-500"
                    placeholder="Ej: 5">
            </div>

            {{-- Subtotal --}}
            <div>
                <label for="subtotal" class="block text-sm font-medium text-zinc-300 mb-1">Subtotal (S/.) <span class="text-red-500">*</span></label>
                <input type="number" step="0.01" name="subtotal" id="subtotal" required
                    class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg text-white focus:ring-2 focus:ring-blue-500"
                    placeholder="Ej: 25.50">
            </div>

            <div class="text-sm text-zinc-500 mb-6">
                Campos marcados con <span class="text-red-500 font-bold">*</span> son obligatorios
            </div>

            <div class="flex justify-end">
                <button type="submit"
                    class="px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200 shadow-lg hover:shadow-xl">
                    Registrar Detalle
                </button>
            </div>
        </form>
    </div>
</div>
