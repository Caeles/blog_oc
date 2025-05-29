CREATE TABLE role (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    value       VARCHAR(50) NOT NULL UNIQUE
);

CREATE TABLE status (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    value       VARCHAR(50) NOT NULL UNIQUE
);

CREATE TABLE comment_status (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    value       VARCHAR(50) NOT NULL UNIQUE
);


CREATE TABLE user (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    nom             VARCHAR(100) NOT NULL,
    prenom          VARCHAR(100) NOT NULL,
    email           VARCHAR(255) NOT NULL UNIQUE,
    mot_de_passe    VARCHAR(255) NOT NULL,
    telephone       VARCHAR(30),
    role_id         INT NOT NULL,
    status_id       INT NOT NULL,
    CONSTRAINT fk_user_role
        FOREIGN KEY (role_id)  REFERENCES role(id)
        ON UPDATE CASCADE ON DELETE RESTRICT,
    CONSTRAINT fk_user_status
        FOREIGN KEY (status_id) REFERENCES status(id)
        ON UPDATE CASCADE ON DELETE RESTRICT
);


CREATE TABLE article (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    author_id       INT NOT NULL,           
    title           VARCHAR(255) NOT NULL,
    chapo           VARCHAR(512),
    image           VARCHAR(255),
    description     TEXT,
    created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
                    ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_article_author
        FOREIGN KEY (author_id) REFERENCES user(id)
        ON UPDATE CASCADE ON DELETE CASCADE
);


CREATE TABLE comment (
    id                  INT AUTO_INCREMENT PRIMARY KEY,
    user_id             INT NOT NULL,         
    article_id          INT NOT NULL,        
    status_id           INT NOT NULL,          
    contenu             TEXT NOT NULL,
    created_at          DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_comment_user
        FOREIGN KEY (user_id)    REFERENCES user(id)
        ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT fk_comment_article
        FOREIGN KEY (article_id) REFERENCES article(id)
        ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT fk_comment_status
        FOREIGN KEY (status_id)  REFERENCES comment_status(id)
        ON UPDATE CASCADE ON DELETE RESTRICT
);


CREATE INDEX idx_article_created   ON article(created_at);
CREATE INDEX idx_comment_created   ON comment(created_at);
CREATE TABLE category (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    name         VARCHAR(100) NOT NULL UNIQUE,       
    slug         VARCHAR(120) NOT NULL UNIQUE,       
    description  VARCHAR(255),                       
    created_at   DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE article_category (
    article_id   INT NOT NULL,
    category_id  INT NOT NULL,
    PRIMARY KEY (article_id, category_id),

    CONSTRAINT fk_ac_article
        FOREIGN KEY (article_id)
        REFERENCES article(id)
        ON UPDATE CASCADE
        ON DELETE CASCADE,

    CONSTRAINT fk_ac_category
        FOREIGN KEY (category_id)
        REFERENCES category(id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT     
);


