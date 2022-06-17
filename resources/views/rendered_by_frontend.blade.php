<script>
    window.rumConfig = {
        serviceName: 'Opbeans-JS',
        serverUrl: 'http://localhost:8200',
        pageLoadTraceId: "{{ $apmCurrentTransaction->getTraceId() }}",
        pageLoadSpanId: "{{ $apmCurrentTransaction->ensureParentId() }}",
        pageLoadSampled: {{ $apmCurrentTransaction->isSampled() ? "true" : "false" }}
    }
</script>
@extends('index')
