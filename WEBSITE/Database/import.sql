DROP DATABASE IF EXISTS `fazbear`;

CREATE DATABASE `fazbear`;

USE `fazbear`;

CREATE TABLE `vacancies` (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    job_title VARCHAR(150) NOT NULL,
    job_payment DECIMAL(10,2) NOT NULL DEFAULT 0,
    job_description TEXT NOT NULL,
    job_availability BOOLEAN NOT NULL DEFAULT 0
);

INSERT INTO `vacancies` (`job_title`, `job_payment`, `job_description`, `job_availability`) VALUES
('Night Guard', 4.00, 'You will be working a shift from 12:00am to 06:00am. You will monitor cameras, ensure the safety of equipment and animatronic characters.', true),
('Chef', 8.00, 'You will be working from 09:00am to 11:00pm. You will be preparing food and drinks for the visitors and staff.', false),
('Cashier', 6.00, 'You will be working from 09:00am to 11:00pm. You will be handling the cash register.', false),
('Mechanic', 10.00, 'You will be working from 09:00am to 11:00pm. You will be repairing the animatronic characters and equipment.', false);

CREATE TABLE `contact` (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name_form VARCHAR(150) NOT NULL,
    email_form VARCHAR(150) NOT NULL,
    phone_form VARCHAR(150) NOT NULL,
    message_form TEXT NOT NULL
);

INSERT INTO `contact` (`name_form`, `email_form`, `phone_form`, `message_form`) VALUES
('John Doe', 'john@doe.com', '+31 6 1234-5678', 'Lorem ipsum dolor sit amet consectetur adipisicing elit.');

CREATE TABLE `events` (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    event_title VARCHAR(150) NOT NULL,
    event_date DATE NOT NULL,
    event_time TIME NOT NULL,
    event_description TEXT NOT NULL
);

INSERT INTO `events` (`event_title`, `event_date`, `event_time`, `event_description`) VALUES
('Freddy Fazbear Pizzeria Grand Opening', '1973-01-01', '12:00:00', 'Come visit the Pizzeria at the grand opening, it will be a big party!');

CREATE TABLE `applications` (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    vacancy_id INT,
    applicant_name VARCHAR(255) NOT NULL,
    applicant_email VARCHAR(255) NOT NULL,
    motivation_letter TEXT NOT NULL,
    application_date DATE NOT NULL,
    FOREIGN KEY (vacancy_id) REFERENCES `vacancies`(id)
);

INSERT INTO `applications` (`vacancy_id`, `applicant_name`, `applicant_email`, `motivation_letter`, `application_date`) VALUES
(1, 'John Doe', 'john@doe.com', 'Lorem ipsum dolor sit amet consectetur adipisicing elit.', '2021-01-01');

CREATE TABLE `users` (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(150) NOT NULL,
    password VARCHAR(150) NOT NULL
);

INSERT INTO `users` (`username`, `password`) VALUES
('admin', '$2y$10$h5nkfKriCxF.RjdF98Q6COkjOt6YknNIxEDubpHz86QMIuvQfnMBe');