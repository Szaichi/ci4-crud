<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="center">
    <div class="card p-4 shadow" style="width: 400px">
        <h3 class="text-center mb-3">Login</h3>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success text-center">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger text-center">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <form method="post" action="/login">
        <?= csrf_field() ?>

        <input 
            class="form-control mb-3"
            type="text"
            name="email"
            placeholder="Email or Username"
            value="<?= old('email') ?>"
            required
        >

        <input 
            class="form-control mb-3"
            type="password"
            name="password"
            placeholder="Password"
            required
        >

        <button class="btn btn-primary w-100">
            Login
        </button>
    </form>

    <a href="/register" class="d-block text-center mt-3">
        Create new account
    </a>
</div>

</div>

<?= $this->endSection() ?>
