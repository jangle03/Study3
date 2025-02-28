

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Study3 - Trang chủ</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            display: flex;
            margin: auto;
            padding: 20px;
        }
        .sidebar {
            width: 20%;
            background: #ffffff;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-right: 10px;
        }
        .sidebar ul {
            list-style: none;
            padding: 0;
        }
        .sidebar li {
            background-color: #e0e0e0;
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
            transition: background-color 0.3s;
        }
        .sidebar li:hover {
            background-color: #d0d0d0;
        }
        .sidebar a {
            text-decoration: none;
            color: #333;
            display: block;
        }
        .content {
            flex-grow: 1;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .post {
            border-bottom: 1px solid #ddd;
            padding: 10px 0;
        }
        .like-btn {
            padding: 5px 10px;
            background-color: #2F4F4F;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }
        .like-btn:hover {
            background-color: #0056b3;
        }
        .bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #2F4F4F;
            padding: 10px 20px;
            color: white;
            font-size: 20px;
        }
        .site-name {
            font-weight: bold;
            margin: 0;
        }
        .login-button {
            padding: 8px 15px;
            background-color: white;
            color: #007bff;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }
        .login-button:hover {
            background-color: #f0f0f0;
        }
    </style>
</head>
<body>

<div class="bar">
    <p class="site-name">Study3</p>
    <a href="/login/" class="login-button">Login</a>
</div>

<div class="container">
    <div class="sidebar">
        <h3>Danh mục</h3>
        <ul>
            <li><a href="index.php">Trang chủ</a></li>
            <li><a href="khoahoc.php">Khóa học</a></li>
            <li><a href="#">Lịch thi</a></li>
            <li><a href="#">Tài liệu học tập</a></li>
            <li><a href="#">Sự kiện</a></li>
            <li><a href="#">Hỗ trợ</a></li>
        </ul>
    </div>

    <div class="content">
    <h2>Khóa học</h2>
    <ul>
        <li>🌟 Luyện thi Tiếng Anh B1</li>
        <li>🌟 Luyện thi Tiếng Anh B2</li>
        <li>🌟 Luyện thi Toeic</li>
        <li>🌟 Tiếng anh giao tiếp cơ bản</li>
        <li>🌟 Tiếng anh cơ bản</li>
    </ul>
    </div>
</div>

</body>
</html>

