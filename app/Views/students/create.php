<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="card p-4 shadow">
    <h3>Add Student</h3>

    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="post" action="/students/store">
        <?= csrf_field() ?>

        <p><b>Student ID:</b> Auto-generated</p>

        <input 
            class="form-control mb-2" 
            name="full_name" 
            placeholder="Full Name"
            value="<?= old('full_name') ?>"
            required
        >

        <input 
            class="form-control mb-2" 
            name="course" 
            placeholder="Course"
            value="<?= old('course') ?>"
            required
        >

        <input 
            class="form-control mb-2" 
            name="year_level" 
            placeholder="Year Level"
            value="<?= old('year_level') ?>"
            required
        >

        <input 
            class="form-control mb-3" 
            name="section" 
            placeholder="Section"
            value="<?= old('section') ?>"
            required
        >

        <button class="btn btn-primary w-100">Save</button>
    </form>

</div>

<?= $this->endSection() ?>