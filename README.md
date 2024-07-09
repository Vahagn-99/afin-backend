
# Afin Api

This is a afin application set up for local development using Docker and Laravel Sail.

## Prerequisites

- [Docker](https://www.docker.com/products/docker-desktop) installed and running on your local machine.

## Getting Started

Follow these steps to get the application up and running:

### 1. Clone the Repository

Clone this repository to your local machine using the following command:

```sh
git clone git@github.com:Vahagn-99/afin-backend.git
cd api.afin-backend
```

### 2. Set Up Environment Variables

Copy the example environment file to create your `.env` file:

```sh
cp .env.example .env
```

### 3. Start the Application

Use Docker Compose to start the application. This will set up the necessary containers:

```sh
docker-compose up -d
```

### 4. Install Dependencies

Once the containers are up and running, you need to install the application dependencies. Laravel Sail provides a convenient command to do this:

```sh
./vendor/bin/sail composer install
```

### 5. Generate Application Key

Generate the application key, which is used for encryption and other purposes:

```sh
./vendor/bin/sail artisan key:generate
```

### 6. Run Database Migrations

Run the database migrations to set up your database schema:

```sh
./vendor/bin/sail artisan migrate:fresh --seed
```

### 7. Run Tests

You can run the test suite using Laravel Sail. Use the following command to run the tests:

```sh
./vendor/bin/sail artisan test
```

## Stopping the Application

To stop the application and remove the containers, run:

```sh
docker-compose down
```
