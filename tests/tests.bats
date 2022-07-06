#!/usr/bin/env bats

load 'test_helper/bats-support/load'
load 'test_helper/bats-assert/load'
load test_helpers

IMAGE="bats-opbeans"
OPBEANS_PHP_CONTAINER_NAME="opbeans-php"
OPBEANS_PHP_FRONTEND_CONTAINER_NAME="opbeans-php-frontend"
DOCKER_COMPOSE_WITH_POSTGRESQL_CMD_PREFIX="docker-compose --env-file docker-compose_env_for_PostgreSQL.txt"

@test "Arrange - Build docker images" {
	cd $BATS_TEST_DIRNAME/..
	run docker-compose build
	assert_success
}

@test "Act - Start docker containers" {
	run docker-compose up -d
	assert_success
}

@test "Assert that docker containers are running" {
	run docker inspect -f {{.State.Running}} ${OPBEANS_PHP_CONTAINER_NAME}
	run docker inspect -f {{.State.Running}} ${OPBEANS_PHP_FRONTEND_CONTAINER_NAME}
	assert_output --partial 'true'
}

@test "Assert that opbeans app is running at port ${PORT}" {
	sleep 50
	URL="http://127.0.0.1:${PORT}"
	run curl -v --fail --connect-timeout 10 --max-time 30 "${URL}/"
	assert_success
	assert_output --partial 'HTTP/1.1 200'
}

@test "Tear down - Stop docker containers" {
	run docker-compose down -v --remove-orphans
	assert_success
}

@test "Arrange - Build docker images [with PostgreSQL as DB]" {
	cd $BATS_TEST_DIRNAME/..
	run ${DOCKER_COMPOSE_WITH_POSTGRESQL_CMD_PREFIX} build
	assert_success
}

@test "Act - Start docker containers [with PostgreSQL as DB]" {
	run ${DOCKER_COMPOSE_WITH_POSTGRESQL_CMD_PREFIX} up -d
	assert_success
}

@test "Assert that docker containers are running [with PostgreSQL as DB]" {
	run docker inspect -f {{.State.Running}} ${OPBEANS_PHP_CONTAINER_NAME}
	run docker inspect -f {{.State.Running}} ${OPBEANS_PHP_FRONTEND_CONTAINER_NAME}
	assert_output --partial 'true'
}

@test "Assert that opbeans app is running at port ${PORT} [with PostgreSQL as DB]" {
	sleep 50
	URL="http://127.0.0.1:${PORT}"
	run curl -v --fail --connect-timeout 10 --max-time 30 "${URL}/"
	assert_success
	assert_output --partial 'HTTP/1.1 200'
}

@test "Tear down - Stop docker containers [with PostgreSQL as DB]" {
	run ${DOCKER_COMPOSE_WITH_POSTGRESQL_CMD_PREFIX} down -v --remove-orphans
	assert_success
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

    run curl -v --fail --connect-timeout 10 --max-time 30 "http://127.0.0.1:${PORT}/"
	assert_success
	assert_output --partial 'HTTP/1.1 200'

    # run curl -v --fail --connect-timeout 10 --max-time 30 "http://${OPBEANS_PHP_CONTAINER_NAME}:9000/"
	# assert_success
	# assert_output --partial 'HTTP/1.1 200'

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
