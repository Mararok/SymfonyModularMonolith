export BIN_SCRIPTS_ROOT_PATH = ./bin
export DOCKERUTIL_PATH = $(BIN_SCRIPTS_ROOT_PATH)/dockerutil
export MAKEHELP_PATH = $(BIN_SCRIPTS_ROOT_PATH)/MakeHelp
export PROJECT = test_symfony
export SUBPROJECT ?= api
export SUBPROJECTS = api
export ENVIRONMENT ?= test
export BIN_SCRIPTS_PATH = bin/$(ENVIRONMENT)
export IMAGE_DOCKERFILE = Dockerfile
export IMAGE_BUILD_TARGET = production_$(SUBPROJECT)
export IMAGE_SUBPROJECT = $(SUBPROJECT)
export IMAGE_BUILD_CONTEXT = .

export ACCOUNT ?= 0

ifeq "$(ENVIRONMENT)" "test"
LOCAL_REGISTRY_PORT = 5000
export IMAGE_NAMESPACE = localhost:$(LOCAL_REGISTRY_PORT)
export VERSION = test
endif

ifeq "$(ENVIRONMENT)" "prod"
export IMAGE_NAMESPACE = "<empty>"
endif

export IMAGE = $(IMAGE_NAMESPACE)/$(PROJECT)_$(IMAGE_SUBPROJECT):$(VERSION)

INFO = Showing targets for all of ENVIRONMENT(default: test) and SUBPROJECT(default: api)
EXTRA_MAKE_ARGS = ENVIRONMENT=test|prod SUBPROJECT=$(SUBPROJECTS)
HELP_TARGET_MAX_CHAR_NUM = 30
HAS_DEPS = yes
.DEFAULT_GOAL := help

ifeq ("$(wildcard $(MAKEHELP_PATH))","")
    $(info MakeHelp does not exists execute: 'make deps')
    HAS_DEPS =
endif
ifeq ("$(wildcard $(DOCKERUTIL_PATH))","")
    $(info dockerutil does not exists execute: 'make deps')
    HAS_DEPS =
endif

## Download external necessary libs
deps:
	@echo "installing.."
	@curl -sS https://raw.githubusercontent.com/SAREhub/php_dockerutil/0.3.10/bin/dockerutil > ${DOCKERUTIL_PATH}
	@curl -sS https://raw.githubusercontent.com/SAREhub/php_dockerutil/0.3.10/bin/MakeHelp > ${MAKEHELP_PATH}
	@echo "installed"

ifdef HAS_DEPS
include $(MAKEHELP_PATH)

ifneq ($(MAKECMDGOALS),)
ifneq ($(MAKECMDGOALS),help)
ifndef VERSION
$(error VERSION is not set)
endif
endif
endif

# SYMFONY
## Clears Symfony cache
sf_cc:
	@php bin/console cache:clear

## Runs localc Symfony server
sf_start_local_server:
	symfony server:start --no-ansi
# END SYMFONY

## Builds and pushes selected subproject image
deploy_image:
	@bash bin/deploy_image.sh

deploy_service:
	@bash "${BIN_SCRIPTS_PATH}/$(SUBPROJECT)/deploy.sh"

ifeq "$(ENVIRONMENT)" "test"
## Runs docker local registry container for pushing test images
test_init_local_registry:
	docker run -d -p $(LOCAL_REGISTRY_PORT):5000 --restart=always --name registry registry:2

## Clean test env and inits all depending services like database
test_init: test_clean test_init_base test_init_deps_services

## Creates test secrets and network
test_init_base:
	@bash ${BIN_SCRIPTS_PATH}/init.sh

test_init_deps_services: test_init_mysql test_init_rabbitmq

## Creates mysql service
test_init_mysql:
	@bash $(BIN_SCRIPTS_PATH)/mysql/deploy.sh

## Creates rabbitmq service
test_init_rabbitmq:
	@bash $(BIN_SCRIPTS_PATH)/rabbitmq/deploy.sh

## deploys current image and service
test_update_service: deploy_image deploy_service

## Clean test env
test_clean:
	bash $(BIN_SCRIPTS_PATH)/clean.sh
endif

endif

