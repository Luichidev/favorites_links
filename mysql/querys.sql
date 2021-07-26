CREATE DATABASE `favorites_db` DEFAULT CHARACTER
SET
`utf8mb4` COLLATE `utf8mb4_unicode_ci`;

CREATE TABLE `users`
(
`iduser` INT PRIMARY KEY AUTO_INCREMENT,
`use_name` VARCHAR
(50) NOT NULL,
`use_ts` DATETIME DEFAULT CURRENT_TIMESTAMP,
`use_email` VARCHAR
(100) NOT NULL UNIQUE,
`use_pass` VARCHAR
(100) NOT NULL,
`use_roll` INT
(50) NOT NULL
);

CREATE TABLE `favorites`
(`idfavorite` INT PRIMARY KEY AUTO_INCREMENT,
`fav_iduser` INT,
FOREIGN KEY
(`fav_iduser`) REFERENCES users
(`iduser`),
`fav_title` VARCHAR
(100) NOT NULL,
`fav_url` VARCHAR
(150) NOT NULL UNIQUE,
`fav_description` VARCHAR
(255) DEFAULT "",
`fav_isfavorite` TINYINT NOT NULL DEFAULT 0,
`fav_ts` DATETIME DEFAULT CURRENT_TIMESTAMP,
`fav_modificate` DATETIME DEFAULT CURRENT_TIMESTAMP ON
UPDATE CURRENT_TIMESTAMP
);

INSERT INTO users
  (use_name, use_email, use_pass, use_roll)
VALUES('admin', 'admin@llavero.es', '$2y$10$TCr410PpO22W8Z.OIpowIOdgxuUVNiwbb.ozdd9MyUZd9QZr1b3HS', 1);
-- admin123