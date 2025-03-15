# Core Lab Challenge - Backend

This repository contains an API built with **Laravel** as part of a challenge provided by [CoreLab](https://www.corelab.com.br/pt).

## Technologies Used

The following technologies were used to build the application:

- **NodeJS**: 20.17.0
- **MySQL**: 8.0
- **Laravel**: 11.0

## Setup

*This application uses MySQL as the database, but you can modify the configurations in the `.env` file if you wish to use another database.*

### Installation Steps

1. **Clone or fork this repository** to your local machine.
   
2. **Open your terminal** and ensure you're in the project root before running the following commands.

3. **Install the project dependencies**:
   ```bash
   composer install
   ```

4. **Create the `.env` file** based on the `.env.example` file:
   - Rename the `.env.example` file to `.env`.
   - Modify the following variables according to your setup:

   ```env
   DB_CONNECTION=mysql
   DB_HOST=mysql
   DB_PORT=3306
   DB_DATABASE=laravel-corelab
   DB_USERNAME=laravel_user
   DB_PASSWORD=laravel_pass

   JWT_SECRET=jwtsecretencryptioncode
   ```
   *Hint: run ```php artisan jwt:secret``` to generate automatically the JWT_SECRET environment variable*

5. **Run the database migrations**:
   ```bash
   php artisan migrate
   ```

6. **Start the application**:
   ```bash
   php artisan serve
   ```

## Running the Application with Docker Compose

To run both the application and the MySQL database in Docker containers, follow these steps:

1. **Ensure you're in the project root folder, where the `docker-compose.yml` file is**, which defines both the application and the MySQL database services.

2. **Run the following command to build and start both containers** (application and database):
   ```bash
   docker-compose up --build -d
   ```

3. This will start the application and MySQL containers in detached mode.

4. The database data will be saved in a folder "db_data", that will be created inside the project root folder. 

### Stopping and Removing Docker Containers

To stop and remove the Docker containers, follow these steps:

1. **Stop the running containers**:
   ```bash
   docker-compose down
   ```

2. **Remove the stopped containers and volumes** (optional):
   ```bash
   docker-compose down --volumes

## Next Steps

Check the [Frontend](https://github.com/caio-ferreira-dev/corelab-challenge-web-app-php) repository for instructions related to the frontend part of the application. 🚀
