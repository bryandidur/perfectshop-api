# Getting Started with PerfectShop API

### Prerequisites
- Git ^2.34.1
- Docker ^28.1.1

### Clone the project
#### `git clone git@github.com:bryandidur/perfectshop-api.git`
#### `(or with HTTP: git clone https://github.com/bryandidur/perfectshop-api.git)`

### Enter the project folder
#### `cd perfectshop-api`

### Copy .env.example file to .env
#### `cp .env.example .env`

### Install Sail Composer dependencies
#### `docker run --rm -u "$(id -u):$(id -g)" -v $(pwd):/var/www/html -w /var/www/html laravelsail/php84-composer:latest composer install --ignore-platform-reqs`

### Setup Docker containers (Port 80 must be available; Wait some minutes for the containers to be ready and log stops)
#### `./vendor/bin/sail up`
