<?= $this->extend('templates/main') ?>

<?= $this->section('title') ?>Create account<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="auth-shell">
    <div class="center" style="margin-bottom:28px;">
        <div class="eyebrow">Get started</div>
        <h1 style="font-size:26px;">Create your account</h1>
    </div>

    <?php $errors = session()->getFlashdata('errors'); ?>
    <?php if (! empty($errors)): ?>
        <div class="alert alert-error">
            <strong>Please fix the following:</strong>
            <ul>
                <?php foreach ($errors as $err): ?>
                    <li><?= esc($err) ?></li>
                <?php endforeach ?>
            </ul>
        </div>
    <?php endif ?>

    <form class="form-card" action="<?= site_url('/register') ?>" method="post" autocomplete="on">
        <?= csrf_field() ?>

        <div class="form-row">
            <label for="username">Username</label>
            <input
                type="text"
                id="username"
                name="username"
                value="<?= esc(old('username')) ?>"
                required
                autofocus>
        </div>

        <div class="form-row">
            <label for="email">Email address</label>
            <input
                type="email"
                id="email"
                name="email"
                value="<?= esc(old('email')) ?>"
                required>
        </div>

        <div class="form-row">
            <label for="password">Password <span class="muted small">(min 6 characters)</span></label>
            <input
                type="password"
                id="password"
                name="password"
                minlength="6"
                required>
        </div>

        <button type="submit" class="btn btn-primary btn-block">Create account</button>

        <div class="divider"></div>
        <p class="center small muted" style="margin:0;">
            Already have an account? <a href="<?= site_url('/login') ?>">Sign in</a>.
        </p>
    </form>
</div>
<?= $this->endSection() ?>
