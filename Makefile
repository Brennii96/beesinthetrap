APP_NAME=beesinthetrap

build:
	docker build -t ${APP_NAME} .

remove:
	docker rmi ${APP_NAME} || true

run:
	docker run -it --rm ${APP_NAME} ${ARGS}

start: build run
