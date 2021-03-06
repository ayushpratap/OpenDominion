#!/usr/bin/env bash

# Assumes the files .env.template.(local|production|testing) to be present in the root directory

if [[ ! $# -eq 1 ||  ! $1 =~ ^(local|production|testing)$ ]]; then
    echo "Usage: $0 (local|production|testing)"
    exit 1;
fi

env=$1

# Composer
composer self-update

if [[ ! -d vendor ]]; then
    if [[ ${env} == production ]]; then
        composer install --no-interaction --prefer-dist --no-dev
    else
        composer install --no-interaction --prefer-source

        if [[ ${env} == local ]] && grep -q laravel-ide-helper composer.json; then
            IDE_HELPERS=1
        fi
    fi
fi

# Dotenv
if [[ ! -f .env ]]; then
    cp ".env.template.$env" .env

    # Generate app key
    php artisan key:generate
fi

# Setup/seed database + IDE files on local
if [[ ${env} == local ]] && [[ ! -f storage/databases/local.sqlite ]]; then
    touch storage/databases/local.sqlite
    php artisan migrate --seed
fi

# Local IDE Helpers
if [[ ${IDE_HELPERS} ]]; then
    php artisan clear-compiled
    php artisan ide-helper:generate
    php artisan ide-helper:models -N
    php artisan ide-helper:meta
fi

# Frontend stuff, not needed during testing
if [[ ! ${env} == testing ]]; then

    # Npm packages
    if [[ ! -d node_modules ]]; then
        npm install
#        npm install --no-bin-links # todo: test if we can omit --no-bin-links
#        npm rebuild node-sass --no-bin-links # todo: might not be needed anymore. needs testing
    fi

    # Laravel Elixir
    if [[ ${env} == production ]]; then
        npm run prod
    else
        npm run dev
    fi

fi

# Fix for Travis
if [[ ${env} == testing ]]; then
    touch public/dummy
    echo '{"/assets/app/css/app.css":"/dummy","/assets/app/js/app.js":"/dummy"}' > public/mix-manifest.json
fi

# Show message on production
if [[ ${env} == production ]]; then
    echo "Don't forget to setup your .env file and run 'php artisan migrate --seed'"
fi

echo "Done"
