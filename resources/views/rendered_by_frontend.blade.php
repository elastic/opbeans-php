<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>OpBeans</title>
        <script>
            window.rumConfig = {
                serviceName: 'Opbeans-JS',
                serverUrl: 'http://localhost:8200',
                pageLoadTraceId: "{{ Elastic\Apm\ElasticApm::getCurrentTransaction()->getTraceId() }}",
                pageLoadSpanId: "{{ Elastic\Apm\ElasticApm::getCurrentTransaction()->ensureParentId() }}",
                pageLoadSampled: {{ Elastic\Apm\ElasticApm::getCurrentTransaction()->isSampled() ? "true" : "false" }}
            }
        </script>
        <link href="{{ asset('static/css/main.7bd7c5e8.css') }}" rel="stylesheet">
        <link rel="shortcut icon" href="{{ asset('/favicon.ico') }}">
    </head>
    <body class="antialiased">
        <div id="root"></div>
        <script type="text/javascript" src="{{ asset('static/js/main.366d0241.js') }}"></script>
    </body>
</html>
