# Getting Started with PerfectShop API

### Prerequisites
- Git
- Docker

### Clone the project
#### `git clone git@github.com:bryandidur/perfectshop-api.git`
#### `(or with HTTP: git clone https://github.com/bryandidur/perfectshop-api.git)`

### Enter the project folder
#### `cd perfectshop-api`

### Start Sail Composer dependencies
#### `docker run --rm -u "$(id -u):$(id -g)" -v $(pwd):/var/www/html -w /var/www/html laravelsail/php81-composer:latest composer install --ignore-platform-reqs`

### Setup Docker containers (Wait some minutes for the containers to be ready and log stops)
#### `./vendor/bin/sail up`
