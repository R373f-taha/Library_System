<?php
// index.php - صفحة عرض الكتب
require_once 'book.php';
require_once 'author.php';
$bookModel = new Book();
$authorModel=new author();

$books = $bookModel->getAll();
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📚 مكتبتي الذكية - متجر الكتب</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Cairo', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            min-height: 100vh;
            padding: 20px;
        }

        /* حاوية رئيسية */
        .container {
            max-width: 1400px;
            margin: 0 auto;
        }

        /* الهيدر مع تأثير زجاجي */
        .header {
            text-align: center;
            padding: 50px 20px;
            margin-bottom: 40px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 30px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        .header h1 {
            font-size: 3.5rem;
            color: white;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .header h1 i {
            margin-left: 15px;
        }

        .header p {
            font-size: 1.2rem;
            color: rgba(255, 255, 255, 0.9);
        }

        /* شريط الإجراءات */
        .actions-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
            flex-wrap: wrap;
            gap: 20px;
        }

        /* زر الإضافة */
        .btn-add {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
            border: none;
            padding: 14px 35px;
            border-radius: 50px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .btn-add:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
        }

        /* مربع البحث */
        .search-box {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border-radius: 50px;
            padding: 5px 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .search-box input {
            background: transparent;
            border: none;
            padding: 12px;
            width: 280px;
            color: white;
            font-size: 1rem;
            outline: none;
        }

        .search-box input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .search-box button {
            background: transparent;
            border: none;
            color: white;
            cursor: pointer;
            font-size: 1.2rem;
        }

        /* شبكة الكتب */
        .books-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 35px;
        }

        /* بطاقة الكتاب */
        .book-card {
            background: white;
            border-radius: 25px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
            animation: fadeInUp 0.6s ease;
        }

        .book-card:hover {
            transform: translateY(-12px);
            box-shadow: 0 25px 45px rgba(0, 0, 0, 0.3);
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* صورة الكتاب */
        .book-image {
            height: 280px;
            overflow: hidden;
            position: relative;
        }

        .book-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .book-card:hover .book-image img {
            transform: scale(1.1);
        }

        /* التصنيف */
        .book-category {
            position: absolute;
            top: 15px;
            right: 15px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 6px 18px;
            border-radius: 25px;
            font-size: 0.8rem;
            font-weight: 600;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }

        /* معلومات الكتاب */
        .book-info {
            padding: 25px;
        }

        .book-title {
            font-size: 1.4rem;
            font-weight: 800;
            color: #2d3748;
            margin-bottom: 10px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .book-author {
            color: #667eea;
            font-weight: 600;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .book-year {
            color: #a0aec0;
            font-size: 0.9rem;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* أزرار التحكم */
        .book-actions {
            display: flex;
            gap: 12px;
            margin-top: 15px;
        }

        .btn-edit, .btn-delete {
            flex: 1;
            padding: 10px;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-decoration: none;
            font-size: 0.9rem;
        }

        .btn-edit {
            background: linear-gradient(135deg, #4facfe, #00f2fe);
            color: white;
        }

        .btn-delete {
            background: linear-gradient(135deg, #fa709a, #fee140);
            color: white;
        }

        .btn-edit:hover, .btn-delete:hover {
            transform: scale(0.98);
            opacity: 0.9;
        }

        /* رسالة عدم وجود كتب */
        .no-books {
            text-align: center;
            padding: 80px 20px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 30px;
            color: white;
        }

        .no-books i {
            font-size: 4rem;
            margin-bottom: 20px;
        }

        .no-books h3 {
            font-size: 1.8rem;
            margin-bottom: 10px;
        }

        /* الفوتر */
        .footer {
            text-align: center;
            padding: 30px;
            margin-top: 50px;
            color: rgba(255, 255, 255, 0.7);
        }

        /* استجابة للشاشات الصغيرة */
        @media (max-width: 768px) {
            .header h1 {
                font-size: 2rem;
            }
            
            .books-grid {
                grid-template-columns: 1fr;
                gap: 25px;
            }
            
            .actions-bar {
                flex-direction: column;
            }
            
            .search-box input {
                width: 200px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>
                <i class="fas fa-book-open"></i>
                مكتبتي الذكية
            </h1>
            <p>اكتشف آلاف الكتب واستمتع بأجمل أوقات القراءة 📖</p>
        </div>

        <div class="actions-bar">
            <a href="create.php" class="btn-add">
                <i class="fas fa-plus-circle"></i>
                إضافة كتاب جديد
            </a>
            <div class="search-box">
                <input type="text" id="searchInput" placeholder="ابحث عن كتاب..." onkeyup="searchBooks()">
                <button><i class="fas fa-search"></i></button>
            </div>
        </div>

        <div class="books-grid" id="booksGrid">
            <?php if (empty($books) || (isset($books['result']) && $books['result'] === 'No books found')): ?>
                <div class="no-books">
                    <i class="fas fa-book"></i>
                    <h3>لا توجد كتب حالياً</h3>
                    <p>يمكنك إضافة أول كتاب من خلال الضغط على زر "إضافة كتاب جديد"</p>
                </div>
            <?php else: ?>
                <?php foreach ($books as $book): ?>
                    <?php $author=$authorModel->getAuthorById($book['author_id'])['data'][0];;?>
                    <div class="book-card" data-title="<?= htmlspecialchars($book['title']) ?>">
                        <div class="book-image">
                            <span class="book-category">
                                <i class="fas fa-tag"></i>
                                <?= htmlspecialchars($book['category_name'] ?? 'عام') ?>
                            </span>
                            <img src="<?= htmlspecialchars($book['image'] ?? 'https://picsum.photos/id/24/300/280') ?>" 
                                 alt="<?= htmlspecialchars($book['title']) ?>"
                                 onerror="this.src='https://picsum.photos/id/24/300/280'">
                        </div>
                        <div class="book-info">
                            <div class="book-title"><?= htmlspecialchars($book['title']) ?></div>
                            <div class="book-author">
                                <i class="fas fa-user-pen"></i>
                                <?= htmlspecialchars(empty($book['author_id']) ? 'مؤلف غير معروف':$author['first_name'].' '.$author['last_name']) ?>
                            </div>
                            <div class="book-year">
                                <i class="fas fa-calendar-alt"></i>
                                <?= htmlspecialchars($book['publish_year'] ?? 'غير محدد') ?>
                            </div>
                            <div class="book-actions">
                                <a href="edit.php?id=<?= $book['id'] ?>" class="btn-edit">
                                    <i class="fas fa-edit"></i>
                                    تعديل
                                </a>
                                <a href="delete.php?id=<?= $book['id'] ?>" class="btn-delete">
                                    <i class="fas fa-trash-alt"></i>
                                    حذف
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <div class="footer">
            <p><i class="fas fa-heart"></i> جميع الحقوق محفوظة © 2026 - مكتبتي الذكية</p>
        </div>
    </div>

    <script>
        function searchBooks() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const cards = document.querySelectorAll('.book-card');
            
            cards.forEach(card => {
                const title = card.getAttribute('data-title').toLowerCase();
                if (title.includes(searchTerm)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        }
    </script>
</body>
</html>