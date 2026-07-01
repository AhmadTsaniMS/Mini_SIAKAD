-- 01_create_user_db.sql
CREATE DATABASE IF NOT EXISTS siakad_lite
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

CREATE USER IF NOT EXISTS 'siakad_user'@'%' IDENTIFIED BY 'siakad_pass';
GRANT ALL PRIVILEGES ON siakad_lite.* TO 'siakad_user'@'%';
FLUSH PRIVILEGES;
