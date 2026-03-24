<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-center">
<div class="card shadow-sm p-4" style="max-width:600px; width:100%; border-radius:18px;">

    <h3 class="text-center fw-bold mb-4">Student Profile</h3>

    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="text-center mb-4">
        <?php if (!empty($user['profile_image'])): ?>
            <img 
                src="<?= base_url('uploads/profiles/' . esc($user['profile_image'])) ?>" 
                class="rounded-circle shadow-sm mb-2"
                style="width:110px; height:110px; object-fit:cover;"
            >
        <?php else: ?>
            <div class="rounded-circle mx-auto mb-2 d-flex align-items-center justify-content-center shadow-sm"
                style="width:110px; height:110px; background:#f1f1f1;">
                No Image
            </div>
        <?php endif; ?>

        <h5 class="fw-bold mb-0"><?= esc($user['name'] ?? '-') ?></h5>
        <small class="text-muted"><?= esc($user['email'] ?? '-') ?></small>
    </div>

    <hr>

    <div style="line-height:1.8;">

        <p><b>Student ID:</b> <?= esc($user['student_id'] ?? '-') ?></p>
        <p><b>Course:</b> <?= esc($user['course'] ?? '-') ?></p>
        <p><b>Year Level:</b> <?= esc($user['year_level'] ?? '-') ?></p>
        <p><b>Section:</b> <?= esc($user['section'] ?? '-') ?></p>
        <p><b>Phone:</b> <?= esc($user['phone'] ?? '-') ?></p>
        <p><b>Address:</b> <?= esc($user['address'] ?? '-') ?></p>

    </div>

    <hr>

    <div style="line-height:1.8;">
        <p><b>Account Created:</b> 
            <?= !empty($user['created_at']) ? date('F d, Y - h:i A', strtotime($user['created_at'])) : '-' ?>
        </p>

        <p><b>Last Updated:</b> 
            <?= !empty($user['updated_at']) ? date('F d, Y - h:i A', strtotime($user['updated_at'])) : '-' ?>
        </p>
    </div>

    <a href="/profile/edit" 
        class="btn w-100 mt-3"
        style="background:#f06292; color:white; border-radius:10px;">
        Edit Profile
    </a>

</div>
</div>

<?= $this->endSection() ?>