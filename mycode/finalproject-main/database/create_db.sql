
USE `finalproject`;

CREATE TABLE `users` (
	`pseudo` VARCHAR(60) UNIQUE NOT NULL PRIMARY KEY,
	`first_name` VARCHAR(60) NOT NULL,
	`last_name` VARCHAR(100) NOT NULL,
	`phone` VARCHAR(10) NOT NULL,
	`address` VARCHAR(255) NOT NULL,
	`city` VARCHAR(100) NOT NULL,
	`country` VARCHAR(70) NOT NULL,
	`postal_code` VARCHAR(5) NOT NULL,
	`email` VARCHAR(255) UNIQUE NOT NULL,
	`password` VARCHAR(255) NOT NULL,
	`is_admin` BOOLEAN DEFAULT false,
	`created_at` DATETIME DEFAULT NOW(),
	`updated_at` DATETIME
);

CREATE TABLE `categories` (
	`id` INTEGER AUTO_INCREMENT PRIMARY KEY,
	`name` VARCHAR(150) UNIQUE NOT NULL,
	`created_at` DATETIME DEFAULT NOW(),
	`updated_at` DATETIME
);

CREATE TABLE `posts` (
	`id` INTEGER AUTO_INCREMENT PRIMARY KEY,
    `content` TEXT NOT NULL,
	`image_url` TEXT,
	`title` TEXT NOT NULL,
	`user` VARCHAR(60) NOT NULL REFERENCES `users`(`pseudo`) ON DELETE CASCADE ON UPDATE CASCADE,
	`category_id` INTEGER NOT NULL, 
	FOREIGN KEY (`category_id`) REFERENCES `categories`(`id`),
	`created_at` DATETIME DEFAULT NOW(),
	`updated_at` DATETIME
);

CREATE TABLE `comments` (
	`id` INTEGER AUTO_INCREMENT PRIMARY KEY,
    `content` TEXT NOT NULL,
	`user` VARCHAR(60) NOT NULL REFERENCES `users`(`pseudo`) ON DELETE CASCADE ON UPDATE CASCADE,
	`post_id` INTEGER NOT NULL REFERENCES `posts`(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
	`created_at` DATETIME DEFAULT NOW(),
);

INSERT INTO `users` (
        `pseudo`,
        `first_name`,
        `last_name`,
        `phone`,
        `address`,
        `city`,
        `country`,
        `postal_code`,
        `email`,
        `password`,
        `is_admin`
	)

VALUES ('testeur',
        'John',
		'Doe',
		'0123456789',
		'4 rue du test',
		'testville',
		'testpays',
		'75001',
		'test@test.com',
		'$2y$14$MvQ8WCwDVeJbr36FUzP32.dn6hWOVVVR6rbe8mNX9NiFsr9WDFAeW',
		TRUE
	);

INSERT INTO `categories` (`name`)
VALUES ('HTML'),
	('CSS'),
	('JAVASCRIPT'),
	('PHP'),
    ('AUTRES');

