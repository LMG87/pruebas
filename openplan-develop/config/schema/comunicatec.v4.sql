CREATE TABLE companies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    created DATETIME,
    modified DATETIME
    #FOREIGN KEY user_key (user_id) REFERENCES users(id)
); 


CREATE TABLE rooms (
    id INT AUTO_INCREMENT PRIMARY KEY,
    parent_id INT NULL,
    lft INT,
    rght INT,
    name VARCHAR(255) NOT NULL,
    company_id INT  NOT NULL,
    created DATETIME,
    modified DATETIME
);
ALTER TABLE `rooms` ADD KEY `company_key` (`company_id`);

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
    room_id INT,
    type_item_id INT NOT NULL,
    company_id INT NOT NULL,    
    created DATETIME,
    modified DATETIME
);
ALTER TABLE `items` ADD KEY `user_key` (`user_id`);
ALTER TABLE `items` ADD KEY `room_key` (`room_id`);
ALTER TABLE `items` ADD KEY `type_item_key` (`type_item_id`);
ALTER TABLE `items` ADD KEY `company_key` (`company_id`);


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
    message text NOT NULL,
    model VARCHAR(10) NOT NULL,
    foreign_key INT NOT NULL,
    role_id INT NOT NULL,
    token char(150) NOT NULL,
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

CREATE TABLE relation_members (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    role_id INT NOT NULL,
    model VARCHAR(10)  NOT NULL,
    foreign_key INT NOT NULL,
    created DATETIME,
    modified DATETIME
); 
ALTER TABLE `relation_members` ADD KEY `user_key` (`user_id`);
ALTER TABLE `relation_members` ADD KEY `role_key` (`role_id`);


CREATE TABLE comments (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    parent_id INT NULL,
    lft INT,
    rght INT,
    user_id INT NOT NULL,
    item_id INT NOT NULL,
    message TEXT NOT NULL,
    created DATETIME NOT NULL,
    modified DATETIME NOT NULL
);
ALTER TABLE `comments` ADD KEY `user_key` (`user_id`);
ALTER TABLE `comments` ADD KEY `item_key` (`item_id`);


CREATE TABLE files (
    id int(11) NOT NULL AUTO_INCREMENT,
    name varchar(255) COLLATE utf8_unicode_ci NOT NULL,
    filename varchar(255) COLLATE utf8_unicode_ci NOT NULL,
    path varchar(255) COLLATE utf8_unicode_ci NOT NULL,
    size varchar(255) COLLATE utf8_unicode_ci NOT NULL,
    icon varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'fa-file-o',
    user_id INT NOT NULL,
    item_id INT NOT NULL,
    created datetime NOT NULL,
    modified datetime NOT NULL,
    status tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 = Active, 0 = Inactive',
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
ALTER TABLE `files` ADD KEY `user_key` (`user_id`);
ALTER TABLE `files` ADD KEY `item_key` (`item_id`);







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