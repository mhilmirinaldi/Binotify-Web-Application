CREATE TABLE User(
    user_id INTEGER AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(256) NOT NULL,
    password VARCHAR(256) NOT NULL,
    username VARCHAR(256) NOT NULL,
    isAdmin BOOLEAN NOT NULL
);

CREATE TABLE Album(
    album_id INTEGER AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(64) NOT NULL,
    penyanyi VARCHAR(128) NOT NULL,
    total_duration INTEGER NOT NULL,
    image_path VARCHAR(256) NOT NULL,
    tanggal_terbit DATE NOT NULL,
    genre VARCHAR(64)
);

CREATE TABLE Song(
    song_id INTEGER AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(64) NOT NULL,
    penyanyi VARCHAR(128),
    tanggal_terbit DATE NOT NULL,
    genre VARCHAR(64),
    duration INTEGER NOT NULL,
    audio_path VARCHAR(256) NOT NULL,
    image_path VARCHAR(256),
    album_id INTEGER REFERENCES album(album_id)
);
