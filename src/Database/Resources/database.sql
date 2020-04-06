DROP TABLE IF EXISTS  exads_test;
DROP TABLE IF EXISTS  promotion_design;
DROP TABLE IF EXISTS  promotion_design_access;

CREATE TABLE exads_test (
            id INT AUTO_INCREMENT NOT NULL,
            name VARCHAR(255) NOT NULL,
            age INT NOT NULL,
            job_title VARCHAR(255) NOT NULL,
            PRIMARY KEY(id)
) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB;


CREATE TABLE promotion_design (
                                  id INT AUTO_INCREMENT NOT NULL,
                                  design_name VARCHAR(255) NOT NULL,
                                  split_percent INT NOT NULL,
                                  PRIMARY KEY(id)
) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB;

CREATE TABLE promotion_design_access (
                                  id INT AUTO_INCREMENT NOT NULL,
                                  promotion_design_id INT NOT NULL,
                                  ip VARCHAR(30) NOT NULL,
                                  created_at DATETIME NOT NULL DEFAULT NOW(),
                                  PRIMARY KEY(id),
                                  CONSTRAINT FK_DesignKey FOREIGN KEY (promotion_design_id) REFERENCES promotion_design(id)
) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB;

INSERT INTO promotion_design (design_name, split_percent) VALUES ('Design 1', 50);
INSERT INTO promotion_design (design_name, split_percent) VALUES ('Design 1', 25);
INSERT INTO promotion_design (design_name, split_percent) VALUES ('Design 1', 25);
