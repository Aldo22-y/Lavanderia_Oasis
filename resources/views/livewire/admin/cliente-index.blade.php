<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
        <h1 class="text-2xl font-bold text-white mb-6" data-flux-component="heading">
            Registrar Nuevo Cliente
        </h1>
        <form action="{{ route('admin.cliente.store') }}" method="POST" class="space-y-6" data-flux-component="form">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Tipo de Documento -->
                <div data-flux-field>
                    <label for="tipo_documento" class="block text-sm font-medium text-zinc-300 mb-1">
                        Tipo de Documento <span class="text-red-500">*</span>
                    </label>
                    <select id="tipo_documento" name="tipo_documento"
                        class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg text-white" required>
                        <option value="DNI">DNI</option>
                        <option value="CE">Carné de Extranjería</option>
                    </select>
                    @error('tipo_documento')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Número de Documento -->
                <div data-flux-field>
                    <label for="numero_documento" class="block text-sm font-medium text-zinc-300 mb-1">
                        Número de Documento <span class="text-red-500">*</span>
                    </label>
                    <div class="flex gap-2">
                        <input type="text" id="numero_documento" name="numero_documento"
                            class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg text-white"
                            placeholder="Ej: 12345678" required maxlength="8"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                        <button type="button" id="consultar-dni"
                            class="px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z" />
                            </svg>
                        </button>
                    </div>
                    @error('numero_documento')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nombres -->
                <div data-flux-field>
                    <label for="nombres" class="block text-sm font-medium text-zinc-300 mb-1">
                        Nombres <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="nombres" name="nombres"
                        class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg text-white"
                        placeholder="Ej: Juan Carlos" required maxlength="100">
                    @error('nombres')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Apellidos -->
                <div data-flux-field>
                    <label for="apellidos" class="block text-sm font-medium text-zinc-300 mb-1">
                        Apellidos <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="apellidos" name="apellidos"
                        class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg text-white"
                        placeholder="Ej: Pérez Gómez" required maxlength="100">
                    @error('apellidos')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Teléfono -->
                <div data-flux-field>
                    <label for="telefono" class="block text-sm font-medium text-zinc-300 mb-1">
                        Teléfono
                    </label>
                    <input type="text" id="telefono" name="telefono"
                        class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg text-white"
                        placeholder="Ej: 987654321" maxlength="20">
                    @error('telefono')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Dirección -->
                <div data-flux-field>
                    <label for="direccion" class="block text-sm font-medium text-zinc-300 mb-1">
                        Dirección
                    </label>
                    <input type="text" id="direccion" name="direccion"
                        class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg text-white"
                        placeholder="Ej: Av. Los Álamos 123, Cusco" maxlength="255">
                    @error('direccion')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Campos ocultos -->
                <input type="hidden" id="tipo_documento_api" name="tipo_documento_api">
                <input type="hidden" id="digito_verificador" name="digito_verificador">
            </div>

            <div class="relative my-8">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-zinc-800"></div>
                </div>
            </div>

            <div class="text-sm text-zinc-500 mb-6">
                Campos marcados con <span class="text-red-500 font-bold">*</span> son obligatorios
            </div>

            <div class="flex justify-end">
                <button type="submit"
                    class="px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 shadow-lg hover:shadow-xl">
                    Registrar Cliente
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#consultar-dni').on('click', function () {
            const dni = $('#numero_documento').val();
            const tipoDocumento = $('#tipo_documento').val();
            if (!dni.match(/^\d{8}$/)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'El número de documento debe tener 8 dígitos',
                    background: '#18181b',
                    color: '#f4f4f5',
                    iconColor: '#ef4444',
                    confirmButtonColor: '#3b82f6'
                });
                return;
            }

            $.ajax({
                url: '{{ route('admin.cliente.consultar-dni') }}',
                method: 'GET',
                data: { dni, tipo_documento: tipoDocumento },
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                success: function (data) {
                    if (!data.error) {
                        $('#nombres').val(data.nombres || '');
                        $('#apellidos').val(data.apellidos || '');
                        $('#tipo_documento_api').val(data.tipo_documento_api || '');
                        $('#digito_verificador').val(data.digito_verificador || '');
                        Swal.fire({
                            icon: 'success',
                            title: '¡Éxito!',
                            text: 'Datos del documento obtenidos correctamente',
                            background: '#18181b',
                            color: '#f4f4f5',
                            iconColor: '#22c55e',
                            confirmButtonColor: '#3b82f6'
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.error,
                            background: '#18181b',
                            color: '#f4f4f5',
                            iconColor: '#ef4444',
                            confirmButtonColor: '#3b82f6'
                        });
                    }
                },
                error: function (xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error al consultar el documento: ' + (xhr.responseJSON?.error || 'Error desconocido'),
                        background: '#18181b',
                        color: '#f4f4f5',
                        iconColor: '#ef4444',
                        confirmButtonColor: '#3b82f6'
                    });
                }
            });
        });
    });
</script>
