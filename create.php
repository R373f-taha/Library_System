<?php 
require_once 'category.php';
require_once 'author.php';
require_once 'book.php';
$category=new category();
$categories=$category->getAll();
$author=new author();
$authors=$author->getAll();
$book=new Book();
$error='';
$message='';
if($_SERVER['REQUEST_METHOD']==='POST'){

if(isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK){

$uploadDir='images/';

if(!file_exists($uploadDir))

    mkdir($uploadDir,0777,true);

$fileExtention=pathinfo($_FILES['image']['name'],PATHINFO_EXTENSION);
$imageName=time().'_'.rand(1,100).$fileExtention;
$imageTmpName=$_FILES['image']['tmp_name'];
$destination=$uploadDir.$imageName;

$imagePath='';
if(move_uploaded_file($imageTmpName,$destination)){
var_dump('successfully uploaded');
$imagePath=$destination;}


else var_dump('failed uploaded');

}

$data=[
'title'=>htmlspecialchars($_POST['title'])??'',
'author_id'=>(int)($_POST['author_id'])??0,
'category_id'=>(int)($_POST['category_id'])??0,
'publish_year'=>$_POST['publish_year']??'',
'image'=>$imagePath


];

$book->create($data);

header('Location:index.php');
exit();
}



?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة كتاب جديد - مكتبتي</title>
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
            padding: 40px 20px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
        }

        .card {
            background: white;
            border-radius: 30px;
            padding: 40px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            animation: fadeInUp 0.5s ease;
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

        h1 {
            text-align: center;
            color: #2d3748;
            margin-bottom: 10px;
            font-size: 2rem;
        }

        .subtitle {
            text-align: center;
            color: #718096;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #2d3748;
        }

        label i {
            color: #667eea;
            margin-left: 8px;
        }

        input, select {
            width: 100%;
            padding: 14px;
            border: 2px solid #e2e8f0;
            border-radius: 15px;
            font-size: 1rem;
            transition: all 0.3s ease;
            font-family: 'Cairo', sans-serif;
        }

        input:focus, select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .btn-group {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }

        .btn-save {
            flex: 1;
            background: linear-gradient(135deg, #667eea, #764ba2);
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

        .btn-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
        }

        .btn-cancel:hover {
            background: #e2e8f0;
        }

        .error {
            background: #fed7d7;
            color: #c53030;
            padding: 12px;
            border-radius: 12px;
            margin-bottom: 20px;
            text-align: center;
        }

        @media (max-width: 768px) {
            .card {
                padding: 25px;
            }
            
            .btn-group {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <h1>
                <i class="fas fa-plus-circle" style="color: #667eea;"></i>
                إضافة كتاب جديد
            </h1>
            <p class="subtitle">أدخل معلومات الكتاب لإضافته إلى المكتبة</p>
            
            <?php if ($error): ?>
                <div class="error">
                     <i class="fas fa-exclamation-triangle"></i>
                    <php htmlspecialchars($error)
                     ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="" enctype="multipart/form-data">
                <div class="form-group">
                    <label><i class="fas fa-heading"></i> عنوان الكتاب</label>
                    <input type="text" name="title" required placeholder="مثال: أسس البرمجة">
                </div>
                
                
                  <div class="form-group">
                    <label><i class="fas fa-tag"></i>  اسم المؤلف </label>
                    <select name="author_id" required>
                        <option value="">اختر اسم المؤلف </option>
                        <?php foreach ($authors as $author): ?>
                            <option value="<?= $author['id'] ?>"><?= htmlspecialchars($author['first_name'].' '.$author['last_name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label><i class="fas fa-tag"></i> التصنيف</label>
                    <select name="category_id" required>
                        <option value="">اختر التصنيف</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category['id'] ?>"><?= htmlspecialchars($category['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label><i class="fas fa-calendar"></i> سنة النشر</label>
                    <input type="number" name="publish_year" placeholder="مثال: 2024">
                </div>
               <div class="form-group">
                    <label><i class="fas fa-image"></i> صورة الكتاب</label>
                    <input type="file" name="image" accept="image/jpeg,image/png,image/gif,image/webp">
                    <small style="color: #718096; display: block; margin-top: 5px;">
                        الصور المدعومة: JPG, PNG, GIF, WEBP
                    </small>
                </div>
                
                <div class="btn-group">
                    <button type="submit" class="btn-save">
                        <i class="fas fa-save"></i>
                        حفظ الكتاب
                    </button>
                    <a href="index.php" class="btn-cancel">
                        <i class="fas fa-times"></i>
                        إلغاء
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>