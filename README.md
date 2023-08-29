# assistive_tech_manager
Assistive Technology Management System


## Technologies

- PHP/Symfony: The web application is built using PHP and the Symfony framework to build routes, validate data input and present results.  
- VanillaJS & jQuery: Used to control the GUI events. 
- Docker: Used to run the web application in local environments.
- MySQL: Used to save the web app information.

## Installation

Clone the project via `git` or copy it via `ftp`. Also copy it directly on a filesystem. 

1. `git clone git@github.com:yjmorales/assistive_tech_manager.git`

2. `cd Path/To/assistive_tech_manager` Go to the web app directory.

3. `composer install` Install dependencies.

4. Migrate database. 

Before create the tables it's required to update the .env file by 
changing updating the following variable:

> DATABASE_URL="mysql://root:admin@127.0.0.1:3318/assistive_tech_manager" 

Then execute the migration: `php bin/console doctrine:migrations:migrate`

Rollback the variable to its initial value
> DATABASE_URL="mysql://root:admin@db:3306/assistive_tech_manager?serverVersion=8.0"

5. `npm install` Install packages.  

6. `gulp run` Execute tasks to prepare the files the web app use.


## To run it locally via Docker.

Execute `docker-compose up --build -d`

Then open in a browser the URL http://127.0.0.1:8083/index.php/admin/

## Note: 

For security reasons the `.env` file Must not be included. It's included in this repo for DEMO 
purposes. 


## Contact

Yenier Jimenez
<br>
http://yenierjimenez.net
<br>
yjmorales86@gmail.com
