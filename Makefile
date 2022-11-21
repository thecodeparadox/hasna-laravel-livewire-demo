.DEFAULT_GOAL := start

ifndef VERBOSE
.SILENT:
endif

setup:
	composer install
	npm install
	cp -n .env.example .env
	php artisan key:generate

migrate:
	php artisan migrate:fresh --seed

build: setup migrate

serve:
	php artisan serve &
	npm run dev

run: build serve