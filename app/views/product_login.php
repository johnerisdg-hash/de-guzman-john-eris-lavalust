<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Admin Login</title>
    <style>
        body {
            margin: 0;
            padding: 2rem;
            background: #000;
            color: #fff;
            font-family: Arial, sans-serif;
        }

        .container {
            width: min(100%, 460px);
            margin: 4rem auto;
        }

        .panel {
            padding: 2rem;
            border: 1px solid #fff;
            background: #000;
        }

        h1 {
            margin-top: 0;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
        }

        input {
            box-sizing: border-box;
            width: 100%;
            padding: 0.7rem;
            border: 1px solid #fff;
            background: #000;
            color: #fff;
        }

        .field {
            margin-bottom: 1.25rem;
        }

        button,
        .back-button {
            display: inline-block;
            padding: 0.7rem 1rem;
            border: 1px solid #fff;
            background: #222;
            color: #fff;
            text-decoration: none;
            cursor: pointer;
        }

        button:hover,
        .back-button:hover {
            background: #fff;
            color: #000;
        }

        .error {
            padding: 0.75rem;
            border: 1px solid #b00020;
            color: #ff6b6b;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="panel">
            <h1>Product Admin Login</h1>

            <?php if (!empty($error)): ?>
                <p class="error" role="alert"><?= html_escape($error); ?></p>
            <?php endif; ?>

            <form action="<?= site_url('products/login'); ?>" method="post">
                <div class="field">
                    <label for="username">Username</label>
                    <input id="username" type="text" name="username" value="<?= html_escape($username ?? ''); ?>" required autofocus>
                </div>
                <div class="field">
                    <label for="password">Password</label>
                    <input id="password" type="password" name="password" required>
                </div>
                <button type="submit">Log in</button>
                <a class="back-button" href="<?= site_url('student'); ?>">Back</a>
            </form>
        </div>
    </div>
</body>
</html>