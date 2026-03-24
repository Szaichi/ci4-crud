<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="center">
    <div class="card p-4 shadow" style="width: 400px">
        <h3 class="text-center mb-3">Register</h3>

    <form method="post" action="/register">
        <?= csrf_field() ?>

        <input 
            class="form-control mb-2"
            name="name"
            placeholder="Full Name"
            value="<?= old('name') ?>"
            required
        >

        <?php if (session()->getFlashdata('errors')['name'] ?? false): ?>
            <div class="text-danger mb-2">
                <?= session()->getFlashdata('errors')['name'] ?>
            </div>
        <?php endif; ?>

        <input 
            class="form-control mb-2"
            name="username"
            placeholder="Username"
            value="<?= old('username') ?>"
            required
        >

        <?php if (session()->getFlashdata('errors')['username'] ?? false): ?>
            <div class="text-danger mb-2">
                <?= session()->getFlashdata('errors')['username'] ?>
            </div>
        <?php endif; ?>

        <input 
            class="form-control mb-2"
            type="email"
            name="email"
            placeholder="Email"
            value="<?= old('email') ?>"
            required
        >

        <?php if (session()->getFlashdata('errors')['email'] ?? false): ?>
            <div class="text-danger mb-2">
                <?= session()->getFlashdata('errors')['email'] ?>
            </div>
        <?php endif; ?>

        <input 
            class="form-control mb-2"
            type="password"
            name="password"
            placeholder="Password"
            required
        >

        <?php if (session()->getFlashdata('errors')['password'] ?? false): ?>
            <div class="text-danger mb-2">
                <?= session()->getFlashdata('errors')['password'] ?>
            </div>
        <?php endif; ?>

        <input 
            class="form-control mb-2"
            type="password"
            name="confirm_password"
            placeholder="Confirm Password"
            required
        >

        <?php if (session()->getFlashdata('errors')['confirm_password'] ?? false): ?>
            <div class="text-danger mb-2">
                <?= session()->getFlashdata('errors')['confirm_password'] ?>
            </div>
        <?php endif; ?>

        <button class="btn btn-primary w-100 mt-2">Create Account</button>
    </form>

    <a href="/login" class="d-block text-center mt-3">Already have an account? Login</a>
</div>

</div>

<?= $this->endSection() ?>
