
DROP DATABASE IF EXISTS chord_visualizer_db;
CREATE DATABASE chord_visualizer_db;

USE chord_visualizer_db;

CREATE TABLE IF NOT EXISTS songs(
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    performer VARCHAR(255) NOT NULL
    );


CREATE TABLE IF NOT EXISTS users(
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) UNIQUE NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL
    );

CREATE TABLE IF NOT EXISTS versions(
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    content JSON NOT NULL,
    song_id INT NOT NULL,
    creator_id INT NOT NULL,
    FOREIGN KEY (creator_id) REFERENCES users(id),
    FOREIGN KEY (song_id) REFERENCES  songs(id)

    );

CREATE TABLE IF NOT EXISTS comments(
    id INT AUTO_INCREMENT PRIMARY KEY,
    song_version_id INT NOT NULL,
    author_id INT NOT NULL,
    upload_timestamp TIMESTAMP NOT NULL,
    content VARCHAR(255) NOT NULL,
    FOREIGN KEY (song_version_id) REFERENCES versions(id),
    FOREIGN KEY (author_id) REFERENCES users(id)
    );