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
