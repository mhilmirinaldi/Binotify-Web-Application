INSERT INTO album(judul, penyanyi, total_duration, image_path, tanggal_terbit)
    VALUES ('Erika Album', 'Karl', 92, '/media/erika-album/erika-album.jpg', '2022-10-22');

INSERT INTO song(judul, penyanyi, tanggal_terbit, genre, duration, audio_path, image_path, album_id)
    VALUES('Erika', 'Karl', '2022-10-22', 'folk', 92, '/media/erika/erika.mp3', '/media/erika/image.jpg', 1);

DELIMITER $$
CREATE TRIGGER total_duration_delete AFTER DELETE ON song 
FOR EACH ROW 
BEGIN 
	UPDATE album 
    SET album.total_duration = album.total_duration - old.duration 
    WHERE album.album_id = old.album_id; 
END;$$
DELIMITER ;

DELIMITER $$
CREATE TRIGGER total_duration_insert AFTER INSERT ON song 
FOR EACH ROW 
BEGIN 
    UPDATE album 
    SET album.total_duration = album.total_duration + new.duration 
    WHERE album.album_id = new.album_id; 
END;$$
DELIMITER ;

DELIMITER $$
CREATE TRIGGER total_duration_update AFTER UPDATE ON song 
FOR EACH ROW 
BEGIN 
    UPDATE album 
    SET album.total_duration = album.total_duration + new.duration  - old.duration
    WHERE album.album_id = new.album_id; 
END;$$
DELIMITER ;