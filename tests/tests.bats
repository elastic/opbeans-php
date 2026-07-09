#!/usr/bin/env bats

load 'test_helper/bats-support/load'
load 'test_helper/bats-assert/load'
load test_helpers

IMAGE="bats-opbeans"
OPBEANS_PHP_CONTAINER_NAME="opbeans-php"
DOCKER_COMPOSE_CMD_PREFIX="docker compose"

setup() {
    cd "$BATS_TEST_DIRNAME/.."
}

teardown() {
    ${DOCKER_COMPOSE_CMD_PREFIX} down -v --remove-orphans || true
}

testImpl() {
    local docker_compose_options="$1"
    if [ -n "${docker_compose_options}" ]; then
        DOCKER_COMPOSE_CMD_PREFIX="docker compose ${docker_compose_options}"
    else
        DOCKER_COMPOSE_CMD_PREFIX="docker compose"
    fi

    run ${DOCKER_COMPOSE_CMD_PREFIX} build
    assert_success

    run ${DOCKER_COMPOSE_CMD_PREFIX} up -d
    assert_success

    run docker inspect -f {{.State.Running}} ${OPBEANS_PHP_CONTAINER_NAME}
    assert_output --partial 'true'

    sleep 50
    run curl -v --fail --connect-timeout 10 --max-time 30 "http://127.0.0.1:${PORT}/"
    assert_success
    assert_output --partial 'HTTP/1.1 200'
}

@test "Test with defaults" {
    testImpl
}

@test "Test with separate containers for frontend and backend" {
    testImpl "-f docker-compose_two_containers.yml"
}

@test "Test with PostgreSQL as DB" {
    testImpl "--env-file docker-compose_env_for_PostgreSQL.txt -f docker-compose_PostgreSQL.yml -f docker-compose.yml"
}

@test "Test with PostgreSQL as DB with separate containers for frontend and backend" {
    testImpl "--env-file docker-compose_env_for_PostgreSQL.txt -f docker-compose_PostgreSQL.yml -f docker-compose_two_containers.yml"
}

@test "Test with backend distributed tracing" {
    testImpl "--env-file docker-compose_env_for_backend_distributed_tracing.txt -f docker-compose.yml -f docker-compose_backend_distributed_tracing.yml"
}

@test "Test with backend distributed tracing with separate containers for frontend and backend" {
    testImpl "--env-file docker-compose_env_for_backend_distributed_tracing.txt -f docker-compose_two_containers.yml -f docker-compose_backend_distributed_tracing.yml"
}
