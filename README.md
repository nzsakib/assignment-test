# Live test server address
http://139.59.135.16:9090
Debugbar is turned on to see the performance.
# Instruction to run the project locally
This project has enabled debugbar for debugging purposes.
## Setup Environment
1. Clone the repo first: 
```
git clone git@github.com:nzsakib/assignment-test.git sender-test
```

2. Copy `.env.example` as `.env`
```
cp .env.example .env
```
##### Requirement: 
- The project uses docker and Laravel sail for easier development. 
- Make sure docker is installed in your host environment. 

3. Run this command to install composer dependency for the first time. You dont have to run this again in future.
```
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php80-composer:latest \
    composer install --ignore-platform-reqs
```

4. Run this command to build and start the containers
```
./vendor/bin/sail up -d
```

5. Migrate the database. It will import the necessary data required.
```
./vendor/bin/sail artisan migrate
```

6. go to `localhost:9090` on browser to browse the project.

6. go to `localhost:9090` on browser to browse the project.

7. If you want to access redis on shell run this command: 
```
./vendor/bin/sail redis
```