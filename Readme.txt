------------Design---------------
1. Frontend will be developed by using vue 3 and the backend will be developed by using laravel 11.
2. The database will be used by mysql
3. The project will be managed by git
4. The project will be deployed by using docker
5. There will be 3 containers

    - Backend code with the laravel supervisor for the queue worker
    - mysql
    - nginx

-----------------Installation----------------

1. Get the code from the repository
2. Run composer install in the ExcelDocumentUpload directory
2. Run the docker-compose up command in the root directory of the project
3. Run the npm install and the npm run dev command in the frontend directory

4. Run the migration using the following command

    docker exec <your_container_name> php artisan migrate

5. Default login credentials

    - email: test@gmail.com
    - password: abcd1234

6. The postman collection is ExcelDataUploader.postman_collection.json. You can import the collection to the postman to check the endpoints.
