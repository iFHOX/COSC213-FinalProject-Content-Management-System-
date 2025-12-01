-- Users table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    username VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Posts table
CREATE TABLE posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    image VARCHAR(500),
    content TEXT NOT NULL,
    date DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Comments table
CREATE TABLE comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    post_id INT NOT NULL,
    username VARCHAR(100) NOT NULL,
    comment TEXT NOT NULL,
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE
);

-- admin user
-- Password: admin123 (hashed with password_hash)
INSERT INTO users (email, password, username) VALUES 
('admin@hiking.com', '$2y$10$gev0oZRxe.f9aqNWwkXZT.Y.AuFyWjot.c.XgWCt3TQ319iMPKQmy', 'Admin');

-- Sample posts
INSERT INTO posts (user_id, title, image, content, date) VALUES
(1, 'Mount Knox Trail', 'https://mediaim.expedia.com/destination/2/b1071ce2895d16c8666baf72dba3ef69.jpg', 'Knox Mountain Park offers a variety of trails for both hikers and mountain bikers, with popular routes including the Apex Trail for a steep climb to the summit with panoramic views and the Paul''s Tomb Trail leading to a scenic lakeside cove. Other options include the easier Kathleen Lake Loop, the difficult Lochview Trail, and a network of mountain bike-specific trails, which are detailed on the Trailforks map!', '2025-10-23'),
(1, 'Crawford Falls', 'https://assets.simpleviewinc.com/simpleview/image/upload/crm/kelowna/Crawford-Falls-e75b570c5056a36_e75b5af3-5056-a36a-0b913b098168c1f6.jpg', 'Just minutes from downtown Kelowna, Canyon Falls Park (also known as Crawford Falls) offers a rugged canyon escape featuring two waterfalls and a short but adventurous trail through dramatic terrain.', '2025-11-15'),
(1, 'Mill Creek Regional Park', 'https://assets.simpleviewinc.com/simpleview/image/upload/crm/kelowna/MILLCR-11_F1191E67-5056-A36A-0BC74D8D5ED7D517-f11908bf5056a36_f1192a42-5056-a36a-0b07d8206f524602.jpg', 'Tucked near Kelowna International Airport, Mill Creek Regional Park is a lush 13.5-hectare oasis where shaded forest trails follow the gentle flow of Mill Creek to a series of picturesque waterfalls. The park features one main route: Waterfall Trail (810 m, easy, 20 m gain): a forested out-and-back trail that crosses boardwalks and footbridges to reach three cascading waterfalls.', '2025-11-20');

-- Sample comments
INSERT INTO comments (post_id, username, comment) VALUES
(1, 'Shondel', 'Amazing trail! The sunrise was absolutely spectacular!'),
(1, 'Matthew', 'Definitely challenging but worth every step. Bring good hiking boots!'),
(2, 'Poojitha', 'Perfect spot for a family day out. Kids loved it!'),
(3, 'Lily', 'A sweet experience for a nice weekend outside. Would recommend it to anyone!'),
(3, 'Justin', 'One of the most beautiful views I have ever had');
