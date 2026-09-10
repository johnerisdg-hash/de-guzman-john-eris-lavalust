<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Portal</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #e0e0e0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .container {
            background: rgba(20, 20, 20, 0.9);
            border-left: 5px solid #8b6f47;
            padding: 60px 50px;
            border-radius: 8px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5);
            max-width: 500px;
            text-align: center;
        }
        h1 {
            font-size: 2.5em;
            margin-bottom: 15px;
            color: #d4af37;
        }
        h3 {
            font-size: 1.1em;
            color: #a0a0a0;
            margin-bottom: 40px;
            font-weight: 300;
        }
        .btn-container {
            margin-top: 30px;
        }
        a {
            display: inline-block;
            padding: 14px 40px;
            background: #8b6f47;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            font-weight: 600;
            transition: all 0.3s ease;
            margin: 10px;
        }
        a:hover {
            background: #a0825c;
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(139, 111, 71, 0.4);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome, Visitor!</h1>
        <h3>Click to view my profile</h3>
        
        <div class="btn-container">
            <a href="<?= site_url('student/profile'); ?>">View Profile</a>
            <a href="<?= site_url('users'); ?>">View Registered Users</a>
            <a href="<?= site_url('products/login'); ?>">Product Management</a>
        </div>
    </div>
</body>
</html>