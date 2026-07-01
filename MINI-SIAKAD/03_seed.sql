-- 03_seed.sql
USE siakad_lite;

SET FOREIGN_KEY_CHECKS = 0;

TRUNCATE TABLE grades;
TRUNCATE TABLE attachments;
TRUNCATE TABLE notes;
TRUNCATE TABLE courses;
TRUNCATE TABLE students;

SET FOREIGN_KEY_CHECKS = 1;

INSERT INTO students(nim, name, email, phone) VALUES
('001','Ana','ana@x.com','08123400001'),
('002','Budi','budi@pens.ac.id','08123400002'),
('003','Cici','cici@x.com','08123400003');

INSERT INTO courses(code, name, sks) VALUES
('WEB101','Pemrograman Web',2),
('DB101','Basis Data',3);

INSERT INTO grades(student_id, course_id, score, letter)
SELECT s.id, c.id, 72, 'AB' FROM students s, courses c
WHERE s.nim='002' AND c.code='WEB101';

INSERT INTO grades(student_id, course_id, score, letter)
SELECT s.id, c.id, 85, 'A' FROM students s, courses c
WHERE s.nim='002' AND c.code='DB101';

INSERT INTO notes(student_id, title, content)
SELECT s.id, 'Follow up', 'Follow up tugas minggu 4' FROM students s WHERE s.nim='002';
