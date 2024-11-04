#!/bin/bash

if [ -z "$(which fswatch)" ]; then
    echo "fswatch not installed."
    exit 1
fi

counter=0;

function execute() {
    ./vendor/bin/php-cs-fixer fix
}

fswatch "./src" | xargs -n1 -I{} ./vendor/bin/php-cs-fixer fix
