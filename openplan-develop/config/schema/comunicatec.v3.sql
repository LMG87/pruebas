CREATE TABLE rooms (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    created DATETIME,
    modified DATETIME
    #FOREIGN KEY user_key (user_id) REFERENCES users(id)
); 

CREATE TABLE departaments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    room_id INT  NOT NULL,
    created DATETIME,
    modified DATETIME
    #FOREIGN KEY user_key (user_id) REFERENCES users(id)
); 
ALTER TABLE `departaments` ADD KEY `room_key` (`room_id`);

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    parent_id INT NULL,
    lft INT,
    rght INT,
    name VARCHAR(255),
    room_id INT  NOT NULL,
    created DATETIME,
    modified DATETIME
);
ALTER TABLE `categories` ADD KEY `room_key` (`room_id`);

CREATE TABLE type_items(
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    description TEXT,
    created DATETIME,
    modified DATETIME
);

CREATE TABLE items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    description TEXT,
    user_id INT NOT NULL,
    room_id INT NOT NULL,
    type_item_id INT NOT NULL,
    category_id INT NOT NULL,    
    created DATETIME,
    modified DATETIME
    /*FOREIGN KEY user_key (user_id) REFERENCES users(id),
    FOREIGN KEY company_key (company_id) REFERENCES companies(id),
    FOREIGN KEY category_key (category_id) REFERENCES categories(id),
    FOREIGN KEY room_key (room_id) REFERENCES rooms(id)*/
);
ALTER TABLE `items` ADD KEY `user_key` (`user_id`);
ALTER TABLE `items` ADD KEY `room_key` (`room_id`);
ALTER TABLE `items` ADD KEY `type_item_key` (`type_item_id`);
ALTER TABLE `items` ADD KEY `category_key` (`category_id`);


CREATE TABLE extra_fields (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    departament_id INT NOT NULL,
    created DATETIME,
    modified DATETIME
); 
ALTER TABLE `extra_field_users` ADD KEY `user_key` (`user_id`);
ALTER TABLE `extra_field_users` ADD KEY `departament_key` (`departament_id`);

CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    description TEXT,
    created DATETIME,
    modified DATETIME
); 

CREATE TABLE collaborators (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    user_email VARCHAR(255) NOT NULL,
    model VARCHAR(10),
    foreign_key INT NOT NULL,
    role_id INT NOT NULL,
    created DATETIME,
    modified DATETIME
); 
ALTER TABLE `collaborators` ADD KEY `user_key` (`user_id`);
ALTER TABLE `collaborators` ADD KEY `user_email_key` (`user_email`);
ALTER TABLE `collaborators` ADD KEY `foreign_key` (`foreign_key`);
ALTER TABLE `collaborators` ADD KEY `role_key` (`role_id`);

CREATE TABLE actions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    description TEXT,
    created DATETIME,
    modified DATETIME
); 

CREATE TABLE actions_items (
    action_id INT NOT NULL,
    user_id INT NOT NULL,
    item_id INT NOT NULL,
    created DATETIME,
    modified DATETIME,
    PRIMARY KEY (action_id, user_id, item_id)
); 
ALTER TABLE `actions_items` ADD KEY `action_key` (`action_id`);
ALTER TABLE `actions_items` ADD KEY `user_key` (`user_id`);
ALTER TABLE `actions_items` ADD KEY `item_key` (`item_id`);

CREATE TABLE relation_users (
    user_id INT NOT NULL,
    role_id INT NOT NULL,
    model VARCHAR(10),
    foreign_key INT NOT NULL,
    created DATETIME,
    modified DATETIME,
    PRIMARY KEY (user_id, role_id, foreign_key)
); 
ALTER TABLE `relation_users` ADD KEY `user_key` (`user_id`);
ALTER TABLE `relation_users` ADD KEY `role_key` (`role_id`);
ALTER TABLE `relation_users` ADD KEY `foreign_key` (`foreign_key`);




/* database example*/
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    created DATETIME,
    modified DATETIME
);

CREATE TABLE bookmarks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(50),
    description TEXT,
    url TEXT,
    created DATETIME,
    modified DATETIME,
    FOREIGN KEY user_key (user_id) REFERENCES users(id)
);

CREATE TABLE tags (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255),
    created DATETIME,
    modified DATETIME,
    UNIQUE KEY (title)
);

CREATE TABLE bookmarks_tags (
    bookmark_id INT NOT NULL,
    tag_id INT NOT NULL,
    PRIMARY KEY (bookmark_id, tag_id),
    FOREIGN KEY tag_key(tag_id) REFERENCES tags(id),
    FOREIGN KEY bookmark_key(bookmark_id) REFERENCES bookmarks(id)
);