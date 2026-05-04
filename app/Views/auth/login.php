<?= $this->extend('templates/main') ?>

<?= $this->section('title') ?>Sign in<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="auth-shell">
    <div class="center" style="margin-bottom:28px;">
        <div class="eyebrow">Welcome back</div>
        <h1 style="font-size:26px;">Sign in to your account</h1>
    </div>

    <?php /* Flash messages — escaped before display. */ ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-error"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif ?>
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
    <?php endif ?>

    <?php /* Validation errors. */ ?>
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

    <form class="form-card" action="<?= site_url('/login') ?>" method="post" autocomplete="on">
        <?= csrf_field() ?>

        <div class="form-row">
            <label for="email">Email address</label>
            <input
                type="email"
                id="email"
                name="email"
                value="<?= esc(old('email')) ?>"
                required
                autofocus>
        </div>

        <div class="form-row">
            <label for="password">Password</label>
            <input
                type="password"
                id="password"
                name="password"
                required>
        </div>

        <button type="submit" class="btn btn-primary btn-block">Sign in</button>

        <div class="divider"></div>
        <p class="center small muted" style="margin:0;">
            New here? <a href="<?= site_url('/register') ?>">Create an account</a>.
        </p>
    </form>
</div>
<?= $this->endSection() ?>
