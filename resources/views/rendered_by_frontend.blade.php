<script>
    window.rumConfig = {
        serviceName: "{{ $elasticApmJsServiceName }}",
        serviceVersion: "{{ $elasticApmJsServiceVersion }}",
        serverUrl: "{{ $elasticApmJsServerUrl }}",
        pageLoadTraceId: "{{ $apmCurrentTransaction->getTraceId() }}",
        pageLoadSpanId: "{{ $apmCurrentTransaction->ensureParentId() }}",
        pageLoadSampled: {{ $apmCurrentTransaction->isSampled() ? "true" : "false" }}
    }
</script>
@extends('page_from_frontend')
