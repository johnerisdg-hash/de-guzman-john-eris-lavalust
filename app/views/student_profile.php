<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Profile</title>
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
            padding: 40px 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: rgba(20, 20, 20, 0.9);
            padding: 50px;
            border-radius: 8px;
            border-left: 5px solid #8b6f47;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5);
        }
        h1 {
            font-size: 2em;
            color: #d4af37;
            margin-bottom: 35px;
            text-align: center;
            padding-bottom: 15px;
            border-bottom: 2px solid #8b6f47;
        }
        .info-group {
            margin-bottom: 18px;
            padding-bottom: 12px;
            border-bottom: 1px solid #333;
        }
        .info-group:last-of-type {
            border-bottom: none;
        }
        .label {
            color: #8b6f47;
            font-weight: 600;
            font-size: 0.95em;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .value {
            color: #e0e0e0;
            margin-top: 5px;
            font-size: 1.1em;
        }
        .nav-links {
            margin-top: 40px;
            text-align: center;
            padding-top: 20px;
            border-top: 2px solid #8b6f47;
        }
        a {
            display: inline-block;
            padding: 12px 35px;
            background: #8b6f47;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            font-weight: 600;
            transition: all 0.3s ease;
            margin: 5px;
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
        <h1>Student Profile</h1>
        
        <div class="info-group">
            <div class="label">Student ID</div>
            <div class="value"><?= $student_id; ?></div>
        </div>

        <div class="info-group">
            <div class="label">Name</div>
            <div class="value"><?= $name; ?></div>
        </div>

        <div class="info-group">
            <div class="label">Course</div>
            <div class="value"><?= $course; ?></div>
        </div>

        <div class="info-group">
            <div class="label">Year Level</div>
            <div class="value"><?= $year; ?></div>
        </div>

        <div class="info-group">
            <div class="label">Section</div>
            <div class="value"><?= $section; ?></div>
        </div>

        <div class="info-group">
            <div class="label">Email</div>
            <div class="value"><?= $email; ?></div>
        </div>

        <div class="info-group">
            <div class="label">Address</div>
            <div class="value"><?= $address; ?></div>
        </div>

        <div class="info-group">
            <div class="label">Contact Number</div>
            <div class="value"><?= $contact; ?></div>
        </div>

        <div class="info-group">
            <div class="label">Skills</div>
            <div class="value"><?= $skills; ?></div>
        </div>

        <div class="info-group">
            <div class="label">Hobbies</div>
            <div class="value"><?= $hobbies; ?></div>
        </div>

        <div class="info-group">
            <div class="label">Quote</div>
            <div class="value"><?= $quote; ?></div>
        </div>

        <div class="nav-links">
            <a href="<?= site_url('student'); ?>">← Back to Home</a>
        </div>
    </div>
</body>
</html>