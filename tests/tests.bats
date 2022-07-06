#!/usr/bin/env bats

load 'test_helper/bats-support/load'
load 'test_helper/bats-assert/load'
load test_helpers

IMAGE="bats-opbeans"
OPBEANS_PHP_CONTAINER_NAME="opbeans-php"
OPBEANS_PHP_FRONTEND_CONTAINER_NAME="opbeans-php-frontend"

assertRunningWebServer() {
    local -r web_server_desc="$1"
    local -r web_server_url="$2"
    run echo "Assert that ${web_server_desc} responds at ${web_server_url}"
	run curl -v --fail --connect-timeout 10 --max-time 30 "${web_server_url}"
	assert_output --partial 'HTTP/1.1 200'
}

testImpl() {
    run echo "Starting test with arguments: $@"

    local -r docker_compose_options="$1"
    if [ -n "${docker_compose_options}" ]; then
        docker_compose_cmd_prefix="docker-compose ${docker_compose_options}"
    else
        docker_compose_cmd_prefix="docker-compose"
    fi
    run echo "docker_compose_cmd_prefix: ${docker_compose_cmd_prefix}"

    run echo "Arrange - Build docker images"

    cd $BATS_TEST_DIRNAME/..
    run ${docker_compose_cmd_prefix} build

    run echo "Act - Start docker containers"

	run ${docker_compose_cmd_prefix} up -d

    run echo "Assert that docker containers are running"

	run docker inspect -f {{.State.Running}} ${OPBEANS_PHP_CONTAINER_NAME}
	assert_output --partial 'true'
	run docker inspect -f {{.State.Running}} ${OPBEANS_PHP_FRONTEND_CONTAINER_NAME}
	assert_output --partial 'true'

    assertRunningWebServer "opbeans frontend" "http://127.0.0.1:${PORT}/"

    assertRunningWebServer "opbeans-php (opbeans backend)" "http://opbeans-php:9000/"

    run echo "Tear down - Stop docker containers"

	run ${docker_compose_cmd_prefix} down -v --remove-orphans
}

@test "Test with defaults" {
    testImpl
}

@test "Test with PostgreSQL as DB" {
    testImpl "--env-file docker-compose_env_for_PostgreSQL.txt -f docker-compose_PostgreSQL.yml -f docker-compose.yml"
}

@test "Test with backend distributed tracing" {
    testImpl "--env-file docker-compose_env_for_backend_distributed_tracing.txt -f docker-compose.yml -f docker-compose_backend_distributed_tracing.yml"
}
