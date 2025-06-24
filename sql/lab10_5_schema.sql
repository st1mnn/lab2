CREATE TABLE lab10_5_firms (
    id SERIAL PRIMARY KEY,
    name VARCHAR(250) NOT NULL
);

CREATE TABLE lab10_5_countries (
    id SERIAL PRIMARY KEY,
    name VARCHAR(150) NOT NULL
);

CREATE TABLE lab10_5_cars (
    id SERIAL PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    firm_id INT NOT NULL,
    country_id INT NOT NULL,
    CONSTRAINT fk_car_firm
        FOREIGN KEY(firm_id)
        REFERENCES lab10_5_firms(id)
        ON DELETE CASCADE,
    CONSTRAINT fk_car_country
        FOREIGN KEY(country_id)
        REFERENCES lab10_5_countries(id)
        ON DELETE CASCADE
);
