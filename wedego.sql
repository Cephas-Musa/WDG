-- Active: 1726762287669@@127.0.0.1@3306
CREATE DATABASE wedego;

USE wedego;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') DEFAULT 'user',
    profile_image VARCHAR(255) DEFAULT 'default.png'
);

CREATE TABLE news (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    image VARCHAR(255) NOT NULL,
    video VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    likes INT DEFAULT 0
);

CREATE TABLE events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    date DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    news_id INT,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users (id),
    FOREIGN KEY (news_id) REFERENCES news (id)
);

CREATE TABLE reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    event_id INT,
    seats INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users (id),
    FOREIGN KEY (event_id) REFERENCES events (id)
);

CREATE TABLE gallery (
    id INT AUTO_INCREMENT PRIMARY KEY,
    filename VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE likes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    news_id INT NOT NULL,
    user_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE (news_id, user_id),
    FOREIGN KEY (news_id) REFERENCES news (id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS likes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    post_id INT NOT NULL,
    user_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE (post_id, user_id),
    FOREIGN KEY (post_id) REFERENCES news (id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE
);

SELECT
    n.id,
    n.title,
    n.image,
    COUNT(DISTINCT l.id) AS likes,
    GROUP_CONCAT(
        DISTINCT u.username SEPARATOR ', '
    ) AS liked_by,
    c.id AS comment_id,
    c.content AS comment_content,
    c.likes AS comment_likes,
    u2.username AS comment_username
FROM
    news n
    LEFT JOIN likes l ON n.id = l.news_id
    LEFT JOIN users u ON l.user_id = u.id
    LEFT JOIN comments c ON n.id = c.news_id
    LEFT JOIN users u2 ON c.user_id = u2.id
GROUP BY
    n.id,
    c.id
ORDER BY n.id DESC;

DROP TABLE likes;

ALTER TABLE comments ADD likes INT DEFAULT 0;

ALTER TABLE comments ADD post_id INT;

ALTER TABLE likes ADD news_id INT;

ALTER TABLE news ADD comments INT;

DESCRIBE users;

ALTER TABLE users DROP COLUMN profile_image;

ALTER TABLE users ADD COLUMN profi_image VARCHAR(255) NOT NULL;

ALTER TABLE gallery ADD COLUMN filename VARCHAR(255) NOT NULL

ALTER TABLE gallery ADD COLUMN image_title VARCHAR(100) NOT NULL

ALTER TABLE gallery ADD COLUMN description TEXT

ALTER TABLE gallery ADD COLUMN image_title VARCHAR(100) NOT NULL;

DESC gallery;

DESC users;

CREATE TABLE sorties (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    image VARCHAR(255),
    date_sortie DATE NOT NULL,
    auteur VARCHAR(100)
);

CREATE TABLE prix (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sortie_id INT,
    type_utilisateur ENUM('burundais', 'etranger'),
    montant DECIMAL(10, 2),
    FOREIGN KEY (sortie_id) REFERENCES sorties (id)
);

CREATE TABLE prix_global (
    id INT AUTO_INCREMENT PRIMARY KEY,
    burundais DECIMAL(10, 2) NOT NULL,
    etranger DECIMAL(10, 2) NOT NULL
);

DROP TABLE prix;

DROP TABLE prix_global;

CREATE TABLE prix (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sortie_id INT,
    type_utilisateur ENUM('burundais', 'etranger'),
    montant DECIMAL(10, 2),
    FOREIGN KEY (sortie_id) REFERENCES sorties (id) ON DELETE CASCADE
);


CREATE TABLE notifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    message VARCHAR(255) NOT NULL,
    is_read TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

DESC gallery;

ALTER TABLE gallery
ADD COLUMN section ENUM(
    'actualites',
    'sorties',
    'galerie'
) NOT NULL;


CREATE TABLE likes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    news_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE(user_id, news_id) 
);

ALTER TABLE likes ADD COLUMN liked VARCHAR(255);
