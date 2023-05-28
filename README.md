# IMSE_SS23_Project

## Idea:

Create a functioning PHP frontend with REST API integration to communicate between a DB and the frontend with easy switch and data migration from SQL to NoSQL

## Tech stack

- Docker
- PHP
- Java
- MariaDB
- MongoDB

## Steps

1. Clone the repository locally
2. In the terminal run

```shell
docker-compose up --build
```

3. Connect to the imse_proj-frontend-1 container

```shell
docker exec -it imse_proj-frontend-1 bash
```

4. You should be in the frontend container now.
5. Test the connection to the 2 Databases:
   5.1. MariaDB

   ```shell
   mysql -h mariadb -u root -pimse23ss
   ```

   5.2. MongoDB

   ```shell
   --TODO
   ```
