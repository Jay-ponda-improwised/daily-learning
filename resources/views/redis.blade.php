<!DOCTYPE html>
<html lang="en">

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <style>
        body {
            margin: 0 auto;
            width: calc(100% - 300px);
        }

        tr,
        td,
        th,
        table {
            border: 1px solid black;
        }

        table {
            margin: 5px;
            text-align: center;
            width: 100%;
        }

        </style>
        <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body style="padding: 5px">
    <h1>Redis test</h1>
    <form onsubmit="addNewKey(event)">
        @csrf
        <label>Id:
            <input type="text" name="id" id="id" />
        </label>
        <label>Key:
            <input type="text" name="key" id="key" />
        </label>
        <label>Value:
            <input type="text" name="value" id="value" />
        </label>
        <button type="submit" id="submit">Submit</button>
    </form>

    <table>
        <tr>
            <th>index</th>
            <th>Key</th>
            <th>Value</th>
        </tr>
        @foreach ($redis as $key => $value)
            <tr>
                <td>{{ $loop->index + 1 }}</td>
                <td>{{ $key }}</td>
                <td>{{ $value }}</td>
            </tr>
        @endforeach
    </table>
    <script src="{{ asset('js/redis_demo.js') }}" defer></script>
</body>

</html>
