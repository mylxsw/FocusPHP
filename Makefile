PROJECT_PATH = $(shell pwd)

run:
	docker run --name mysql_server -d -e MYSQL_ROOT_PASSWORD=root mysql
	docker run --name phpfpm -d -v $(PROJECT_PATH):/app --link mysql_server:mysql php:5.6-fpm
	docker run --name nginx_server -d -p 80:80 --link phpfpm:phpfpm -v $(PROJECT_PATH)/nginx.conf:/etc/nginx/nginx.conf -v $(PROJECT_PATH)/logs:/var/log/nginx --volumes-from phpfpm  nginx
	docker ps

stop:
	docker stop nginx_server
	docker stop phpfpm
	docker rm nginx_server
	docker rm phpfpm
	docker stop mysql_server
	docker rm mysql_server

restart:
	docker restart phpfpm
	docker restart nginx_server

log:
	docker logs -f nginx_server

mysql_connect:
	docker run -t -i --rm --link mysql_server:mysql mysql sh -c 'exec mysql -h"$MYSQL_PORT_3306_TCP_ADDR" -P"$MYSQL_PORT_3306_TCP_PORT" -uroot -p"$MYSQL_ENV_MYSQL_ROOT_PASSWORD"'
