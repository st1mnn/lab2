CREATE TABLE lab11_5_firms (
    id SERIAL PRIMARY KEY,
    name VARCHAR(150) NOT NULL
);

CREATE TABLE lab11_5_cars (
    id SERIAL PRIMARY KEY,
    firm_id INT NOT NULL,
    name VARCHAR(150) NOT NULL,
    cost NUMERIC(14,2) NOT NULL,
    power INT NOT NULL,
    CONSTRAINT fk_car_firm
        FOREIGN KEY(firm_id)
        REFERENCES lab11_5_firms(id)
        ON DELETE CASCADE
);
