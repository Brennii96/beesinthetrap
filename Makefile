APP_NAME=beesinthetrap
APP_NAME_DEV=beesinthetrap_dev

build:
	docker build -t ${APP_NAME} .

build_dev:
	docker build -f Dockerfile.dev -t ${APP_NAME_DEV} .

remove:
	docker rmi ${APP_NAME} || true

run:
	docker run -it --rm ${APP_NAME} ${ARGS}

start: build run

test: build_dev
	docker run -it --rm ${APP_NAME_DEV} ./vendor/bin/phpunit