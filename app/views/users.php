<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User List</title>
    <style>
        body {
            margin: 0;
            padding: 2rem;
            background: #000;
            color: #fff;
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #000;
        }

        th,
        td {
            padding: 0.75rem 1rem;
            border: 1px solid #fff;
            text-align: left;
        }

        th {
            background: #222;
        }

        .home-button {
            display: inline-block;
            margin-bottom: 1.5rem;
            padding: 0.7rem 1rem;
            border: 1px solid #fff;
            color: #fff;
            background: #222;
            text-decoration: none;
        }

        .home-button:hover {
            background: #fff;
            color: #000;
        }

        .empty {
            text-align: center;
        }

         .create-button {
            display: inline-block;
            margin-bottom: 1.5rem;
            padding: 0.7rem 1rem;
            border: 1px solid #fff;
            color: #fff;
            background: #222;
            text-decoration: none;
        }

        .create-button:hover {
            background: #fff;
            color: #000;
        }

        .empty {
            text-align: center;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Registered Users</h2>
    <a class="home-button" href="<?= site_url('student'); ?>">Back to Student Homepage</a>
   

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Username</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($users)): ?>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= html_escape($user['id'] ?? ''); ?></td>
                        <td><?= html_escape($user['firstname'] ?? ''); ?></td>
                        <td><?= html_escape($user['lastname'] ?? ''); ?></td>
                        <td><?= html_escape($user['email'] ?? ''); ?></td>
                        <td><?= html_escape($user['username'] ?? ''); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="empty">No users found in the database.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>