# Instruction to run the project
## Setup Environment
1. Copy `.env.example` as `.env`
```
cp .env.example .env
```
##### Requirement: 
- The project uses docker and Laravel sail for easier development. 
- Make sure docker is installed in your host environment. 
2. Run this command to build and start the containers
```
./vendor/bin/sail up -d
```
3. Migrate the database. It will import the necessary data required.
```
./vendor/bin/sail artisan migrate
```
4. go to `localhost:9090` on browser to browse the project.

