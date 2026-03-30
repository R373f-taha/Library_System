<?php

require_once 'book.php';
require_once 'author.php';

$bookModel=new Book();

$authorModel=new author();

$id=isset($_GET['id'])?(int) $_GET['id'] :0;

$book=$bookModel->getBookById($id)['data'][0];

 $author=$authorModel->getAuthorById($book['author_id'])['data'][0];

if($_SERVER['REQUEST_METHOD'] === 'POST'){

$result=$bookModel->delete($id);

if($result['success']){

header('Location:index.php');
exit();
}
else {
    echo $result['message'];
}

}



?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>حذف كتاب - مكتبتي</title>
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .card {
            background: white;
            border-radius: 30px;
            padding: 50px;
            max-width: 500px;
            text-align: center;
            animation: fadeInUp 0.5s ease;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
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

        .warning-icon {
            font-size: 5rem;
            color: #f5576c;
            margin-bottom: 20px;
        }

        h2 {
            color: #2d3748;
            margin-bottom: 15px;
        }

        .book-details {
            background: #f7fafc;
            padding: 20px;
            border-radius: 20px;
            margin: 25px 0;
            text-align: right;
        }

        .book-details p {
            margin: 10px 0;
            color: #4a5568;
        }

        .book-details strong {
            color: #2d3748;
        }

        .warning-text {
            color: #c53030;
            margin-bottom: 25px;
            font-weight: 600;
        }

        .btn-group {
            display: flex;
            gap: 15px;
        }

        .btn-delete {
            flex: 1;
            background: linear-gradient(135deg, #fa709a, #fee140);
            color: white;
            border: none;
            padding: 14px;
            border-radius: 15px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-cancel {
            flex: 1;
            background: #f0f0f0;
            color: #4a5568;
            border: none;
            padding: 14px;
            border-radius: 15px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-delete:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(250, 112, 154, 0.4);
        }

        .btn-cancel:hover {
            background: #e2e8f0;
        }

        @media (max-width: 768px) {
            .card {
                padding: 30px;
            }
            
            .btn-group {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="warning-icon">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        <h2>هل أنت متأكد من الحذف؟</h2>
        <p class="warning-text">هذا الإجراء لا يمكن التراجع عنه!</p>
        
        <div class="book-details">
            <p><strong>📖 عنوان الكتاب:</strong> <?= htmlspecialchars($book['title'] ?? '') ?></p>
            <p><strong>✍️ المؤلف:</strong> <?= htmlspecialchars($author['first_name'].' '.$author['last_name'] ?? '') ?></p>
        </div>
        
        <form method="POST" action="">
            <div class="btn-group">
                <button type="submit" class="btn-delete">
                    <i class="fas fa-trash-alt"></i>
                    نعم، احذف الكتاب
                </button>
                <a href="index.php" class="btn-cancel">
                    <i class="fas fa-times"></i>
                    إلغاء
                </a>
            </div>
        </form>
    </div>
</body>
</html>