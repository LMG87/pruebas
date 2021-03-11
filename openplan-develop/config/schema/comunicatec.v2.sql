CREATE TABLE rooms (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    created DATETIME,
    modified DATETIME
    #FOREIGN KEY user_key (user_id) REFERENCES users(id)
); 

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    parent_id INT NULL,
    lft INT,
    rght INT,
    name VARCHAR(255),
    created DATETIME,
    modified DATETIME
);

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

CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    description TEXT,
    created DATETIME,
    modified DATETIME
); 

CREATE TABLE actions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    description TEXT,
    created DATETIME,
    modified DATETIME
); 

CREATE TABLE collaborations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    user_email INT NOT NULL,
    type INT NOT NULL,
    object_id INT NOT NULL,
    created DATETIME,
    modified DATETIME
); 
ALTER TABLE `collaborations` ADD KEY `user_key` (`user_id`);
ALTER TABLE `collaborations` ADD KEY `user_email_key` (`user_email`);
ALTER TABLE `collaborations` ADD KEY `object_key` (`object_id`);

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

CREATE TABLE items_users (
    item_id INT NOT NULL,
    user_id INT NOT NULL,
    role_id INT NOT NULL,
    created DATETIME,
    modified DATETIME,
    PRIMARY KEY (item_id, user_id, role_id)
); 
ALTER TABLE `items_users` ADD KEY `item_key` (`item_id`);
ALTER TABLE `items_users` ADD KEY `user_key` (`user_id`);
ALTER TABLE `items_users` ADD KEY `role_key` (`role_id`);

CREATE TABLE rooms_users (
    room_id INT NOT NULL,
    user_id INT NOT NULL,
    role_id INT NOT NULL,
    created DATETIME,
    modified DATETIME,
    PRIMARY KEY (room_id, user_id, role_id)
); 
ALTER TABLE `rooms_users` ADD KEY `room_key` (`room_id`);
ALTER TABLE `rooms_users` ADD KEY `user_key` (`user_id`);
ALTER TABLE `rooms_users` ADD KEY `role_key` (`role_id`);

CREATE TABLE categories_users (
    category_id INT NOT NULL,
    user_id INT NOT NULL,
    role_id INT NOT NULL,
    created DATETIME,
    modified DATETIME,
    PRIMARY KEY (category_id, user_id, role_id)
); 
ALTER TABLE `categories_users` ADD KEY `category_key` (`category_id`);
ALTER TABLE `categories_users` ADD KEY `user_key` (`user_id`);
ALTER TABLE `categories_users` ADD KEY `role_key` (`role_id`);

CREATE TABLE rooms_roles_users (
    user_id INT NOT NULL,
    room_id INT NOT NULL,
    role_id INT NOT NULL,
    created DATETIME,
    modified DATETIME,
    PRIMARY KEY (user_id, room_id, role_id)/*,
    FOREIGN KEY user_key(user_id) REFERENCES users(id),
    FOREIGN KEY room_key(room_id) REFERENCES rooms(id),
    FOREIGN KEY role_key(role_id) REFERENCES roles(id)*/
);
ALTER TABLE `rooms_roles_users` ADD KEY `user_key` (`user_id`);
ALTER TABLE `rooms_roles_users` ADD KEY `room_key` (`room_id`);
ALTER TABLE `rooms_roles_users` ADD KEY `role_key` (`role_id`);



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