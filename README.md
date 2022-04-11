# backend

Backend of the api

## How to setup project
### Step 1 ###
- install [composer](https://getcomposer.org/doc/00-intro.md) and [git](https://git-scm.com/book/en/v2/Getting-Started-Installing-Git)
- clone the [repository](https://gitlab.com/cars-services-app/backend) from [gitlab](https://gitlab.com/) Or u can just download it
> `git clone https://gitlab.com/cars-services-app/backend.`
- move the project to `www` folder in wamp directory or `htdocs` folder in xamp
### step 2 ###
Navigate to the project root directory and 
Run composer install to download project dependencies:
 > `composer install`
### Step 3 ###
update the `.env` file found int the project root directory, to add database and email environment variables
 - add database connection  environment variables
```yaml
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=car_boda_app
DB_USERNAME=root
DB_PASSWORD=
```
- add email environment variables
```yaml
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=kamasupaul1@gmail.com
MAIL_PASSWORD=uqokymgepphsvbxd
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=kamasupaul1@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```
### Step 4 ###
- setup a mysql database for the project ( use credentials that you put in the .env file)
- Run the migrations ***Make sure wamp or xamp are installed and running***
> `php artisan migrate`
### Step 5 ###
Start the server with the command
> `php artisan serve`

You can now access the api at the url  <http://127.0.0.1:8000/api/> <br>
 and the documentation for the api routes
- [Redoc](https://github.com/Redocly/redoc) documentation for routes is  found at <http://127.0.0.1:8000/api/documentation>
- [Swagger/Open api](https://swagger.io/resources/open-api/swagger) docs for the routes  at <http://127.0.0.1:8000/api/console>
### step 6 ###
Check out the develop brach and start coding.
> `git checkout develop`

😃 Happy coding. We look forward to a successful journey with you! ***Welcome aboard!***
> Congratulations on being part of the team!<br>

