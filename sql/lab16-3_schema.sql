CREATE TABLE lab16_3_users (
    id SERIAL PRIMARY KEY,
    lastname VARCHAR(100) NOT NULL,
    firstname VARCHAR(100) NOT NULL,
    login VARCHAR(50) NOT NULL UNIQUE,
    password CHAR(32) NOT NULL
);
