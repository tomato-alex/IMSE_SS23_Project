CREATE DATABASE IF NOT EXISTS imse_23_ss;
USE imse_23_ss;
CREATE TABLE locations(
    locationId int AUTO_INCREMENT PRIMARY KEY,
    city varchar(40) NOT NULL,
    country varchar(40) NOT NULL,
    address varchar(70)
);
CREATE TABLE workshop(
    locationId int,
    workshopId int,
    phone_number varchar(20) NOT NULL,
    employee_count integer DEFAULT 3,
    UNIQUE(phone_number),
    PRIMARY KEY (locationId, workshopId),
    FOREIGN KEY (locationId) REFERENCES locations(locationId) ON DELETE CASCADE
);
CREATE TABLE leasing(
    leasingNr integer AUTO_INCREMENT,
    duration integer DEFAULT 5,
    fee decimal(10, 2) NOT NULL,
    CHECK (
        duration >= 0
        AND duration <= 20
    ),
    CHECK (fee >= 0),
    PRIMARY KEY (leasingNr)
);
SET @@auto_increment_increment = 10;
ALTER TABLE leasing AUTO_INCREMENT = 100;
CREATE TABLE car(
    carId integer AUTO_INCREMENT,
    brand varchar(40),
    modell varchar(50),
    leasingNr integer,
    PRIMARY KEY (carId),
    FOREIGN KEY (leasingNr) REFERENCES leasing(leasingNr)
);
CREATE TABLE employee(
    employeeId integer AUTO_INCREMENT,
    first_name varchar(20) NOT NULL,
    last_name varchar(30) NOT NULL,
    locationId integer,
    managerId integer DEFAULT NULL,
    PRIMARY KEY(employeeId),
    FOREIGN KEY (locationId) REFERENCES locations (locationId) ON DELETE
    SET NULL,
        FOREIGN KEY (managerId) REFERENCES employee (employeeId) ON DELETE
    SET NULL
);
CREATE TABLE sells(
    employeeId integer,
    carId integer,
    price decimal(10, 2) NOT NULL,
    date DATE NOT NULL,
    CONSTRAINT price_check_v CHECK (price >= 0),
    PRIMARY KEY(employeeId, carId),
    FOREIGN KEY (employeeId) REFERENCES employee (employeeId),
    FOREIGN KEY (carId) REFERENCES car (carId)
);
CREATE TABLE has(
    locationId integer,
    carId integer,
    PRIMARY KEY(locationId, carId),
    FOREIGN KEY (locationId) REFERENCES locations(locationId) ON DELETE CASCADE,
    FOREIGN KEY (carId) REFERENCES car(carId) ON DELETE CASCADE
);
-- VIEWS
CREATE VIEW leasing_options AS
SELECT car.brand,
    car.modell,
    leasing.duration,
    leasing.fee
FROM car
    JOIN leasing ON car.leasingNr = leasing.leasingNr;
CREATE VIEW total_sales AS
SELECT employee.employeeId,
    employee.first_name,
    employee.last_name,
    car.brand,
    car.modell,
    sells.date,
    SUM(price) sum
FROM sells
    JOIN employee ON employee.employeeId = sells.employeeId
    JOIN car ON car.carId = sells.carId
GROUP BY employee.employeeId,
    employee.first_name,
    employee.last_name,
    car.brand,
    car.modell,
    sells.date
HAVING SUM(price) > 100000
ORDER BY SUM(price) DESC;