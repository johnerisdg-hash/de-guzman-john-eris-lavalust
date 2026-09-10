<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
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

        .toolbar {
            margin-bottom: 1.5rem;
        }

        .button,
        button {
            display: inline-block;
            padding: 0.7rem 1rem;
            border: 1px solid #fff;
            background: #222;
            color: #fff;
            text-decoration: none;
            cursor: pointer;
            font: inherit;
        }

        .button:hover,
        button:hover {
            background: #fff;
            color: #000;
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

        .action-form {
            display: inline;
        }

        .empty {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Products</h1>
        <div class="toolbar">
            <a class="button" href="<?= site_url('products/create'); ?>">Add Product</a>
            <a class="button" href="<?= site_url('products/logout'); ?>" onclick="return confirm('Are you sure you want to log out?');">Log Out</a>
        </div>

        <table>
            <thead>
                <tr><th>ID</th><th>Product Name</th><th>Description</th><th>Price</th><th>Quantity</th><th>Date Added</th><th>Actions</th></tr>
            </thead>
            <tbody>
                <?php if (!empty($products)): ?>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?= html_escape($product['id'] ?? ''); ?></td>
                            <td><?= html_escape($product['product_name'] ?? ''); ?></td>
                            <td><?= html_escape($product['description'] ?? ''); ?></td>
                            <td><?= number_format((float) ($product['price'] ?? 0), 2); ?></td>
                            <td><?= html_escape($product['quantity'] ?? 0); ?></td>
                            <td><?= ($product['created_at'] ?? '') === '0000-00-00 00:00:00' || empty($product['created_at'])
                                ? 'Not recorded'
                                : html_escape($product['created_at']); ?></td>
                            <td>
                                <a class="button" href="<?= site_url('products/edit/' . (int) $product['id']); ?>">Edit</a>
                                <form class="action-form" action="<?= site_url('products/delete/' . (int) $product['id']); ?>" method="post" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                    <button type="submit">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="7" class="empty">No products found in the database.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>