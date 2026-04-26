CREATE DATABASE IF NOT EXISTS menshubprime;
USE menshubprime;

-- 1. admin
CREATE TABLE IF NOT EXISTS admin (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(255) NOT NULL,
  password VARCHAR(255) NOT NULL
);

-- Insert default admin: admin / admin123
INSERT INTO admin (username, password) VALUES ('admin', 'admin123');

-- 2. blogs
CREATE TABLE IF NOT EXISTS blogs (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  image VARCHAR(255) NOT NULL,
  content TEXT NOT NULL,
  date DATE NOT NULL,
  slug VARCHAR(255) DEFAULT NULL
);

-- 3. blog_products
CREATE TABLE IF NOT EXISTS blog_products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  blog_id INT NOT NULL,
  product_title VARCHAR(255) NOT NULL,
  product_image VARCHAR(255) NOT NULL,
  product_description TEXT NOT NULL,
  affiliate_link VARCHAR(255) NOT NULL,
  product_order INT NOT NULL
);

-- 4. products
CREATE TABLE IF NOT EXISTS products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  price VARCHAR(255) NOT NULL,
  category VARCHAR(255) NOT NULL,
  affiliate_link VARCHAR(255) NOT NULL,
  image VARCHAR(255) NOT NULL,
  slug VARCHAR(255) DEFAULT NULL
);

-- 5. categories
CREATE TABLE IF NOT EXISTS categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  slug VARCHAR(255) NOT NULL,
  image VARCHAR(255) NOT NULL
);

-- 6. deals
CREATE TABLE IF NOT EXISTS deals (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  price VARCHAR(255) NOT NULL,
  old_price VARCHAR(255),
  product_id INT NOT NULL,
  image VARCHAR(255) NOT NULL
);

-- 7. mini_products
CREATE TABLE IF NOT EXISTS mini_products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  image VARCHAR(255) NOT NULL,
  title VARCHAR(255) NOT NULL,
  price VARCHAR(255) NOT NULL,
  link VARCHAR(255) NOT NULL
);

-- 8. videos
CREATE TABLE IF NOT EXISTS videos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  description TEXT NOT NULL,
  pros TEXT NOT NULL,
  cons TEXT NOT NULL,
  video_link VARCHAR(255) NOT NULL,
  thumb VARCHAR(255) NOT NULL,
  buy_link VARCHAR(255) NOT NULL,
  status INT NOT NULL DEFAULT 1,
  slug VARCHAR(255) DEFAULT NULL
);

-- 9. digital_products
CREATE TABLE IF NOT EXISTS digital_products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  description TEXT NOT NULL,
  features TEXT NOT NULL,
  what_you_get TEXT NOT NULL,
  image VARCHAR(255) NOT NULL,
  price VARCHAR(255) NOT NULL,
  product_link VARCHAR(255) NOT NULL,
  status VARCHAR(20) NOT NULL,
  slug VARCHAR(255) DEFAULT NULL
);

-- 10. sponsors
CREATE TABLE IF NOT EXISTS sponsors (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  link VARCHAR(255) NOT NULL,
  image VARCHAR(255) NOT NULL,
  position VARCHAR(50) NOT NULL,
  status VARCHAR(20) NOT NULL
);

-- 11. messages
CREATE TABLE IF NOT EXISTS messages (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL,
  message TEXT NOT NULL,
  date DATE NOT NULL
);

-- 12. subscribers
CREATE TABLE IF NOT EXISTS subscribers (
  id INT AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(255) NOT NULL,
  date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 13. app_subscribers
CREATE TABLE IF NOT EXISTS app_subscribers (
  id INT AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 14. collaborations
CREATE TABLE IF NOT EXISTS collaborations (
  id INT AUTO_INCREMENT PRIMARY KEY,
  brand_name VARCHAR(255) NOT NULL,
  your_name VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL,
  product_link VARCHAR(255) NOT NULL,
  message TEXT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 15. seo_pages
CREATE TABLE IF NOT EXISTS seo_pages (
  id INT AUTO_INCREMENT PRIMARY KEY,
  page_name VARCHAR(255) NOT NULL,
  meta_title VARCHAR(255) NOT NULL,
  meta_description TEXT NOT NULL,
  meta_keywords TEXT NOT NULL
);
