CREATE TABLE `genres` (
  `genreID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`genreID`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
INSERT INTO genres VALUES(1, "Pop");
INSERT INTO genres VALUES(2, "Metal");
INSERT INTO genres VALUES(3, "Rock");
INSERT INTO genres VALUES(4, "Hip Hop");
INSERT INTO genres VALUES(5, "Jazz");
INSERT INTO genres VALUES(6, "Folk");
CREATE TABLE `playlists` (
  `listID` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) NOT NULL,
  `is_public` tinyint(1) NOT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`listID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
INSERT INTO playlists VALUES(1, 1, 1, "My Playlist");
INSERT INTO playlists VALUES(2, 1, 0, "My Private List");
INSERT INTO playlists VALUES(3, 2, 1, "Public List");
CREATE TABLE `saved_songs` (
  `listID` int(11) NOT NULL,
  `songID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
INSERT INTO saved_songs VALUES(1, 4);
INSERT INTO saved_songs VALUES(1, 9);
INSERT INTO saved_songs VALUES(2, 3);
INSERT INTO saved_songs VALUES(2, 1);
CREATE TABLE `songs` (
  `songID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `artist` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `duration` int(11) NOT NULL,
  `genreID` int(11) NOT NULL,
  PRIMARY KEY (`songID`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
INSERT INTO songs VALUES(1, "First Song", "Unknown", 144, 1);
INSERT INTO songs VALUES(2, "Song name", "Artist-1", 264, 2);
INSERT INTO songs VALUES(3, "Rock Song 12", "The man", 372, 3);
INSERT INTO songs VALUES(4, "HipHopHipHop", "Lil-Unknown", 156, 4);
INSERT INTO songs VALUES(9, "$$$", "Lil-Unknown", 129, 4);
CREATE TABLE `users` (
  `userID` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `permissions` int(4) NOT NULL,
  PRIMARY KEY (`userID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
INSERT INTO users VALUES(1, "admin", "$2y$10$MAfS.bbuBpnbBJPvUoF6d.RxyklaqYyy/koAfV5vzTF5xhH0X6GpC", 1111);
