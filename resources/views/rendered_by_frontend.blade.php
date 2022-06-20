<script>
    window.rumConfig = {
        serviceName: "{{ env('ELASTIC_APM_JS_SERVICE_NAME') }}",
        serviceVersion: "{{ env('ELASTIC_APM_JS_SERVICE_VERSION') }}",
        serverUrl: "{{ env('ELASTIC_APM_JS_SERVER_URL') }}",
        pageLoadTraceId: "{{ $apmCurrentTransaction->getTraceId() }}",
        pageLoadSpanId: "{{ $apmCurrentTransaction->ensureParentId() }}",
        pageLoadSampled: {{ $apmCurrentTransaction->isSampled() ? "true" : "false" }}
    }
</script>
@extends('index')
