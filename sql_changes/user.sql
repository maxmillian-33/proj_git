ALTER TABLE users 
ADD COLUMN address VARCHAR(255) DEFAULT NULL,
ADD COLUMN dob DATE DEFAULT NULL,
ADD COLUMN age INT DEFAULT NULL,
ADD COLUMN aadhar_number VARCHAR(12) DEFAULT NULL,
ADD COLUMN roll_number VARCHAR(50) DEFAULT NULL;
