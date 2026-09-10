<!DOCTYPE html>
<html lang="en">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Edit Product</title>
<style>
    body {
        margin: 0;
        padding: 2rem;
        background: #000;
        color: #fff;
        font-family: Arial, sans-serif;
    }

    .container {
        width: min(100%, 600px);
        margin: 2rem auto;
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

    input,
    textarea {
        box-sizing: border-box;
        width: 100%;
        padding: 0.7rem;
        border: 1px solid #fff;
        background: #000;
        color: #fff;
        font: inherit;
    }

    textarea {
        min-height: 120px;
        resize: vertical;
    }

    .field {
        margin-bottom: 1.25rem;
    }

    button,
    .button {
        display: inline-block;
        padding: 0.7rem 1rem;
        border: 1px solid #fff;
        background: #222;
        color: #fff;
        text-decoration: none;
        cursor: pointer;
        font: inherit;
    }

    button:hover,
    .button:hover {
        background: #fff;
        color: #000;
    }
</style></head>
<body>
    <div class="container">
        <div class="panel">
            <h1>Edit Product</h1>
            <form action="<?= site_url('products/edit/' . (int) $product['id']); ?>" method="post">
                <div class="field">
                    <label for="product_name">Product Name</label>
                    <input id="product_name" type="text" name="product_name" value="<?= html_escape($product['product_name'] ?? ''); ?>" required>
                </div>
                <div class="field">
                    <label for="description">Description</label>
                    <textarea id="description" name="description"><?= html_escape($product['description'] ?? ''); ?></textarea>
                </div>
                <div class="field">
                    <label for="price">Price</label>
                    <input id="price" type="number" name="price" min="0" step="0.01" value="<?= html_escape($product['price'] ?? 0); ?>" required>
                </div>
                <div class="field">
                    <label for="quantity">Quantity</label>
                    <input id="quantity" type="number" name="quantity" min="0" step="1" value="<?= html_escape($product['quantity'] ?? 0); ?>" required>
                </div>
                <button type="submit">Update Product</button>
                <a class="button" href="<?= site_url('products'); ?>">Cancel</a>
            </form>
        </div>
    </div>
</body>
</html>