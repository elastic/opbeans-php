<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DTInterceptor
{
    private const OPBEANS_DT_PROBABILITY_ENV_VAR_NAME = 'OPBEANS_DT_PROBABILITY';
    private const OPBEANS_DT_PROBABILITY_DEFAULT = 0.5;

    private const OPBEANS_SERVICES_ENV_VAR_NAME = 'OPBEANS_SERVICES';

    private bool $isEnabled = false;

    private float $probability;

    /** @var string[] */
    private array $services;

    public function __construct()
    {
        $buildForwardingWillDisabledMsg = function (string $reason): string {
            return $reason . ' - forwarding to other backend services will be disabled';
        };

        $serviceName = config('app.name');
        $probabilityEnvVarVal = env(self::OPBEANS_DT_PROBABILITY_ENV_VAR_NAME);
        if ($probabilityEnvVarVal === null) {
            Log::info(
                $buildForwardingWillDisabledMsg(
                    self::OPBEANS_DT_PROBABILITY_ENV_VAR_NAME . ' environment variable is not set'
                ),
                ['this' => $this->selfToLog()]
            );
            return;
        }

        if (filter_var($probabilityEnvVarVal, FILTER_VALIDATE_FLOAT) === false) {
            $probability = self::OPBEANS_DT_PROBABILITY_DEFAULT;
            Log::error(
                self::OPBEANS_DT_PROBABILITY_ENV_VAR_NAME . ' environment variable value'
                . ' (' . $probabilityEnvVarVal. ')'
                . ' is not a valid float - using default value (' . self::OPBEANS_DT_PROBABILITY_DEFAULT . ')'
            );
        } else {
            $probability = floatval($probabilityEnvVarVal);
        }

        $servicesEnvVarVal = env(self::OPBEANS_SERVICES_ENV_VAR_NAME);
        if ($servicesEnvVarVal === null) {
            Log::info(
                $buildForwardingWillDisabledMsg(
                    self::OPBEANS_SERVICES_ENV_VAR_NAME . ' environment variable is not set'
                ),
                ['this' => $this->selfToLog()]
            );
            return;
        }

        $services = self::parseServices($servicesEnvVarVal);
        if (empty($services)) {
            Log::error(
                $buildForwardingWillDisabledMsg(
                    self::OPBEANS_SERVICES_ENV_VAR_NAME . ' environment variable does not contain valid URLs'
                ),
                ['this' => $this->selfToLog()]
            );
            return;
        }

        $this->probability = $probability;
        $this->services = $services;
        $this->isEnabled = true;
        Log::info('Forwarding to other backend services is enabled', ['this' => $this->selfToLog()]);
    }

    /**
     * @return string[]
     */
    private static function parseServices(string $envVarVal): array
    {
        $result = [];
        $envVarValAsList = explode(',', $envVarVal);
        foreach ($envVarValAsList as $urlPrefix){
            $urlPrefix = trim($urlPrefix);
            if (empty($urlPrefix)) {
                continue;
            }
            if (str_ends_with($urlPrefix, '/')) {
                $urlPrefix = substr($urlPrefix, 0, -1);
            }

            $result[] = $urlPrefix;
        }

        return $result;
    }

    /**
     * @return array<string, mixed>
     */
    private function selfToLog(): array
    {
        return get_object_vars($this);
    }

    private function randomDecideIfToForward(): bool
    {
        return (mt_rand() / mt_getrandmax()) <= $this->probability;
    }

    private function buildForwardUrl(string $service, string $requestPath): string
    {
        return str_starts_with($requestPath, '/') ? ($service . $requestPath) : ($service . '/' . $requestPath);
    }

    private function randomForwardToService(Request $request): bool
    {
        if (!$this->randomDecideIfToForward()) {
            Log::info('Decided not to forward', ['this' => $this->selfToLog()]);
            return false;
        }

        $serviceIndex = array_rand($this->services);
        $forwardUrl = $this->buildForwardUrl($this->services[$serviceIndex], $request->path());
        Log::info('Decided to forward', ['forwardUrl' => $forwardUrl, 'this' => $this->selfToLog()]);

        $response = Http::get( $forwardUrl)->json();
        abort(response()->json($response));
    }

    public function handle(Request $request, Closure $next)
    {
        if ($this->isEnabled && $this->randomForwardToService($request)) {
            // this return is not reachable
            return null;
        }

        return $next($request);
    }
}
