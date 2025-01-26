
USE chord_visualizer_db;

CREATE TABLE IF NOT EXISTS songs(
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        performer VARCHAR(255) NOT NULL
);