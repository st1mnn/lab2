CREATE TABLE lab9_5_firms (
    id SERIAL PRIMARY KEY,
    name VARCHAR(250) NOT NULL
);

CREATE TABLE lab9_5_cars (
    id SERIAL PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    cost INT NOT NULL,
    firm_id INT NOT NULL,
    CONSTRAINT fk_car_firm
        FOREIGN KEY(firm_id)
        REFERENCES lab9_5_firms(id)
        ON DELETE CASCADE
);
