<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Cajas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 10mm;
            color: #333;
        }
        .header {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 10px;
        }
        .logo img {
            max-width: 200px;
            height: auto;
        }
        h1 {
            text-align: left;
            color: #1a73e8;
            font-size: 20px;
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }
        th, td {
            border: 1px solid #999;
            padding: 6px;
            text-align: left;
        }
        th {
            background-color: #e0e0e0;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f5f5f5;
        }
        .footer {
            text-align: left;
            margin-top: 15px;
            font-size: 10px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">
            <img src="{{ public_path('image/logo_Lavanderia.jpg') }}" alt="Logo">
        </div>
    </div>

    <h1>Reporte de Cajas</h1>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Fecha Apertura</th>
                <th>Fecha Cierre</th>
                <th>Total Ingresos</th>
                <th>Total Egresos</th>
                <th>Saldo Final</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cajas as $index => $caja)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $caja->fecha_apertura }}</td>
                    <td>{{ $caja->fecha_cierre ?? '—' }}</td>
                    <td>S/ {{ number_format($caja->total_ingresos, 2) }}</td>
                    <td>S/ {{ number_format($caja->total_egresos, 2) }}</td>
                    <td><strong>S/ {{ number_format($caja->saldo_final, 2) }}</strong></td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Generado el {{ now()->format('d/m/Y H:i') }} | Sistema de Gestión Lavandería Oasis
    </div>
</body>
</html>
