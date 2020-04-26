#!/bin/bash
set -e -u
source $DOCKERUTIL_PATH
set -a
source ./bin/.env
source ./bin/test/.env
set +a

function create_secret() {
    local secret=$1
    local password=$2
    echo "$password" | docker secret create --label "$TESTENV_LABEL" $secret -
    dockerutil::print_success "Created secret ${secret}"
}
for secret in ${SECRETS[*]}
do
    create_secret $secret $TEST_PASSWORD
done

function create_test_network() {
    docker network create --label $TESTENV_LABEL --driver overlay $NETWORK --subnet $NETWORK_SUBNET 2> /dev/null
}

set +e
create_test_network
if [ $? -ne 0 ]; then
    set -e
    sleep 5
    create_test_network
fi
dockerutil::print_success "Created network '$NETWORK'"
