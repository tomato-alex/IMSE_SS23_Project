# IMSE_SS23_Project

## Idea:

Create a functioning PHP frontend with REST API integration to communicate between a DB and the frontend with easy switch and data migration from SQL to NoSQL

## Tech stack

- Docker
- PHP
- MySQL
- MongoDB

## Steps

1. Clone the repository locally
2. In the terminal run

```shell
docker-compose up --build
```

3. Connect to the imse_proj-mysql-1 container

```shell
docker exec -it imse_proj-frontend-1 bash
```

3.1. You should be in the mysql container now. Container might disconnect while initializing itself, if it happens, run step 3 again
4. Change your working directory to the one mapped to the host:
```shell
cd docker-entrypoint-initdb.d
```
5. Once inside, run the following command to create the database:
```shell
mysql -uroot -ptestpass < 2_mysql_create.sql
```
6. When successful, exit the container and load the webpage in the browser:
```
localhost:80
```
7. Log in as admin (login input field) and click "fill db" button in the lower right screen. (After filling the db with random content, the admin will be logged out, you can then log back in. This is a decision to better the security design)
8. Log in as admin again and select a location (choose location input, input location id)
9. View the employees and pick an employee. Employee usernames are formed by concatinating the ID with the first name (21 Maria Huber will have a username 21Maria)
10. Log in as your selected employee (with the same login input field)
11. View the location again
12. Explore around and test the functionalities
