<?= $this->extend('templates/main') ?>

<?= $this->section('title') ?>Dashboard<?= $this->endSection() ?>

<?= $this->section('content') ?>
<main>
    <div class="row">
        <div>
            <div class="eyebrow">Protected area</div>
            <h1>Hello, <?= esc($username) ?>.</h1>
            <p class="lede">
                You're signed in as <strong><?= esc($email) ?></strong>. This page is gated by
                <code>AuthFilter</code> — visitors without a valid session are redirected to the
                login screen.
            </p>
        </div>
        <span class="kbd-tag">Session active</span>
    </div>

    <?php /* ---- Flash messages ------------------------------------------------- */ ?>
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success" style="margin-top:24px;">
            <?= esc(session()->getFlashdata('success')) ?>
        </div>
    <?php endif ?>
    <?php $errors = session()->getFlashdata('errors'); ?>
    <?php if (! empty($errors)): ?>
        <div class="alert alert-error" style="margin-top:24px;">
            <strong>Could not save the note:</strong>
            <ul>
                <?php foreach ($errors as $err): ?>
                    <li><?= esc($err) ?></li>
                <?php endforeach ?>
            </ul>
        </div>
    <?php endif ?>

    <div class="grid">
        <div class="card">
            <div class="card-label">Account</div>
            <div class="card-value"><?= esc($username) ?></div>
            <p class="small muted" style="margin-top:6px;">Your visible identity in the app.</p>
        </div>
        <div class="card">
            <div class="card-label">Email on file</div>
            <div class="card-value" style="font-size:16px; word-break:break-all;"><?= esc($email) ?></div>
            <p class="small muted" style="margin-top:6px;">Used for sign-in and notifications.</p>
        </div>
        <div class="card">
            <div class="card-label">Notes saved</div>
            <div class="card-value"><?= esc(count($notes)) ?></div>
            <p class="small muted" style="margin-top:6px;">Stored in the <code>notes</code> table.</p>
        </div>
    </div>

    <?php /* ---- Notes form (CSRF demonstration) --------------------------------- */ ?>
    <div class="panel">
        <h2>Add a note</h2>
        <p class="muted">
            Submitting this form sends a POST request that must include a valid CSRF token.
            Try entering <code>&lt;script&gt;alert(1)&lt;/script&gt;</code> — it will be stored
            and rendered as plain text because every output uses <code>esc()</code>.
        </p>
        <form action="<?= site_url('/notes') ?>" method="post" style="margin-top:14px;">
            <?= csrf_field() ?>
            <div class="form-row">
                <label for="body">Note body <span class="muted small">(max 500 characters)</span></label>
                <input
                    type="text"
                    id="body"
                    name="body"
                    maxlength="500"
                    required
                    placeholder="Write something…">
            </div>
            <button type="submit" class="btn btn-primary">Save note</button>
        </form>
    </div>

    <?php /* ---- CSRF protection test ---------------------------------------------- */ ?>
    <div class="panel">
        <h2>Test the CSRF filter</h2>
        <p class="muted">
            The button below sends a raw POST request to <code>/notes</code>
            <strong>without</strong> the CSRF token. The global <code>csrf</code> filter should
            reject it before it ever reaches the controller. Watch the result box.
        </p>
        <div class="stack">
            <button type="button" id="csrf-test-btn" class="btn btn-dark">
                POST without CSRF token
            </button>
            <span id="csrf-test-result" class="small muted">No request sent yet.</span>
        </div>

        <script>
            (function () {
                const btn    = document.getElementById('csrf-test-btn');
                const result = document.getElementById('csrf-test-result');

                btn.addEventListener('click', async function () {
                    result.textContent = 'Sending…';
                    result.style.color = '';

                    try {
                        const response = await fetch(<?= json_encode(site_url('/notes')) ?>, {
                            method:  'POST',
                            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                            body:    'body=this+should+be+rejected',
                        });

                        if (response.status === 403) {
                            result.textContent = 'Blocked (HTTP 403) — CSRF filter is working.';
                            result.style.color = '#027a48';
                        } else {
                            result.textContent = 'Unexpected status: HTTP ' + response.status;
                            result.style.color = '#b42318';
                        }
                    } catch (err) {
                        result.textContent = 'Request failed: ' + err.message;
                        result.style.color = '#b42318';
                    }
                });
            })();
        </script>
    </div>

    <?php /* ---- Saved notes ------------------------------------------------------- */ ?>
    <div class="panel">
        <h2>Your notes</h2>
        <?php if (empty($notes)): ?>
            <p class="muted">No notes yet. Add one above to see escaped output in action.</p>
        <?php else: ?>
            <div style="display:flex; flex-direction:column; gap:12px; margin-top:8px;">
                <?php foreach ($notes as $note): ?>
                    <div style="border:1px solid var(--line); border-radius:var(--radius); padding:14px 16px; display:flex; justify-content:space-between; align-items:flex-start; gap:12px;">
                        <div style="flex:1; min-width:0;">
                            <div style="word-break:break-word; white-space:pre-wrap;"><?= esc($note['body']) ?></div>
                            <div class="small muted" style="margin-top:6px;">
                                Saved <?= esc($note['created_at']) ?>
                            </div>
                        </div>
                        <form action="<?= site_url('notes/' . (int) $note['id'] . '/delete') ?>" method="post">
                            <?= csrf_field() ?>
                            <button type="submit" class="btn btn-ghost" style="padding:6px 12px;">Delete</button>
                        </form>
                    </div>
                <?php endforeach ?>
            </div>
        <?php endif ?>
    </div>

    <?php /* ---- Session controls -------------------------------------------------- */ ?>
    <div class="panel">
        <h2>Session controls</h2>
        <p class="muted">Signing out clears your CI4 session and returns you to the landing page.</p>
        <div class="stack">
            <form action="<?= site_url('/logout') ?>" method="post">
                <?= csrf_field() ?>
                <button type="submit" class="btn btn-dark">Sign out</button>
            </form>
            <a href="<?= site_url('/') ?>" class="btn btn-ghost">Back to home</a>
        </div>
    </div>
</main>
<?= $this->endSection() ?>
