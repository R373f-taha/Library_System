
CREATE DATABASE IF NOT EXISTS library;
USE library;

-- جدول المؤلفين
CREATE TABLE authors (
    id INT PRIMARY KEY AUTO_INCREMENT,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    age INT,
    join_date DATE DEFAULT CURRENT_DATE
);

-- جدول الفئات
CREATE TABLE categories (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL UNIQUE,
    description TEXT
);

-- جدول الكتب
CREATE TABLE books (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(200) NOT NULL,
    author_id INT NOT NULL,
    category_id INT NOT NULL,
    publish_year YEAR,
    image VARCHAR(255),
    
    -- Foreign Key Constraints
    FOREIGN KEY (author_id) REFERENCES authors(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE RESTRICT ON UPDATE CASCADE
);

-- فهارس لتسريع الاستعلامات
CREATE INDEX idx_books_author ON books(author_id);
CREATE INDEX idx_books_category ON books(category_id);
CREATE INDEX idx_books_title ON books(title);
CREATE INDEX idx_authors_name ON authors(first_name, last_name);
CREATE INDEX idx_categories_name ON categories(name);


INSERT INTO authors (first_name, last_name, age, join_date) VALUES
('جبران', 'خليل جبران', 48, '2020-01-15'),
('نجيب', 'محفوظ', 94, '2019-03-20'),
('غسان', 'كنفاني', 36, '2021-06-10'),
('محمود', 'درويش', 67, '2018-11-05'),
('أحلام', 'مستغانمي', 70, '2022-02-28');

INSERT INTO categories (name, description) VALUES
('رواية', 'الأعمال الأدبية الطويلة التي تروي قصة'),
('فلسفة', 'كتب تتناول التفكير والمنطق والوجود'),
('تكنولوجيا', 'كتب عن البرمجة والذكاء الاصطناعي والتقنية'),
('شعر', 'الأعمال الشعرية العربية والعالمية'),
('تاريخ', 'كتب تروي أحداث التاريخ المختلفة');

INSERT INTO books (title, author_id, category_id, publish_year, image) VALUES
('الأجنحة المتكسرة', 1, 1, 1912, 'images/wings.jpg'),
('النبي', 1, 4, 1923, 'images/prophet.jpg'),
('الحرافيش', 2, 1, 1977, 'images/harafish.jpg'),
('أولاد حارتنا', 2, 1, 1959, 'images/children.jpg'),
('رجال في الشمس', 3, 1, 1963, 'images/men_sun.jpg'),
('أعمال محمود درويش', 4, 4, 2008, 'images/darwish.jpg'),
('ذاكرة الجسد', 5, 1, 1993, 'images/memory.jpg'),
('فوضى الحواس', 5, 1, 1997, 'images/chaos.jpg'),
('مقدمة في الخوارزميات', 5, 3, 2009, 'images/algorithms.jpg'),
('تاريخ الفلسفة', 2, 2, 2015, 'images/philosophy.jpg');
