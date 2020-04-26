#!/usr/bin/env bash
set -e -u
source $DOCKERUTIL_PATH
set -a
source ./bin/test/.env
set +a

docker service create \
  ${COMMON_SERVICE_CREATE_OPTIONS[@]} \
  --name $RABBITMQ_SERVICE \
  --publish ${RABBITMQ_SERVICE_AMQP_PUBLISH_PORT}:${AMQP_PORT} \
  --publish ${RABBITMQ_SERVICE_MANAGEMENT_PUBLISH_PORT}:15672 \
  --hostname $RABBITMQ_SERVICE \
  --limit-cpu 0.5 \
  --limit-memory 500M \
  --env RABBITMQ_DEFAULT_VHOST=${AMQP_VHOST} \
  --env RABBITMQ_DEFAULT_USER=${AMQP_USER} \
  --env RABBITMQ_DEFAULT_PASS=${TEST_PASSWORD} \
  --env RABBITMQ_VM_MEMORY_HIGH_WATERMARK='0.6' \
  ${RABBITMQ_SERVICE_IMAGE}

dockerutil::print_success "created service: $RABBITMQ_SERVICE"
