<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mail demo</title>
    <style>
        :root {
            margin: 0 0;
            padding: 0 0;
            box-sizing: border-box;
        }

        body {
            margin: 0 0;
        }

        main {
            min-width: 100%;
            position: relative;
        }

        .header {
            width: calc(100% - 10px);
            height: 100px;
            background-color: #FF2D20;
            padding: 5px;
            background-image: linear-gradient(120deg, #74100b 10%, #873834 30%, #7d3f3f 50%, #83433f 70%, #5d3331 100%);
        }

        .header .main {
            color: antiquewhite;
        }

        .header .main-content {
            color: aliceblue;
        }

        .background {
            width: 100%;
            height: 100%;
            background-color: rgb(148, 163, 164);
            background-size: contain;
            background-position: center;
            background-repeat: repeat;
            box-sizing: border-box;
            background-size: 40% 40%;
            background-blend-mode: overlay;

            /* filter: invert(80%); */
            background-image: url({{ asset('images/bg.jpg') }});
            filter: saturate(300%);
        }

        .main-body {
            width: 100%;
            padding: 15px;
            box-sizing: border-box;

        }

        .main-body .main-content {
            width: fit-content;
            min-width: 500px;
            padding: 45px;
            text-align: center;
            color: cornsilk;
            background-color: rgba(99, 22, 22, 0.95);
            border-radius: 5px;
            border: 1px solid rgb(188, 97, 183);
        }

        .main-content .title {
            width: 100%;
            margin-bottom: 20px;
        }

        .main-content .content {
            text-align: justify;
        }

        .main-content table {
            margin: 15px 0px;
            padding: 5px;
            width: 100%;
            border: 2px solid #7d3f3f;
            background-color: #5d3331;
            border-collapse: collapse;
        }

        .main-content th,
        .main-content td {
            border: 1px solid #7d3f3f;
            padding: 5px;
            width: max-content;
        }

        .link {
            color: rgb(246, 122, 255);
        }
    </style>
</head>

<body class="background" style="background: url({{ asset('images/bg.jpg') }}); background-size: 40% 200%;">
    <main>
        <div class="content">

            <table width="100%" border="0" cellpadding="0" cellspacing="0" class="main-body">
                <tr>
                    <td align="center">
                        <div class="main-content">
                            <div class="title">
                                <h2>{{ $title }}</h2>
                            </div>
                            <div class="content">
                                <p>{{ $content }}</p>
                            </div>

                            <!-- render table if possible -->
                            @if (count($entries) > 0)
                            <table>
                                <thead>
                                    <tr>
                                        @foreach ($columns as $th)
                                        <th>{{ $th }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($entries as $entry => $value)
                                    <tr>
                                        @foreach ($columns as $index => $th)
                                        <td :class="{ 'link': $th === 'email' }" style="cursor: pointer;">{{ $value[$th] ?? '-- default --' }}</td>
                                        @endforeach
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @endif

                            <br />
                            @if (!empty($url))
                            <a class="link" href="{{ $url }}">Go to website</a>
                            @endif
                    </td>
                </tr>
            </table>
        </div>
    </main>

    @if ($send)
    <footer>
        <div class="footer">
            <button id="submit" onclick="sendEmail()">Send Email</button>
        </div>
        <script>
            async function sendEmail() {
                document.getElementById('submit').disabled = true;
                const response = await fetch(`/smtp/demo`, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                    }
                });
                alert("mail sent successfully");
                document.getElementById('submit').disabled = false;
            }
        </script>
    </footer>
    @endif
</body>

</html>
