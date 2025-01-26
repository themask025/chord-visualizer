USE chord_visualizer_db;

CREATE TABLE IF NOT EXISTS versions(
    id INT AUTO_INCREMENT PRIMARY KEY,
    last_modified  DATETIME NOT NULL ,
    content JSON NOT NULL,
    song_id INT NOT NULL,
    creator_id INT NOT NULL,
    FOREIGN KEY (creator_id) REFERENCES users(id),
    FOREIGN KEY (song_id) REFERENCES  songs(id)

);