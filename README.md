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

3. When build is finalized successful (no more creation messages/logs in the terminal), load the webpage in the browser:
```
localhost:80
```
4. Log in as admin (login input field) and click "fill db" button in the lower right screen. (After filling the db with random content, the admin will be logged out, you can then log back in. This is a decision to better the security design)
5. Log in as admin again and select a location (choose location input, input location id)
6. View the employees and pick an employee. Employee usernames are formed by concatinating the ID with the first name (21 Maria Huber will have a username 21Maria)
7. Log in as your selected employee (with the same login input field)
8. View the location again
9. Explore around and test the functionalities
