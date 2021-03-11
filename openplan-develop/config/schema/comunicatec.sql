CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    parent_id INT NULL,
    lft INT,
    rght INT,
    name VARCHAR(255),
    category_type INT,
    created DATETIME,
    modified DATETIME
);

CREATE TABLE fields (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    type VARCHAR(255),
    created DATETIME,
    modified DATETIME
);

CREATE TABLE rooms (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    user_id INT NOT NULL,
    created DATETIME,
    modified DATETIME
    #FOREIGN KEY user_key (user_id) REFERENCES users(id)
); 
ALTER TABLE `rooms` ADD KEY `user_key` (`user_id`);

CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    created DATETIME,
    modified DATETIME
); 

CREATE TABLE companies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    created DATETIME,
    modified DATETIME
); 

CREATE TABLE departaments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    company_id INT NOT NULL,
    created DATETIME,
    modified DATETIME
   # FOREIGN KEY company_key (company_id) REFERENCES companies(id)
);
ALTER TABLE `departaments` ADD KEY `company_key` (`company_id`);

CREATE TABLE filters (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    user_id INT NOT NULL,
    query VARCHAR(255),
    created DATETIME,
    modified DATETIME
    #FOREIGN KEY user_key (user_id) REFERENCES users(id)
); 
ALTER TABLE `filters` ADD KEY `user_key` (`user_id`);

CREATE TABLE items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    user_id INT NOT NULL,
    company_id INT NOT NULL,
    category_id INT NOT NULL,
    room_id INT NOT NULL,
    created DATETIME,
    modified DATETIME
    /*FOREIGN KEY user_key (user_id) REFERENCES users(id),
    FOREIGN KEY company_key (company_id) REFERENCES companies(id),
    FOREIGN KEY category_key (category_id) REFERENCES categories(id),
    FOREIGN KEY room_key (room_id) REFERENCES rooms(id)*/
);
ALTER TABLE `items` ADD KEY `user_key` (`user_id`);
ALTER TABLE `items` ADD KEY `company_key` (`company_id`);
ALTER TABLE `items` ADD KEY `category_key` (`category_id`);
ALTER TABLE `items` ADD KEY `room_key` (`room_id`);

CREATE TABLE categories_fields (
    category_id INT NOT NULL,
    field_id INT NOT NULL,
    notes_active INT NOT NULL DEFAULT 0,
    required INT NOT NULL DEFAULT 0,
    created DATETIME,
    modified DATETIME,
    PRIMARY KEY (category_id, field_id)/*,
    FOREIGN KEY field_key(field_id) REFERENCES fields(id),
    FOREIGN KEY category_key(category_id) REFERENCES categories(id)*/
);
ALTER TABLE `categories_fields` ADD KEY `field_key` (`field_id`);
ALTER TABLE `categories_fields` ADD KEY `category_key` (`category_id`);

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

CREATE TABLE departaments_users (
    departament_id INT NOT NULL,
    user_id INT NOT NULL,
    created DATETIME,
    modified DATETIME,
    PRIMARY KEY (departament_id, user_id)/*,
    FOREIGN KEY user_key(user_id) REFERENCES users(id),
    FOREIGN KEY departament_key(departament_id) REFERENCES departaments(id)*/
);
ALTER TABLE `departaments_users` ADD KEY `user_key` (`user_id`);
ALTER TABLE `departaments_users` ADD KEY `departament_key` (`departament_id`);

CREATE TABLE invitations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    item_id INT NOT NULL,
    role_id INT NOT NULL,
    url text,
    message text,
    created DATETIME,
    modified DATETIME/*,
    FOREIGN KEY user_key (user_id) REFERENCES users(id),
    FOREIGN KEY user_invite_key (user_invite_id) REFERENCES users(id),
    FOREIGN KEY item_key (item_id) REFERENCES items(id),
    FOREIGN KEY role_key (role_id) REFERENCES roles(id)*/
); 
ALTER TABLE `invitations` ADD KEY `user_key` (`user_id`);
ALTER TABLE `invitations` ADD KEY `item_key` (`item_id`);
ALTER TABLE `invitations` ADD KEY `role_key` (`role_id`);

CREATE TABLE invitations_users (
    invitation_id INT NOT NULL,
    user_id INT NOT NULL,
    created DATETIME,
    modified DATETIME,
    PRIMARY KEY (invitation_id, user_id)/*,
    FOREIGN KEY user_key(user_id) REFERENCES users(id),
    FOREIGN KEY departament_key(departament_id) REFERENCES departaments(id)*/
);
ALTER TABLE `invitations_users` ADD KEY `user_key` (`user_id`);
ALTER TABLE `invitations_users` ADD KEY `departament_key` (`invitation_id`);

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