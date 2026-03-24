<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<?php 
    $role = session('user')['role'] ?? null;
?>

<style>
    .table-bordered {
        border: 1px solid #ff99cc;
    }

    .table-bordered th,
    .table-bordered td {
        border: 1px solid #ff99cc !important;
        vertical-align: middle;
        padding: 12px;
    }

    .table thead th {
        background: #fff0f6;
        font-weight: bold;
    }
</style>

<div class="card p-4 shadow">

    <h3 class="mb-3">Manage Students</h3>

    <?php if(session('success')): ?>

        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if ($role === 'teacher' || $role === 'admin'): ?>
        <a href="/students/create" class="btn btn-primary mb-3">
            Add Student
        </a>
    <?php endif; ?>

    <table class="table table-bordered text-center">
        <thead>
            <tr>
                <th>Student ID</th>
                <th>Full Name</th>
                <th>Course</th>
                <th>Year Level</th>
                <th>Section</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($students as $s): ?>
                <tr>
                    <td><?= esc($s['student_id']) ?></td>
                    <td><?= esc($s['full_name']) ?></td>
                    <td><?= esc($s['course']) ?></td>
                    <td><?= esc($s['year_level']) ?></td>
                    <td><?= esc($s['section']) ?></td>

                    <td>

                        <button 
                            class="btn action-btn btn-sm view-btn"
                            data-name="<?= esc($s['full_name']) ?>"
                            data-course="<?= esc($s['course']) ?>"
                            data-year="<?= esc($s['year_level']) ?>"
                            data-section="<?= esc($s['section']) ?>"
                            data-created="<?= !empty($s['created_at']) ? date('M d, Y - h:i A', strtotime($s['created_at'])) : '' ?>"
                            data-updated="<?= !empty($s['updated_at']) ? date('M d, Y - h:i A', strtotime($s['updated_at'])) : '' ?>"
                        >
                            View
                        </button>

                        <?php if ($role === 'teacher' || $role === 'admin' || $role === 'coordinator'): ?>
                            <button 
                                class="btn action-btn btn-sm edit-btn"
                                data-id="<?= $s['id'] ?>"
                                data-name="<?= esc($s['full_name']) ?>"
                                data-course="<?= esc($s['course']) ?>"
                                data-year="<?= esc($s['year_level']) ?>"
                                data-section="<?= esc($s['section']) ?>"
                            >
                                Edit
                            </button>
                        <?php endif; ?>

                        <?php if ($role === 'teacher' || $role === 'admin'): ?>
                            <a href="/students/delete/<?= $s['id'] ?>" 
                                onclick="return confirm('Are you sure?')" 
                                class="btn action-btn btn-sm">
                                Delete
                            </a>
                        <?php endif; ?>

                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        <?= $pager->links() ?>
    </div>

</div>

<div class="modal fade" id="viewModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Student Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <p><b>Full Name:</b> <span id="m_name"></span></p>
                <p><b>Course:</b> <span id="m_course"></span></p>
                <p><b>Year Level:</b> <span id="m_year"></span></p>
                <p><b>Section:</b> <span id="m_section"></span></p>
                <p><b>Created:</b> <span id="m_created"></span></p>
                <p><b>Updated:</b> <span id="m_updated"></span></p>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <form method="post" id="editForm">

                <div class="modal-header">
                    <h5 class="modal-title">Edit Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <?= csrf_field() ?>

                    <input type="hidden" id="e_id">

                    <input class="form-control mb-2" id="e_name" name="full_name" required>
                    <input class="form-control mb-2" id="e_course" name="course" required>
                    <input class="form-control mb-2" id="e_year" name="year_level" required>
                    <input class="form-control mb-2" id="e_section" name="section" required>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary w-100">
                        Update
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

<script>
document.querySelectorAll('.view-btn').forEach(button => {
    button.addEventListener('click', function(){

        document.getElementById('m_name').innerText = this.dataset.name;
        document.getElementById('m_course').innerText = this.dataset.course;
        document.getElementById('m_year').innerText = this.dataset.year;
        document.getElementById('m_section').innerText = this.dataset.section;
        document.getElementById('m_created').innerText = this.dataset.created;
        document.getElementById('m_updated').innerText = this.dataset.updated;

        new bootstrap.Modal(document.getElementById('viewModal')).show();
    });
});

document.querySelectorAll('.edit-btn').forEach(button => {
    button.addEventListener('click', function(){

        const id = this.dataset.id;

        document.getElementById('e_id').value = id;
        document.getElementById('e_name').value = this.dataset.name;
        document.getElementById('e_course').value = this.dataset.course;
        document.getElementById('e_year').value = this.dataset.year;
        document.getElementById('e_section').value = this.dataset.section;

        document.getElementById('editForm').action = "/students/update/" + id;

        new bootstrap.Modal(document.getElementById('editModal')).show();
    });
});
</script>

<?= $this->endSection() ?>