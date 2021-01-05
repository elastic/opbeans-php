#!/usr/bin/env bash
set -euxo pipefail

AGENT_VERSION="${1?Missing the APM PHP agent version}"

## TBD: bump version



## Bump agent version in the Dockerfile
sed -ibck "s#\(org.label-schema.version=\)\(.*\)#\1\"${AGENT_VERSION}\"#g" Dockerfile

# Commit changes
git add Dockerfile
git commit -m "Bump version ${AGENT_VERSION}"
