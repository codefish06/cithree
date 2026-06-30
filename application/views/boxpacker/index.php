<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>BoxPacker Example</title>
    <style>
        :root {
            color-scheme: dark;
            --bg: #0b1220;
            --panel: #121a2b;
            --panel-strong: #182238;
            --border: #2a3958;
            --text: #e7edf7;
            --muted: #9fb0cc;
            --accent: #7dd3fc;
            --accent-strong: #38bdf8;
            --input-bg: #0f1728;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 2rem;
            line-height: 1.5;
            background: radial-gradient(circle at top, #16233d 0%, var(--bg) 45%);
            color: var(--text);
        }

        .box {
            border: 1px solid var(--border);
            border-radius: 8px;
            margin-top: 1rem;
            padding: 1rem 1.25rem;
            background: linear-gradient(180deg, var(--panel-strong), var(--panel));
            box-shadow: 0 16px 40px rgba(0, 0, 0, 0.22);
        }

        .panel {
            border: 1px solid var(--border);
            border-radius: 8px;
            margin-top: 1rem;
            padding: 1rem 1.25rem;
            background: linear-gradient(180deg, var(--panel-strong), var(--panel));
            box-shadow: 0 16px 40px rgba(0, 0, 0, 0.22);
        }

        .product-grid {
            display: grid;
            gap: 1rem;
        }

        .product-row {
            border-bottom: 1px solid var(--border);
            padding-bottom: 1rem;
        }

        .product-row:last-child {
            border-bottom: 0;
            padding-bottom: 0;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 0.35rem;
            color: var(--muted);
        }

        input[type="number"] {
            padding: 0.4rem 0.5rem;
            width: 90px;
            border-radius: 6px;
            border: 1px solid var(--border);
            background: var(--input-bg);
            color: var(--text);
        }

        button {
            margin-top: 1rem;
            padding: 0.55rem 0.9rem;
            border: 1px solid var(--accent-strong);
            background: var(--accent-strong);
            color: #08111f;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
        }

        button:hover {
            background: var(--accent);
            border-color: var(--accent);
        }

        code {
            background: #0f1728;
            border-radius: 4px;
            padding: 0.1rem 0.35rem;
            color: var(--accent);
        }

        h1, h2, h3, h4 {
            color: var(--text);
        }

        p, li {
            color: var(--muted);
        }

        a {
            color: var(--accent);
        }
    </style>
</head>
<body>
    <h1>BoxPacker Getting Started Example</h1>
    <p>This route reproduces the <code>Packing a set of items into a given set of box types</code> example from the BoxPacker 3.x docs using application-defined <code>Box</code> and <code>Item</code> classes.</p>

    <h2>Requested items</h2>
    <ul>
        <?php foreach ($pack_requests as $request): ?>
            <li>
                <?php echo html_escape($request['item']->getDescription()); ?>
                x <?php echo (int) $request['qty']; ?>
                (<?php echo (int) $request['item']->getWidth(); ?> x <?php echo (int) $request['item']->getLength(); ?> x <?php echo (int) $request['item']->getDepth(); ?>mm,
                <?php echo (int) $request['item']->getWeight(); ?>g,
                keep flat: <?php echo $request['item']->getKeepFlat() ? 'yes' : 'no'; ?>)
            </li>
        <?php endforeach; ?>
    </ul>

    <h2>Result</h2>
    <p>These items fitted into <?php echo count($packed_boxes); ?> box(es).</p>

    <?php foreach ($packed_boxes as $packed_box): ?>
        <?php $box = $packed_box->getBox(); ?>
        <div class="box">
            <h3><?php echo html_escape($box->getReference()); ?></h3>
            <p>
                Outer dimensions:
                <?php echo (int) $box->getOuterWidth(); ?> x
                <?php echo (int) $box->getOuterLength(); ?> x
                <?php echo (int) $box->getOuterDepth(); ?>mm
            </p>
            <p>Total packed weight: <?php echo (int) $packed_box->getWeight(); ?>g</p>

            <h4>Items in this box</h4>
            <ul>
                <?php foreach ($packed_box->getItems() as $packed_item): ?>
                    <li><?php echo html_escape($packed_item->getItem()->getDescription()); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endforeach; ?>

    <h2>CSV Product Combination</h2>
    <p>This second packer uses the BrowserStack Rewards CSV products you requested. Change the quantities and click <code>Repack</code> to recalculate.</p>

    <form method="get" action="">
        <div class="panel product-grid">
            <?php foreach ($csv_pack_requests as $request): ?>
                <div class="product-row">
                    <h3><?php echo html_escape($request['item']->getDescription()); ?></h3>
                    <p><?php echo html_escape($request['comment']); ?></p>
                    <p>
                        Product code: <?php echo html_escape($request['product_code']); ?><br>
                        Dimensions:
                        <?php echo (int) $request['item']->getWidth(); ?> x
                        <?php echo (int) $request['item']->getLength(); ?> x
                        <?php echo (int) $request['item']->getDepth(); ?>mm<br>
                        Weight: <?php echo (int) $request['item']->getWeight(); ?>g
                    </p>
                    <label for="csv_qty_<?php echo html_escape($request['key']); ?>">Quantity</label>
                    <input
                        id="csv_qty_<?php echo html_escape($request['key']); ?>"
                        type="number"
                        name="csv_qty[<?php echo html_escape($request['key']); ?>]"
                        min="0"
                        value="<?php echo (int) $request['qty']; ?>"
                    >
                </div>
            <?php endforeach; ?>
        </div>
        <button type="submit">Repack</button>
    </form>

    <p>These CSV products fitted into <?php echo count($csv_packed_boxes); ?> box(es).</p>

    <?php foreach ($csv_packed_boxes as $packed_box): ?>
        <?php $box = $packed_box->getBox(); ?>
        <div class="box">
            <h3><?php echo html_escape($box->getReference()); ?></h3>
            <p>
                Outer dimensions:
                <?php echo (int) $box->getOuterWidth(); ?> x
                <?php echo (int) $box->getOuterLength(); ?> x
                <?php echo (int) $box->getOuterDepth(); ?>mm
            </p>
            <p>Total packed weight: <?php echo (int) $packed_box->getWeight(); ?>g</p>

            <h4>Items in this box</h4>
            <ul>
                <?php foreach ($packed_box->getItems() as $packed_item): ?>
                    <li><?php echo html_escape($packed_item->getItem()->getDescription()); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endforeach; ?>
</body>
</html>
