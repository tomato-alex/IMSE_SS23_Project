TYPE=VIEW
query=select `imse_23_ss`.`car`.`brand` AS `brand`,`imse_23_ss`.`car`.`modell` AS `modell`,`imse_23_ss`.`leasing`.`duration` AS `duration`,`imse_23_ss`.`leasing`.`fee` AS `fee` from (`imse_23_ss`.`car` join `imse_23_ss`.`leasing` on(`imse_23_ss`.`car`.`leasingNr` = `imse_23_ss`.`leasing`.`leasingNr`))
md5=4d07cf39a660c076c7d545edfa042ad4
updatable=1
algorithm=0
definer_user=root
definer_host=localhost
suid=2
with_check_option=0
timestamp=0001687191281690024
create-version=2
source=SELECT car.brand,\n    car.modell,\n    leasing.duration,\n    leasing.fee\nFROM car\n    JOIN leasing ON car.leasingNr = leasing.leasingNr
client_cs_name=utf8mb3
connection_cl_name=utf8mb3_general_ci
view_body_utf8=select `imse_23_ss`.`car`.`brand` AS `brand`,`imse_23_ss`.`car`.`modell` AS `modell`,`imse_23_ss`.`leasing`.`duration` AS `duration`,`imse_23_ss`.`leasing`.`fee` AS `fee` from (`imse_23_ss`.`car` join `imse_23_ss`.`leasing` on(`imse_23_ss`.`car`.`leasingNr` = `imse_23_ss`.`leasing`.`leasingNr`))
mariadb-version=101103
