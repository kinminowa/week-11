<?= $this->extend('templates/main') ?>

<?= $this->section('title') ?>Home<?= $this->endSection() ?>

<?= $this->section('content') ?>
<main>
    <div class="eyebrow">CI4 · Week 11</div>
    <h1>A clean slate, secured by default.</h1>
    <p class="lede">
        A minimal CodeIgniter 4 starter built around three principles: clear routes,
        protected forms, and escaped output. Sign in to reach the dashboard, or create
        an account to try it for yourself.
    </p>

    <div class="stack">
        <a href="<?= site_url('/register') ?>" class="btn btn-primary">Create an account</a>
        <a href="<?= site_url('/login') ?>" class="btn btn-ghost">I already have one</a>
    </div>

    <div class="grid">
        <div class="card">
            <div class="card-label">Security</div>
            <div class="card-value">CSRF on</div>
            <p class="small muted" style="margin-top:6px;">
                Every POST request is verified against a session token before reaching the controller.
            </p>
        </div>
        <div class="card">
            <div class="card-label">Output</div>
            <div class="card-value">XSS escaped</div>
            <p class="small muted" style="margin-top:6px;">
                User input is never rendered without passing through <code>esc()</code>.
            </p>
        </div>
        <div class="card">
            <div class="card-label">Routing</div>
            <div class="card-value">Filter-guarded</div>
            <p class="small muted" style="margin-top:6px;">
                The dashboard is wrapped in a route group protected by <code>AuthFilter</code>.
            </p>
        </div>
    </div>
</main>
<?= $this->endSection() ?>
