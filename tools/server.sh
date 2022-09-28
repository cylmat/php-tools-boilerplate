#!/bin/bash

function usage(){
	printf "Utilisation du script :\n"
	printf "\t--run                 : Run local php server on port 80\n"
    printf "\t--stop                : Stop local php server\n"
}

if [ $# -eq 0 ]; then
	usage
fi

OPTS=$(getopt -o r,s -l run,stop,default: -- "$@")

if [ $? != 0 ]; then
    exit 1
fi

eval set -- "$OPTS"

function run_server() {
    php -S localhost:88 -t html &
}

function stop_server() {
    kill -9 $(ps aux | grep "localhost:88" -m 1 | awk '{print $2;}')
    echo "Server localhost:88 stopped..."
}

for i in "$@"; do
    case $i in
        -r) run_server;
            exit 0;;
        --run) run_server;
            exit 0;;
        -s) stop_server;
            exit 0;;
        --stop) stop_server;
            exit 0;;
        --) exit 0;;
	esac
done
 
exit 0