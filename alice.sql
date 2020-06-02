/* 
    ========== ALICE ===========

     - AMIKOM LEARNING CENTER -
    
    SQL Database ALICE For MySQL
          Copyrights 2019

    ============================
*/

-- Create Database
CREATE DATABASE IF NOT EXISTS db_alice;

-- Use Database
USE db_alice;

/*-- Create Table --*/
-- Role
CREATE TABLE tb_role
(
    role_id TINYINT NOT NULL PRIMARY KEY,
    role_name VARCHAR(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Course
CREATE TABLE tb_course
(
    course_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    course_name VARCHAR(255) NOT NULL UNIQUE,
    course_sks TINYINT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- User Account
CREATE TABLE tb_user
(
    user_id CHAR(10) NOT NULL PRIMARY KEY,
    user_email VARCHAR(255) NOT NULL UNIQUE,
    user_password CHAR(32) NOT NULL,
    user_name VARCHAR(255) NOT NULL,
    user_dob DATE NOT NULL,
    user_gender ENUM('Laki-laki','Perempuan') NOT NULL,
    user_role TINYINT NOT NULL,
    user_photo VARCHAR(255) DEFAULT 'avatar.png',
    user_exp INT DEFAULT 0,
    user_verified BOOLEAN DEFAULT 0,
    user_created DATETIME DEFAULT NOW(),
    FOREIGN KEY (user_role) REFERENCES tb_role(role_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Lecturer Profile
CREATE TABLE tb_lecturer_profile 
(
    profile_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    profile_user CHAR(10) NOT NULL,
    profile_address VARCHAR(255),
    profile_phone VARCHAR(13),
    profile_office VARCHAR(255),
    profile_blog VARCHAR(255),
    profile_about TEXT,
    profile_info TEXT,
    profile_status ENUM('Selo','Mengajar','Rapat','di Rumah'),
    FOREIGN KEY (profile_user) REFERENCES tb_user(user_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Class
CREATE TABLE tb_class (
    class_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    class_name VARCHAR(255) NOT NULL,
    class_course INT NOT NULL,
    class_desc TEXT,
    class_lecturer CHAR(10) NOT NULL,
    class_header VARCHAR(255) DEFAULT 'header_img_class.jpg',
    class_code CHAR(6) UNIQUE,
    class_suspended BOOLEAN DEFAULT 0,
    class_created DATETIME DEFAULT NOW(),
    FOREIGN KEY (class_course) REFERENCES tb_course(course_id),
    FOREIGN KEY (class_lecturer) REFERENCES tb_user(user_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE tb_class_member (
    class_id INT NOT NULL,
    user_id CHAR(10) NOT NULL,
    joined DATETIME DEFAULT NOW(),
    FOREIGN KEY (class_id) REFERENCES tb_class(class_id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES tb_user(user_id) ON DELETE CASCADE 
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE tb_class_post
(
    post_id BIGINT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    post_class_id INT NOT NULL,
    post_user CHAR(10) NOT NULL,
    post_subject VARCHAR(255) NOT NULL,
    post_content TEXT,
    post_attachment VARCHAR(255),
    post_attachment_link TEXT,
    post_is_material BOOLEAN DEFAULT 0,
    post_is_assignment BOOLEAN DEFAULT 0,
    post_date DATETIME DEFAULT NOW(),
    post_update DATETIME DEFAULT NOW(),
    post_due_date DATETIME,
    FOREIGN KEY (post_class_id) REFERENCES tb_class(class_id) ON DELETE CASCADE,
    FOREIGN KEY (post_user) REFERENCES tb_user(user_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE tb_class_comment
(
    comment_id BIGINT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    comment_post BIGINT NOT NULL,
    comment_user CHAR(10) NOT NULL,
    comment_content TEXT,
    comment_date DATETIME DEFAULT NOW(),
    FOREIGN KEY (comment_post) REFERENCE tb_user(user_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE tb_class_assignment
(
    assignment_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    assignment_class INT NOT NULL,
    assignment_post BIGINT NOT NULL,
    assignment_user CHAR(10) NOT NULL,
    assignment_comment TEXT,
    assignment_attachment VARCHAR(255),
    assignment_score INT DEFAULT 0,
    assignment_is_turned BOOLEAN DEFAULT 0,
    assignment_date DATETIME DEFAULT NOW(),
    FOREIGN KEY (assignment_class) REFERENCES tb_class(class_id) ON DELETE CASCADE,
    FOREIGN KEY (assignment_id) REFERENCES tb_class_post(post_id) ON DELETE CASCADE,
    FOREIGN KEY (assignment_user) REFERENCES tb_user(user_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Forum
CREATE TABLE tb_forum_post
(
    post_id BIGINT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    post_course INT NOT NULL,
    post_user CHAR(10) NOT NULL,
    post_subject VARCHAR(255) NOT NULL,
    post_content TEXT,
    post_view INT DEFAULT 0,
    post_like INT DEFAULT 0,
    post_dislike INT DEFAULT 0,
    post_date DATETIME DEFAULT NOW(),
    FOREIGN KEY (post_course) REFERENCES tb_course(course_id),
    FOREIGN KEY (post_user) REFERENCES tb_user(user_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE tb_forum_comment
(
    comment_id BIGINT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    comment_post BIGINT NOT NULL,
    comment_user CHAR(10) NOT NULL,
    comment_content TEXT,
    comment_like INT DEFAULT 0,
    comment_dislike INT DEFAULT 0,
    comment_date DATETIME DEFAULT NOW(),
    FOREIGN KEY (comment_post) REFERENCES tb_forum_post(post_id) ON DELETE CASCADE,
    FOREIGN KEY (comment_user) REFERENCES tb_user(user_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Material
CREATE TABLE tb_material
(
    material_id BIGINT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    material_course INT NOT NULL,
    material_user CHAR(10) NOT NULL,
    material_subject VARCHAR(255) NOT NULL,
    material_content TEXT,
    material_attachment VARCHAR(255),
    material_date DATETIME DEFAULT NOW(),
    FOREIGN KEY (material_course) REFERENCES tb_course(course_id),
    FOREIGN KEY (material_user) REFERENCES tb_user(user_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Downloaded material
CREATE TABLE tb_material_downloaded
(
    material_id BIGINT NOT NULL,
    material_user CHAR(10) NOT NULL,
    material_date DATETIME DEFAULT NOW(),
    FOREIGN KEY (material_id) REFERENCES tb_material(material_id) ON DELETE CASCADE,
    FOREIGN KEY (material_user) REFERENCES tb_user(user_id) ON DELETE CASCADE,
    UNIQUE KEY (material_id, material_user) 
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Notification
CREATE TABLE tb_notification
(
    notif_for_user CHAR(10) NOT NULL,
    notif_from_user CHAR(10) NOT NULL,
    notif_class_id INT,
    notif_class_post BIGINT,
    notif_forum_post BIGINT,
    notif_type ENUM('post','comment_forum','comment_class'),
    notif_status BOOLEAN DEFAULT 0,
    notif_date DATETIME DEFAULT NOW(),
    FOREIGN KEY (notif_for_user) REFERENCES tb_user(user_id) ON DELETE CASCADE,
    FOREIGN KEY (notif_from_user) REFERENCES tb_user(user_id) ON DELETE CASCADE,
    FOREIGN KEY (notif_class_id) REFERENCES tb_class(class_id) ON DELETE CASCADE,
    FOREIGN KEY (notif_class_post) REFERENCES tb_class_post(post_id) ON DELETE CASCADE,
    FOREIGN KEY (notif_forum_post) REFERENCES tb_forum_post(post_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- visitor
CREATE TABLE tb_visit
(
    visit_id CHAR(10),
    visit_date DATETIME DEFAULT NOW(),
    FOREIGN KEY (visit_id) REFERENCES tb_user(user_id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


/*-- Create Trigger --*/
-- Generate class code
DELIMITER //
CREATE TRIGGER tg_class_code 
BEFORE INSERT 
ON tb_class FOR EACH ROW
BEGIN 
    DECLARE code CHAR(6);
    DECLARE exist INT DEFAULT 1;
    DECLARE id INT;
    WHILE exist = 1 DO
        SET code = LEFT(UUID(), 6);
        SET exist = (SELECT COUNT(class_code) FROM tb_class WHERE class_code = code);
    END WHILE;
    SET NEW.class_code = code;
END//
DELIMITER ;

-- Generate lecturer profile
DELIMITER //
CREATE TRIGGER tg_generate_profile 
AFTER UPDATE 
ON tb_user FOR EACH ROW
BEGIN 
    DECLARE id CHAR(10);
    DECLARE role INT;
    DECLARE verify INT;
    DECLARE exist INT ;
    SET id = NEW.user_id;
    SET role = NEW.user_role;
    SET verify = NEW.user_verified;
    SET exist = (SELECT COUNT(*) FROM tb_lecturer_profile WHERE profile_user = id);
    IF EXIST = 0 THEN
        IF (role = 2 AND verify = 1) THEN
        INSERT INTO tb_lecturer_profile (profile_user, profile_status) VALUES (id, 'Selo');
        END IF;
    END IF;
    IF (role = 2 AND verify = 0) THEN
        DELETE FROM tb_lecturer_profile WHERE profile_user = id;
    END IF;
END//
DELIMITER ;

-- Notification class post
DELIMITER //
CREATE TRIGGER tg_notification_class_post
AFTER INSERT
ON tb_class_post FOR EACH ROW
BEGIN
    DECLARE class VARCHAR(255);
    DECLARE user CHAR(10);
    DECLARE roles INT;
    DECLARE lecturer CHAR(10);
    DECLARE finished INT DEFAULT 0;
    DECLARE curMember CURSOR FOR 
        SELECT user_id FROM tb_class_member WHERE class_id = NEW.post_class_id;
    DECLARE CONTINUE HANDLER FOR
        NOT FOUND SET finished = 1;
    SELECT class_lecturer INTO lecturer FROM tb_class WHERE class_id = NEW.post_class_id;
    SELECT user_role INTO roles FROM tb_user WHERE user_id = NEW.post_user;
    OPEN curMember;
    wloop:WHILE finished = 0 DO
        FETCH curMember INTO user;
        IF finished = 1 THEN 
            LEAVE wloop;
        END IF;
        IF NEW.post_user != user THEN
            INSERT INTO tb_notification (notif_for_user, notif_from_user, notif_class_id, notif_class_post, notif_type)
            VALUES (user, NEW.post_user, NEW.post_class_id, NEW.post_id, 'post');
        END IF;
    END WHILE wloop;
    SET finished = 0;
    IF roles = 3 THEN
        INSERT INTO tb_notification (notif_for_user, notif_from_user, notif_class_id, notif_class_post, notif_type)
        VALUES (lecturer, NEW.post_user, NEW.post_class_id, NEW.post_id, 'post');
    END IF;
    CLOSE curMember;
END//
DELIMITER ;

-- Notification class comment
DELIMITER //
CREATE TRIGGER tg_notification_class_comment
AFTER INSERT
ON tb_class_comment FOR EACH ROW
BEGIN
    DECLARE exist INT;
    DECLARE user CHAR(10);
    DECLARE cid INT;

    SELECT post_user, post_class_id INTO user, cid FROM tb_class_post JOIN tb_class_comment ON post_id = comment_post WHERE comment_id = NEW.comment_id;
    SELECT COUNT(*) INTO exist FROM tb_notification WHERE notif_from_user = NEW.comment_user AND notif_class_post = NEW.comment_post AND notif_type = 'comment_class';

    IF exist = 0 AND user != NEW.comment_user THEN
        INSERT INTO tb_notification (notif_for_user, notif_from_user, notif_class_post, notif_class_id, notif_type)
        VALUES (user, NEW.comment_user, NEW.comment_post, cid, 'comment_class');
    END IF;
    IF exist > 0 THEN 
        UPDATE tb_notification SET notif_date = NOW(), notif_status = 0 WHERE notif_from_user = NEW.comment_user AND notif_class_post = NEW.comment_post AND notif_type = 'comment_class';
    END IF;
END//
DELIMITER ;

-- Notification forum comment
DELIMITER //
CREATE TRIGGER tg_notification_forum_comment
AFTER INSERT
ON tb_forum_comment FOR EACH ROW
BEGIN
    DECLARE exist INT;
    DECLARE user CHAR(10);
    DECLARE cid INT;

    SELECT post_user INTO user FROM tb_forum_post JOIN tb_forum_comment ON post_id = comment_post WHERE comment_id = NEW.comment_id;
    SELECT COUNT(*) INTO exist FROM tb_notification WHERE notif_from_user = NEW.comment_user AND notif_forum_post = NEW.comment_post AND notif_type = 'comment_forum';

    IF exist = 0 AND user != NEW.comment_user THEN
        INSERT INTO tb_notification (notif_for_user, notif_from_user, notif_forum_post, notif_type)
        VALUES (user, NEW.comment_user, NEW.comment_post, 'comment_forum');
    END IF;
    IF exist > 0 THEN 
        UPDATE tb_notification SET notif_date = NOW(), notif_status = 0 WHERE notif_from_user = NEW.comment_user AND notif_forum_post = NEW.comment_post AND notif_type = 'comment_forum';
    END IF;
END//
DELIMITER ;

-- PROCEDURE
-- Add experience
DELIMITER //
CREATE PROCEDURE sp_exp 
(
    uid CHAR(10),
    exp INT
)
BEGIN
    UPDATE tb_user SET user_exp = user_exp + exp WHERE user_id = uid;
END//
DELIMITER ;

-- EXAMPLES
-- Dummy Roles
INSERT INTO tb_role (role_id, role_name) 
VALUES (1, 'Admin'), (2, 'Dosen'), (3, 'Mahasiswa');

-- Dummy Student
INSERT INTO tb_user (user_id, user_name, user_email, user_password, user_dob, user_gender, user_role)
VALUES ('17.11.1247', 'Rizky Nur Hidayatullah', 'rizky.25@students.amikom.ac.id', md5('12345'), '1998-01-25', 'Laki-laki', 3);

-- Dummy Lecturer
INSERT INTO tb_user (user_id, user_name, user_email, user_password, user_dob, user_gender, user_role)
VALUES ('0518037801', 'M. RUDYANTO ARIEF, S.T, M.T', 'rudy@amikom.ac.id', md5('12345'), '1978-03-18', 'Laki-laki', 2);

-- Dummy Course
INSERT INTO tb_course (course_name, course_sks)
VALUES ('Pemrograman Web Lanjut', 4);

-- Dummy Forum Post
INSERT INTO tb_forum_post (post_course, post_user, post_subject, post_content)
VALUES (1, '17.11.1247', 'Macam Framework', 'Apa saja framework yang bisa digunakan untuk frontend developer');

-- Dummy Forum Comment
INSERT INTO tb_forum_comment (comment_post, comment_user, comment_content)
VALUES (1, '0518037801', 'Contohnya antara lain: Bootstrap, Vue, React, Angular, Semantic UI dan masih banyak lagi');

-- Dummy Class
INSERT INTO tb_class (class_name, class_course, class_desc, class_lecturer)
VALUES ('PWL-03', 1, 'Ini kelas pwl', '0518037801');

-- Dummy Join A Class
INSERT INTO tb_class_member(class_id, user_id)
VALUES (1,'17.11.1247');

-- Dummy experience
CALL sp_exp ('17.11.1247',100)

-- Dummy material downloaded
INSERT INTO tb_material_downloaded (material_id, material_user)
VALUES (2, "17.11.1247") ON DUPLICATE KEY UPDATE material_date = CURRENT_TIMESTAMP
