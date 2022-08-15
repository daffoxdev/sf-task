##################
# Variables
##################

CONTAINER_NAME = sf_task_container
DOCKER_COMPOSE = docker-compose
PHP_CONTAINER_INTERACTIVE = docker exec -it ${CONTAINER_NAME}

##################
# Docker compose
##################

build:
	${DOCKER_COMPOSE} build

start:
	${DOCKER_COMPOSE} start

stop:
	${DOCKER_COMPOSE} stop

up:
	${DOCKER_COMPOSE} up -d --remove-orphans

ps:
	${DOCKER_COMPOSE} ps

logs:
	${DOCKER_COMPOSE} logs -f

down:
	${DOCKER_COMPOSE} down -v --rmi=all --remove-orphans

##################
# App
##################

container:
	${PHP_CONTAINER_INTERACTIVE} bash