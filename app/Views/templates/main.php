<?php
/**
 * Main layout
 * -----------
 * Every page extends this template and fills in two sections:
 *   - title    : the contents of <title>
 *   - content  : the page body that goes inside <main>
 *
 * The CSS is intentionally kept inline so the project runs on a fresh
 * XAMPP install without any build tooling. Palette: white, black, and
 * a single accent blue (#1f6feb).
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($this->renderSection('title')) ?> · Week 11</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@500&display=swap" rel="stylesheet">
    <style>
        /* ---------- Reset & tokens ---------- */
        :root {
            --bg:        #ffffff;
            --surface:   #ffffff;
            --ink:       #0a0a0a;
            --ink-soft:  #4b5563;
            --line:      #e5e7eb;
            --line-soft: #f1f5f9;
            --accent:    #1f6feb;
            --accent-ink:#ffffff;
            --accent-soft:#eaf2ff;
            --danger:    #b42318;
            --danger-bg: #fef3f2;
            --success:   #027a48;
            --success-bg:#ecfdf3;
            --radius:    6px;
            --shadow:    0 1px 2px rgba(10,10,10,.04);
        }
        *, *::before, *::after { box-sizing: border-box; }
        html, body { margin: 0; padding: 0; }
        body {
            font-family: 'Inter', system-ui, -apple-system, Segoe UI, sans-serif;
            background: var(--bg);
            color: var(--ink);
            font-size: 15px;
            line-height: 1.55;
            -webkit-font-smoothing: antialiased;
        }
        a { color: var(--accent); text-decoration: none; }
        a:hover { text-decoration: underline; }

        /* ---------- Top navigation ---------- */
        .nav {
            border-bottom: 1px solid var(--line);
            background: var(--surface);
        }
        .nav-inner {
            max-width: 1100px;
            margin: 0 auto;
            padding: 18px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .brand {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 700;
            color: var(--ink);
            letter-spacing: -.01em;
        }
        .brand-mark {
            width: 22px; height: 22px;
            background: var(--ink);
            position: relative;
        }
        .brand-mark::after {
            content: '';
            position: absolute;
            inset: 6px 0 0 6px;
            background: var(--accent);
        }
        .brand:hover { text-decoration: none; }
        .nav-links { display: flex; gap: 8px; align-items: center; }

        /* ---------- Layout ---------- */
        main {
            max-width: 1100px;
            margin: 0 auto;
            padding: 56px 24px 80px;
        }
        .auth-shell {
            max-width: 420px;
            margin: 56px auto;
            padding: 0 24px;
        }
        footer {
            border-top: 1px solid var(--line);
            color: var(--ink-soft);
            font-size: 13px;
        }
        footer .nav-inner { padding: 18px 24px; }

        /* ---------- Typography ---------- */
        h1 {
            font-size: 36px;
            line-height: 1.15;
            letter-spacing: -.02em;
            margin: 0 0 12px;
            font-weight: 700;
        }
        h2 {
            font-size: 18px;
            margin: 0 0 16px;
            font-weight: 600;
            letter-spacing: -.01em;
        }
        p { margin: 0 0 12px; color: var(--ink-soft); }
        .lede { font-size: 17px; color: var(--ink-soft); max-width: 60ch; }
        .eyebrow {
            text-transform: uppercase;
            letter-spacing: .12em;
            font-size: 11px;
            font-weight: 600;
            color: var(--accent);
            margin-bottom: 14px;
        }
        code, .mono { font-family: 'JetBrains Mono', ui-monospace, monospace; font-size: 13px; }

        /* ---------- Buttons ---------- */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 9px 16px;
            font: inherit;
            font-weight: 500;
            font-size: 14px;
            border-radius: var(--radius);
            border: 1px solid transparent;
            cursor: pointer;
            transition: background .12s ease, border-color .12s ease, color .12s ease;
            white-space: nowrap;
        }
        .btn-primary {
            background: var(--accent);
            color: var(--accent-ink);
        }
        .btn-primary:hover { background: #1859c4; text-decoration: none; }
        .btn-ghost {
            background: transparent;
            color: var(--ink);
            border-color: var(--line);
        }
        .btn-ghost:hover { border-color: var(--ink); text-decoration: none; }
        .btn-dark {
            background: var(--ink);
            color: #fff;
        }
        .btn-dark:hover { background: #000; text-decoration: none; }
        .btn-block { width: 100%; padding: 11px 16px; }

        /* ---------- Cards & grid ---------- */
        .grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 16px;
            margin-top: 32px;
        }
        @media (max-width: 760px) { .grid { grid-template-columns: 1fr; } }
        .card {
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: var(--radius);
            padding: 22px;
            box-shadow: var(--shadow);
        }
        .card-label {
            font-size: 12px;
            font-weight: 600;
            color: var(--ink-soft);
            text-transform: uppercase;
            letter-spacing: .08em;
            margin-bottom: 8px;
        }
        .card-value { font-size: 22px; font-weight: 600; letter-spacing: -.01em; }

        /* ---------- Forms ---------- */
        .form-card {
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: var(--radius);
            padding: 32px;
            box-shadow: var(--shadow);
        }
        .form-row { margin-bottom: 16px; }
        .form-row label {
            display: block;
            font-size: 13px;
            font-weight: 500;
            color: var(--ink);
            margin-bottom: 6px;
        }
        .form-row input {
            width: 100%;
            padding: 10px 12px;
            font: inherit;
            font-size: 14px;
            color: var(--ink);
            background: #fff;
            border: 1px solid var(--line);
            border-radius: var(--radius);
            transition: border-color .12s ease, box-shadow .12s ease;
        }
        .form-row input:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(31, 111, 235, .15);
        }

        /* ---------- Alerts ---------- */
        .alert {
            border-radius: var(--radius);
            padding: 12px 14px;
            font-size: 14px;
            margin-bottom: 18px;
            border: 1px solid transparent;
        }
        .alert-error   { background: var(--danger-bg);  color: var(--danger);  border-color: #fecdca; }
        .alert-success { background: var(--success-bg); color: var(--success); border-color: #abefc6; }
        .alert ul { margin: 6px 0 0 18px; padding: 0; }

        /* ---------- Hero / dashboard helpers ---------- */
        .row { display: flex; align-items: center; justify-content: space-between; gap: 16px; flex-wrap: wrap; }
        .stack { display: flex; gap: 10px; flex-wrap: wrap; margin-top: 20px; }
        .panel {
            border: 1px solid var(--line);
            border-radius: var(--radius);
            padding: 24px;
            margin-top: 24px;
            background: var(--surface);
        }
        .kbd-tag {
            display: inline-block;
            background: var(--accent-soft);
            color: var(--accent);
            border-radius: 999px;
            padding: 3px 10px;
            font-size: 12px;
            font-weight: 500;
        }
        .divider { height: 1px; background: var(--line); margin: 28px 0; }
        .muted { color: var(--ink-soft); }
        .small { font-size: 13px; }
        .center { text-align: center; }
        .hr-text { color: var(--ink-soft); font-size: 12px; }
    </style>
</head>
<body>

<header class="nav">
    <div class="nav-inner">
        <a href="<?= site_url('/') ?>" class="brand">
            <span class="brand-mark" aria-hidden="true"></span>
            <span>week_11</span>
        </a>
        <nav class="nav-links">
            <?php if (session()->get('isLoggedIn')): ?>
                <a href="<?= site_url('/dashboard') ?>" class="btn btn-ghost">Dashboard</a>
                <form action="<?= site_url('/logout') ?>" method="post" style="display:inline;">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-dark">Sign out</button>
                </form>
            <?php else: ?>
                <a href="<?= site_url('/login') ?>" class="btn btn-ghost">Log in</a>
                <a href="<?= site_url('/register') ?>" class="btn btn-primary">Get started</a>
            <?php endif ?>
        </nav>
    </div>
</header>

<?= $this->renderSection('content') ?>

<footer>
    <div class="nav-inner">
        <span class="muted small">week_11 · CodeIgniter <?= esc(\CodeIgniter\CodeIgniter::CI_VERSION ?? '4') ?></span>
        <span class="muted small">Built with care · <?= esc(date('Y')) ?></span>
    </div>
</footer>

</body>
</html>
