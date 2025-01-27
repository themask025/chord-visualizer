
USE chord_visualizer_db;
INSERT INTO users VALUES (1,"Pasko","Pasko1234");

INSERT INTO songs VALUES(1,"Cool song", "Cool perfermer");
INSERT INTO versions VALUES(1, NOW(), '{
    "key1": "value1",
    "key2": "value2",
    "key3": "value3"
}',1, 1);

INSERT INTO versions VALUES(2, NOW(),
                            LOAD_FILE('C:\\xampp\\htdocs\\chord-visualizer\\example-songs\\bad_to_the_bone.json'),1, 1);