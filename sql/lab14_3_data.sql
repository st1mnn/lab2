INSERT INTO lab14_3_firms (id, name) VALUES
    (1, 'Hilton Worldwide'),
    (2, 'Marriott International'),
    (3, 'Accor S.A.');

INSERT INTO lab14_3_countries (id, name) VALUES
    (1, 'France'),
    (2, 'Germany'),
    (3, 'Spain');

INSERT INTO lab14_3_hotels (id, name, cost, country_id, firm_id) VALUES
    (1, 'Paris Central', 180.00, 1, 1),
    (2, 'Lyon Comfort', 120.50, 1, 2),
    (3, 'Berlin Midtown', 150.75, 2, 1),
    (4, 'Munich Grand', 200.00, 2, 3),
    (5, 'Barcelona Seaside', 170.25, 3, 2),
    (6, 'Madrid Plaza', 160.00, 3, 3);
