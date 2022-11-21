.DEFAULT_GOAL := start

ifndef VERBOSE
.SILENT:
endif

build:
	composer install
	php artisan migrate:fresh --seed
	npm install

serve:
	php artisan serve &
	npm run dev