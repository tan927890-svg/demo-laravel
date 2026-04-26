CREATE DATABASE IF NOT EXISTS dealership CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE dealership;

CREATE TABLE IF NOT EXISTS vehicles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    make VARCHAR(50) NOT NULL,
    model VARCHAR(50) NOT NULL,
    version VARCHAR(100),
    year INT NOT NULL,
    color VARCHAR(50),
    mileage INT DEFAULT 0,
    price DECIMAL(15, 0) NOT NULL,
    state VARCHAR(20) NOT NULL,
    availability VARCHAR(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO vehicles (make, model, version, year, color, mileage, price, state, availability) VALUES
('Toyota', 'Camry', '2.5Q', 2023, 'Đen', 0, 1445000000, 'Xe mới', 'Còn hàng'),
('Toyota', 'Vios', '1.5G CVT', 2023, 'Trắng', 0, 548000000, 'Xe mới', 'Còn hàng'),
('Honda', 'CR-V', 'L', 2023, 'Bạc', 0, 1109000000, 'Xe mới', 'Còn hàng'),
('Honda', 'City', 'RS', 2022, 'Đỏ', 15000, 599000000, 'Xe cũ', 'Còn hàng'),
('Hyundai', 'Tucson', '2.0 Đặc biệt', 2023, 'Xanh', 0, 799000000, 'Xe mới', 'Còn hàng'),
('Kia', 'K3', '1.6 Luxury', 2022, 'Trắng', 20000, 539000000, 'Xe cũ', 'Còn hàng'),
('Mazda', 'CX-5', '2.0 Premium', 2023, 'Đỏ', 0, 899000000, 'Xe mới', 'Còn hàng'),
('Ford', 'Ranger', 'Wildtrak', 2022, 'Bạc', 30000, 769000000, 'Xe cũ', 'Còn hàng'),
('VinFast', 'VF8', 'Plus', 2023, 'Trắng', 0, 1090000000, 'Xe mới', 'Còn hàng'),
('VinFast', 'VF5', 'Plus', 2023, 'Xanh', 0, 458000000, 'Xe mới', 'Còn hàng'),
('Mitsubishi', 'Xpander', '1.5 AT', 2023, 'Đen', 0, 668000000, 'Xe mới', 'Còn hàng'),
('Suzuki', 'Ertiga', '1.5 AT', 2022, 'Bạc', 18000, 479000000, 'Xe cũ', 'Còn hàng');
