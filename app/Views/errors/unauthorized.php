<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<?php 
    $role = session('user')['role'] ?? null;

    $redirect = '/login';

    if ($role === 'admin' || $role === 'teacher') {
        $redirect = '/dashboard';
    }

    if ($role === 'student') {
        $redirect = '/profile';
    }
?>

<div class="card p-5 text-center">
    <h2>403 Unauthorized</h2>

    <p>Your role: 
        <b><?= esc($role ?? 'Guest') ?></b>
    </p>

    <p>You do not have access to this page.</p>

    <a href="<?= $redirect ?>" class="btn btn-primary">
        Go Back
    </a>
</div>

<?= $this->endSection() ?>