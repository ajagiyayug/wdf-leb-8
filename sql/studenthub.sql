CREATE DATABASE IF NOT EXISTS studenthub;
USE studenthub;

-- 1. Students Table
CREATE TABLE IF NOT EXISTS students (
    student_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    course VARCHAR(50) NOT NULL
);

-- 2. Events Table
CREATE TABLE IF NOT EXISTS events (
    event_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    event_date DATE NOT NULL,
    location VARCHAR(100) NOT NULL
);

-- 3. Registrations Table
CREATE TABLE IF NOT EXISTS registrations (
    registration_id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    event_id INT NOT NULL,
    registered_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES students(student_id) ON DELETE CASCADE,
    FOREIGN KEY (event_id) REFERENCES events(event_id) ON DELETE CASCADE
);

-- Stored Procedure (Advanced Extension requirement)
DELIMITER //
CREATE PROCEDURE RegisterStudent(IN p_student_id INT, IN p_event_id INT)
BEGIN
    INSERT INTO registrations (student_id, event_id) VALUES (p_student_id, p_event_id);
END //
DELIMITER ;