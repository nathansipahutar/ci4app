<?= $this->extend('templates/index'); ?>

<?= $this->section('page-content'); ?>
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">User Detail</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="card mb-3" style="width: 650px;">
            <div class="row no-gutters">
                <div class="col-md-4">
                    <img src="<?= base_url('/img/' . $user->user_image) . '.svg'; ?>" class="card-img" alt="<?= $user->username; ?>">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <h4><?= $user->username; ?></h4>
                            </li>
                            <?php if ($user->fullname) : ?>
                                <li class="list-group-item"><?= $user->fullname; ?></li>
                            <?php endif; ?>
                            <li class="list-group-item"><?= $user->email; ?></li>
                            <li class="list-group-item">
                                <span class="badge badge-<?= ($user->name == 'admin') ? 'success' : 'warning' ?>">
                                    <?= $user->name; ?>
                                </span>
                            </li>
                            <li class="list-group-item"><small><a href="<?= base_url('admin'); ?>">&laquo; back to user list</a></small></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</div>

<?= $this->endSection('page-content'); ?>