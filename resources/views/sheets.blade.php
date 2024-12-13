<!DOCTYPE html>
<html>

<head>
    <title>座席表</title>
    <style>
        table {
            width: 50%;
            border-collapse: collapse;
            margin: 20px auto;
        }

        th,
        td {
            border: 1px solid #333;
            padding: 10px;
            text-align: center;
        }

        .screen {
            background-color: #ccc;
            text-align: center;
            padding: 10px;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <div class="screen">スクリーン</div>
    <table>
        @foreach($sheets as $row => $columns)
        <tr>
            @foreach($columns as $sheet)
            <td>{{ $sheet->row }}-{{ $sheet->column }}</td>
            @endforeach
        </tr>
        @endforeach
    </table>
</body>

</html>