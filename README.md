# assistive_tech_manager
Assistive Technology Management System


## Technologies

- PHP/Symfony: The web application is built using PHP and the Symfony framework to build routes, validate data input and present results.  
- VanillaJS & jQuery: Used to control the GUI events. 
- Docker: Used to run the web application in local environments.
- MySQL: Used to save the web app information.

## Installation

Clone the project via `git` or copy it via `ftp`. Also copy it directly on a filesystem. 

`git clone git@github.com:yjmorales/assistive_tech_manager.git`

`cd Path/To/assistive_tech_manager` Go to the web app directory.

`composer install` Install dependencies.

`php bin/console doctrine:migrations:migrate`

`npm install` Install packages.  

`gulp run` Execute tasks to prepare the files the web app use.


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
