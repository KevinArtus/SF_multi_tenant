#!/bin/bash
# run php command in container
# used in visual studio workspace settings : 
# "php.validate.executablePath": "./bin/php_docker.sh",
docker-compose exec -u `echo $UID` phpapache /usr/local/bin/php "$@"