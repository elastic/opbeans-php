@if ($isElasticApmEnabled)
    <script>
        window.rumConfig = {
            serviceName: "{{ $elasticApmJsServiceName }}",
            serviceVersion: "{{ $elasticApmJsServiceVersion }}",
            serverUrl: "{{ $elasticApmJsServerUrl }}",
            pageLoadTraceId: "{{ $elasticApmCurrentTransaction->getTraceId() }}",
            pageLoadSpanId: "{{ $elasticApmCurrentTransaction->ensureParentId() }}",
            pageLoadSampled: {{ $elasticApmCurrentTransaction->isSampled() ? "true" : "false" }}
        }
    </script>
@endif
@extends('page_from_frontend')
