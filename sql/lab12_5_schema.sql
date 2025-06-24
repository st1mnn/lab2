CREATE TABLE lab12_5_users (
    id SERIAL PRIMARY KEY,
    login VARCHAR(32) NOT NULL UNIQUE,
    password VARCHAR(32) NOT NULL
);

CREATE TABLE lab12_5_visits (
    id SERIAL PRIMARY KEY,
    user_id INT NOT NULL,
    page_name VARCHAR(150) NOT NULL,
    visited_at TIMESTAMP NOT NULL DEFAULT now(),
    CONSTRAINT fk_visit_user
      FOREIGN KEY(user_id)
      REFERENCES lab12_5_users(id)
      ON DELETE CASCADE
);
