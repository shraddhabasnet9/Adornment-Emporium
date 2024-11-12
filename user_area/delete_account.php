<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Account</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <h3 class="text-center text-danger mb-4">Delete Account</h3>
    <form action="" method="post" class="mt-4">
        <div class="form-outline mb-4">
            <!-- Delete Button triggers modal -->
            <button type="button" class="btn btn-danger w-50 m-auto d-block" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal">
                Delete Account
            </button>
        </div>
        <div class="form-outline mb-4">
            <!-- No confirmation needed for Don't Delete -->
            <input type="submit" class="form-control w-50 m-auto" name="dont_delete" value="Don't Delete Account">
        </div>
    </form>

    <!-- Bootstrap Modal -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete your account? This action cannot be undone.
                </div>
                <div class="modal-footer">
                    <form action="" method="post">
                        <!-- If confirmed, submit form to delete account -->
                        <input type="hidden" name="confirm_delete" value="true">
                        <button type="submit" name="delete" class="btn btn-danger">Yes</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php
        @session_start();
        $username_session = $_SESSION['username']; // Assuming session is started and username is stored
        if (isset($_POST['delete'])) {
            $delete_query = "DELETE FROM user_table WHERE user_name='$username_session'";
            $result_delete = mysqli_query($conn, $delete_query);
            if ($result_delete) {
                session_destroy();
                echo "<script>alert('Account deleted successfully');</script>";
                echo "<script>window.open('../index.php', '_self');</script>";
            }
        }

        if (isset($_POST['dont_delete'])) {
            echo "<script>window.open('profile.php', '_self');</script>";
        }
    ?>
    
    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>