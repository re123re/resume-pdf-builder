create table main_info(
                          id bigint NOT NULL AUTO_INCREMENT,
                          firstname char(50),
                          lastname char(50),
                          patronymic char(50),
                          imagePath char(50),
                          salary int,
                          email char(50),
                          PRIMARY KEY (id)
);

create table personal_info(
                              id bigint NOT NULL AUTO_INCREMENT,
                              employment char(50),
                              schedule char(50),
                              position char(50),
                              assignment char(50),
                              phone int,
                              city char(50),
                              crossing boolean,
                              citizenship char(50),
                              gender char(50),
                              birthdate date,
                              maritalStatus boolean,
                              PRIMARY KEY (id)
);

create table education_info(
                               id bigint NOT NULL AUTO_INCREMENT,
                               institute char(80),
                               faculty char(80),
                               speciality char(80),
                               dateFrom int(4),
                               dateTo int(4),
                               PRIMARY KEY (id)
);

create table experience_info(
                                id bigint NOT NULL AUTO_INCREMENT,
                                dateFrom date,
                                dateTo date,
                                position char(50),
                                organization char(80),
                                duties text,
                                PRIMARY KEY (id)
);

create table user_info(
                          id bigint NOT NULL AUTO_INCREMENT,
                          main_info_id bigint,
                          personal_info_id bigint,
                          education_info_id bigint,
                          experience_info_id bigint,
                          generate_date datetime,
                          PRIMARY KEY (id),
                          FOREIGN KEY (main_info_id)  	   REFERENCES main_info (id),
                          FOREIGN KEY (personal_info_id)   REFERENCES personal_info (id),
                          FOREIGN KEY (education_info_id)  REFERENCES education_info (id),
                          FOREIGN KEY (experience_info_id) REFERENCES experience_info (id)
);

TRUNCATE user_info;
TRUNCATE main_info;
TRUNCATE personal_info;
TRUNCATE education_info;
TRUNCATE experience_info;


drop table user_info;
drop table  main_info;
drop table  personal_info;
drop table  education_info;
drop table  experience_info;