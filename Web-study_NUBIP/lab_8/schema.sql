-- Создание базы данных (если еще не существует)
CREATE DATABASE IF NOT EXISTS hotel;
USE hotel;

-- Создание таблицы комнат
CREATE TABLE IF NOT EXISTS rooms (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    capacity INT,
    status ENUM('Ready', 'Dirty', 'Cleanup') DEFAULT 'Ready'
);

-- Создание таблицы бронирований
CREATE TABLE IF NOT EXISTS bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    room_id INT,
    guest_name VARCHAR(100),
    start_date DATE,
    end_date DATE,
    status ENUM('New', 'Confirmed', 'Checked out', 'Expired'),
    paid_percent INT,
    FOREIGN KEY (room_id) REFERENCES rooms(id)
);
