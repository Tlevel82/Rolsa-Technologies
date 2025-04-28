CREATE TABLE users (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL UNIQUE,
    last_name VARCHAR(50) NOT NULL,
    pwd VARCHAR(255) NOT NULL, 
    email VARCHAR(100) NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIME
    avatar VARCHAR(255) DEFAULT 'path/to/default-avatar.jpg';
);

CREATE TABLE carbon_footprint (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    electricity FLOAT NOT NULL,
    gas FLOAT NOT NULL,
    oil FLOAT NOT NULL,
    vehicle_miles FLOAT NOT NULL,
    short_rail INT NOT NULL,
    long_rail INT NOT NULL,
    short_flights INT NOT NULL,
    long_flights INT NOT NULL,
    power_heating_lighting FLOAT NOT NULL,
    transport FLOAT NOT NULL,
    total_carbon_footprint FLOAT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE energy_consumption (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    appliance VARCHAR(255) NOT NULL,
    power_consumption DOUBLE NOT NULL,
    hours_per_day DOUBLE NOT NULL,
    energy_consumption DOUBLE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE bookings (
    id INT AUTO_INCREMENT PRIMARY KEY, -- Unique booking ID
    user_id INT NOT NULL,              -- ID of the user who made the booking
    service_name VARCHAR(255) NOT NULL, -- Name of the service booked
    booking_date DATETIME NOT NULL,    -- Date and time of the booking
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Timestamp of when the booking was created
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE -- Link to the users table
);

CREATE TABLE consultations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    preferred_date DATE NOT NULL,
    preferred_time TIME NOT NULL,
    card_number VARBINARY(255) NOT NULL, -- Encrypted card number
    expiry_date VARBINARY(255) NOT NULL, -- Encrypted expiry date
    cvv VARBINARY(255) NOT NULL,         -- Encrypted CVV
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE installations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    preferred_date DATE NOT NULL,
    preferred_time TIME NOT NULL,
    card_number VARBINARY(255) NOT NULL,
    expiry_date VARBINARY(255) NOT NULL,
    cvv VARBINARY(255) NOT NULL,
    status ENUM('booked', 'canceled') DEFAULT 'booked',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE carbon_footprint (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    carbon_emitted FLOAT NOT NULL,
    date DATE NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);