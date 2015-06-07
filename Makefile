PROJECT_PATH = $(shell pwd)

stop:
	docker stop nginx_server
	docker stop phpfpm
	docker rm nginx_server
	docker rm phpfpm

run:
	docker run --name phpfpm -d -v $(PROJECT_PATH):/app php:5.6-fpm
	docker run --name nginx_server -d -p 80:80 --link phpfpm:phpfpm -v $(PROJECT_PATH)/nginx.conf:/etc/nginx/nginx.conf -v $(PROJECT_PATH)/logs:/var/log/nginx --volumes-from phpfpm  nginx
	docker ps

restart:
	docker restart phpfpm
	docker restart nginx_server

log:
	docker logs -f nginx_server
