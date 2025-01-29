
USE chord_visualizer_db;
INSERT INTO users (username, email, password) VALUES ('t','ted@mail.com','t');
INSERT INTO users (username, email, password) VALUES ('test123',"test@gmail.com","Test123");

INSERT INTO songs(title, performer) VALUES ('test song', 'test performer');
INSERT INTO songs(title, performer) VALUES ('Beat it ','Michael Jackson');

INSERT INTO versions(name, content, song_id, creator_id) VALUES ('version 1', '{"bpm":"250","note_sequence":[{"B":0,"G":0,"D":0},{"G":0,"D":0},{"B":5,"G":5,"D":5},{"B":0,"G":0,"D":0},{"B":3,"G":3,"D":3},{"B":0,"G":0,"D":0},{},{}]}', 1, 1);
INSERT INTO versions(name, content, song_id, creator_id) VALUES ('version 2', '{"bpm":"250","note_sequence":[{"B":0,"G":0,"D":0},{"G":0,"D":2},{"B":5,"G":5,"D":5},{"B":0,"G":0,"D":0},{"B":3,"G":3,"D":3},{"B":0,"G":0,"D":0},{},{}]}', 1, 1);
INSERT INTO versions(name, content, song_id, creator_id) VALUES ('version 3', '{"bpm":"250","note_sequence":[{"B":0,"G":0,"D":0},{"G":0,"D":2},{"B":5,"G":5,"D":5},{"B":0,"G":0,"D":0},{"B":3,"G":3,"D":3},{"B":0,"G":0,"D":0},{},{}]}', 2, 1);

INSERT INTO comments(song_version_id, author_id, upload_timestamp, content) VALUES (1, 1, '2021-01-01 00:00:00', 'This is a comment');
INSERT INTO comments(song_version_id, author_id, upload_timestamp, content) VALUES (1, 1, '2021-01-01 00:00:00', 'This is a comment');
