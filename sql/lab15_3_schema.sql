CREATE TABLE lab15_3_countries (
    id SERIAL PRIMARY KEY,
    name VARCHAR(150) NOT NULL
);

CREATE TABLE lab15_3_firms (
    id SERIAL PRIMARY KEY,
    name VARCHAR(150) NOT NULL
);

CREATE TABLE lab15_3_hotels (
    id SERIAL PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    cost NUMERIC(10,2) NOT NULL,
    country_id INT NOT NULL,
    firm_id INT NOT NULL,
    CONSTRAINT fk_hotel_country
        FOREIGN KEY(country_id)
        REFERENCES lab15_3_countries(id)
        ON DELETE RESTRICT,
    CONSTRAINT fk_hotel_firm
        FOREIGN KEY(firm_id)
        REFERENCES lab15_3_firms(id)
        ON DELETE RESTRICT
);
