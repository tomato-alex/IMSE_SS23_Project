TYPE=VIEW
query=select `imse_23_ss`.`employee`.`employeeId` AS `employeeId`,`imse_23_ss`.`employee`.`first_name` AS `first_name`,`imse_23_ss`.`employee`.`last_name` AS `last_name`,`imse_23_ss`.`car`.`brand` AS `brand`,`imse_23_ss`.`car`.`modell` AS `modell`,`imse_23_ss`.`sells`.`date` AS `date`,sum(`imse_23_ss`.`sells`.`price`) AS `sum` from ((`imse_23_ss`.`sells` join `imse_23_ss`.`employee` on(`imse_23_ss`.`employee`.`employeeId` = `imse_23_ss`.`sells`.`employeeId`)) join `imse_23_ss`.`car` on(`imse_23_ss`.`car`.`carId` = `imse_23_ss`.`sells`.`carId`)) group by `imse_23_ss`.`employee`.`employeeId`,`imse_23_ss`.`employee`.`first_name`,`imse_23_ss`.`employee`.`last_name`,`imse_23_ss`.`car`.`brand`,`imse_23_ss`.`car`.`modell`,`imse_23_ss`.`sells`.`date` having sum(`imse_23_ss`.`sells`.`price`) > 100000 order by sum(`imse_23_ss`.`sells`.`price`) desc
md5=f4adf1af91018c7ea63bc0a77a6ad6cd
updatable=0
algorithm=0
definer_user=root
definer_host=localhost
suid=2
with_check_option=0
timestamp=0001687191281702880
create-version=2
source=SELECT employee.employeeId,\n    employee.first_name,\n    employee.last_name,\n    car.brand,\n    car.modell,\n    sells.date,\n    SUM(price) sum\nFROM sells\n    JOIN employee ON employee.employeeId = sells.employeeId\n    JOIN Car ON car.carId = sells.carId\nGROUP BY employee.employeeId,\n    employee.first_name,\n    employee.last_name,\n    car.brand,\n    car.modell,\n    sells.date\nHAVING SUM(price) > 100000\nORDER BY SUM(price) DESC
client_cs_name=utf8mb3
connection_cl_name=utf8mb3_general_ci
view_body_utf8=select `imse_23_ss`.`employee`.`employeeId` AS `employeeId`,`imse_23_ss`.`employee`.`first_name` AS `first_name`,`imse_23_ss`.`employee`.`last_name` AS `last_name`,`imse_23_ss`.`car`.`brand` AS `brand`,`imse_23_ss`.`car`.`modell` AS `modell`,`imse_23_ss`.`sells`.`date` AS `date`,sum(`imse_23_ss`.`sells`.`price`) AS `sum` from ((`imse_23_ss`.`sells` join `imse_23_ss`.`employee` on(`imse_23_ss`.`employee`.`employeeId` = `imse_23_ss`.`sells`.`employeeId`)) join `imse_23_ss`.`car` on(`imse_23_ss`.`car`.`carId` = `imse_23_ss`.`sells`.`carId`)) group by `imse_23_ss`.`employee`.`employeeId`,`imse_23_ss`.`employee`.`first_name`,`imse_23_ss`.`employee`.`last_name`,`imse_23_ss`.`car`.`brand`,`imse_23_ss`.`car`.`modell`,`imse_23_ss`.`sells`.`date` having sum(`imse_23_ss`.`sells`.`price`) > 100000 order by sum(`imse_23_ss`.`sells`.`price`) desc
mariadb-version=101103
