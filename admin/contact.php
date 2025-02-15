<?php
session_start();

include '../config.php';
$query = new Database();
$query->checkUserSession('admin');

// Fetch contact information
$contact = $query->select('contact', "*")[0];
$contact_box = $query->select('contact_box', "*");

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['twitter'])) {
        $twitter = $_POST['twitter'];
        $data = ['twitter' => $twitter];
        $query->update('contact', $data, 'id = ?', [1], 'i');

        echo json_encode(['success' => true, 'message' => 'Twitter link has been updated!', 'twitter' => $twitter]);
        exit();
    }

    // Update Facebook link
    if (isset($_POST['facebook'])) {
        $facebook = $_POST['facebook'];
        $data = ['facebook' => $facebook];
        $query->update('contact', $data, 'id = ?', [1], 'i');

        echo json_encode(['success' => true, 'message' => 'Facebook link has been updated!', 'facebook' => $facebook]);
        exit();
    }

    // Update Instagram link
    if (isset($_POST['instagram'])) {
        $instagram = $_POST['instagram'];
        $data = ['instagram' => $instagram];
        $query->update('contact', $data, 'id = ?', [1], 'i');

        echo json_encode(['success' => true, 'message' => 'Instagram link has been updated!', 'instagram' => $instagram]);
        exit();
    }

    // Update LinkedIn link
    if (isset($_POST['linkedin'])) {
        $linkedin = $_POST['linkedin'];
        $data = ['linkedin' => $linkedin];
        $query->update('contact', $data, 'id = ?', [1], 'i');

        echo json_encode(['success' => true, 'message' => 'LinkedIn link has been updated!', 'linkedin' => $linkedin]);
        exit();
    }

    // Update Contact Box information
    foreach ($contact_box as $box) {
        $title_field = 'title-' . $box['id'];
        $value_field = 'value-' . $box['id'];

        if (isset($_POST[$title_field]) && isset($_POST[$value_field])) {
            $title = $_POST[$title_field];
            $value = $_POST[$value_field];

            $data = [
                'title' => $title,
                'value' => $value
            ];

            $query->update('contact_box', $data, 'id = ?', [$box['id']], 'i');
        }
    }

    echo json_encode($_POST);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/adminlte.min.css">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/sweetalert2-theme-bootstrap-4.css">
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <?php include 'header.php' ?>
        <div class="content-wrapper">

            <section class="content">
                <div class="container-fluid">

                    <!-- Contact Links Table -->
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>№</th>
                                <th>Social Media</th>
                                <th>Link</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $socials = ['twitter', 'facebook', 'instagram', 'linkedin'];
                            foreach ($socials as $index => $social) {
                                $socialLink = $contact[$social] ?? '';
                                ?>
                                <tr>
                                    <td><?php echo ($index + 1); ?></td>
                                    <td><?php echo ucfirst($social); ?></td>
                                    <td><?php echo $socialLink; ?></td>
                                    <td>
                                        <button class='btn btn-warning' data-bs-toggle='modal'
                                            data-bs-target='#contactModal-<?php echo $index; ?>'>Edit</button>
                                    </td>
                                </tr>

                                <div class='modal fade' id='contactModal-<?php echo $index; ?>' tabindex='-1'
                                    aria-labelledby='contactModalLabel-<?php echo $index; ?>' aria-hidden='true'>
                                    <div class='modal-dialog'>
                                        <div class='modal-content'>
                                            <div class='modal-header'>
                                                <h5 class='modal-title' id='contactModalLabel-<?php echo $index; ?>'>Edit
                                                    <?php echo ucfirst($social); ?>
                                                </h5>
                                                <button type="button" class="close" data-bs-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>

                                            <div class='modal-body'>
                                                <form id='contactForm-<?php echo $index; ?>' action='' method='POST'>
                                                    <div class='form-group'>
                                                        <label
                                                            for='<?php echo htmlspecialchars($social, ENT_QUOTES, 'UTF-8'); ?>'>
                                                            <?php echo ucfirst(htmlspecialchars($social, ENT_QUOTES, 'UTF-8')); ?>
                                                        </label>
                                                        <input type='text'
                                                            name='<?php echo htmlspecialchars($social, ENT_QUOTES, 'UTF-8'); ?>'
                                                            id='<?php echo htmlspecialchars($social, ENT_QUOTES, 'UTF-8'); ?>'
                                                            class='form-control'
                                                            value='<?php echo htmlspecialchars($socialLink, ENT_QUOTES, 'UTF-8'); ?>'
                                                            maxlength='255'>
                                                    </div>
                                                    <button type='submit' class='btn btn-primary'>Save</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </tbody>

                    </table>

                    <!-- Contact Box Table -->
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>№</th>
                                <th>Title</th>
                                <th>Value</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($contact_box as $index => $box) { ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td><?= htmlspecialchars($box['title']) ?></td>
                                    <td><?= htmlspecialchars($box['value']) ?></td>
                                    <td>
                                        <button class='btn btn-warning' data-bs-toggle='modal'
                                            data-bs-target='#contactBoxModal-<?= $box['id'] ?>'>Edit</button>
                                    </td>
                                </tr>

                                <!-- Individual modal for each contact box -->
                                <div class='modal fade' id='contactBoxModal-<?= $box['id'] ?>' tabindex='-1'
                                    aria-labelledby='contactBoxModalLabel-<?= $box['id'] ?>' aria-hidden='true'>
                                    <div class='modal-dialog'>
                                        <div class='modal-content'>
                                            <div class='modal-header'>
                                                <h5 class='modal-title' id='contactBoxModalLabel-<?= $box['id'] ?>'>Edit
                                                    <?= htmlspecialchars($box['title']) ?>
                                                </h5>
                                                <button type="button" class="close" data-bs-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class='modal-body'>
                                                <form id='contactBoxForm-<?= $box['id'] ?>' action='' method='POST'>
                                                    <div class='form-group'>
                                                        <label for='title-<?= $box['id'] ?>'>Title</label>
                                                        <input type='text' name='title-<?= $box['id'] ?>'
                                                            id='title-<?= $box['id'] ?>' class='form-control'
                                                            value='<?= htmlspecialchars($box['title']) ?>' maxlength='255'>
                                                    </div>
                                                    <div class='form-group'>
                                                        <label for='value-<?= $box['id'] ?>'><i
                                                                class='<?= htmlspecialchars($box['icon']) ?>'></i>
                                                            <?= htmlspecialchars($box['title']) ?></label>
                                                        <input type='text' name='value-<?= $box['id'] ?>'
                                                            id='value-<?= $box['id'] ?>' class='form-control'
                                                            value='<?= htmlspecialchars($box['value']) ?>' maxlength='255'>
                                                    </div>
                                                    <button type='submit' class='btn btn-primary'>Save</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </tbody>
                    </table>

                </div>
            </section>
        </div>

        <?php include 'footer.php'; ?>
    </div>

    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/sweetalert2.min.js"></script>
    <script src="../assets/js/adminlte.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function {
            <?php foreach ($socials as $index => $social) { ?>
                $('#contactForm-<?= $index ?>').on('submit', function (event) {
                    event.preventDefault();
                    $.ajax({
                        url: '',
                        method: 'POST',
                        data: $(this).serialize(),
                        success: function (response) {
                            const data = JSON.parse(response);
                            if (<?= $index ?> === 0) {
                                $('#twitter').val(data.twitter);
                                $('#facebook').val(data.facebook);
                                $('#instagram').val(data.instagram);
                                $('#linkedin').val(data.linkedin);
                            }
                            window.location.reload();
                        }
                    });
                });
            <?php } ?>

            <?php foreach ($contact_box as $box) { ?>
                $('#contactBoxForm-<?= $box['id'] ?>').on('submit', function (event) {
                    event.preventDefault();
                    $.ajax({
                        url: '',
                        method: 'POST',
                        data: $(this).serialize(),
                        success: function (response) {
                            const data = JSON.parse(response);
                            const titleField = 'title-' + <?= $box['id'] ?>;
                            const valueField = 'value-' + <?= $box['id'] ?>;
                            $('#' + titleField).val(data[titleField]);
                            $('#' + valueField).val(data[valueField]);
                            window.location.reload();
                        }
                    });
                });
            <?php } ?>
        });
    </script>

</body>

</html>