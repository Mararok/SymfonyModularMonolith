#!/bin/bash
set -e -u
source $DOCKERUTIL_PATH
set -a
source ./bin/test/.env
set +a

dockerutil::clean_all_with_label $TESTENV_LABEL
