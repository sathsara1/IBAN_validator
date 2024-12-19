------------Design---------------
1. Frontend will be developed by using vue 3 and the backend will be developed by using laravel 11.
2. The database will be used by mysql
3. The project will be managed by git

Further planned modifications:
1. The project will be dockerized
2. The project will be deployed by using docker-compose up command
5. There will be 3 containers

    - web
    - mysql
    - nginx

-----------------Installation----------------

Backend installation:

1. Get the code from the repository
2. Run composer install in the backend directory
3. Run php artisan migrate---seed to migrate all the tables and seed the user table
4. Run php artisan serve to run the project

Frontend installation:

1. Run npm install in the frontend directory
2. Run npm run serve to run the project



5. Default login credentials

    - email: test@gmail.com
    - password: abcd1234

6. The postman collection and the environment can be found in the Postman collection IBAN.postman_collection.json. You can import the collection and the environment to the postman to check the endpoints.
