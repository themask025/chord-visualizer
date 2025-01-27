CREATE DATABASE IF NOT EXISTS chord_visualizer_db;

USE chord_visualizer_db;

CREATE TABLE IF NOT EXISTS comments(
    id INT AUTO_INCREMENT PRIMARY KEY,
    song_version_id VARCHAR(255) NOT NULL FOREIGN KEY,
    author VARCHAR(255) NOT NULL,
    upload_timestamp TIMESTAMP NOT NULL,
    content VARCHAR(255) NOT NULL
);