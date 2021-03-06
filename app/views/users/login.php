<?php require_once APPROOT . '/views/inc/header.php'; ?>

<?php
$validEmail = (! empty($data['email_err'])) ? 'is-invalid' : '';
$validPassword = (! empty($data['password_err'])) ? 'is-invalid' : '';
?>

    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card card-body bg-light mt-5">
                <?php flash('register_success'); ?>
                <h2 class="text-center">Login</h2>
                <p class="text-center text-muted">Please fill in your credentials to login</p>
                <form action="<?php echo URLROOT; ?>/users/login" method="POST">
                    <div class="form-group">
                        <label for="email">Email: <sup>*</sup></label>
                        <input type="email" name="email" class="form-control form-control-lg <?php echo $validEmail; ?>" value="<?php echo $data['email']; ?>">
                        <span class="invalid-feedback"><?php echo $data['email_err']; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="password">Password: <sup>*</sup></label>
                        <input type="password" name="password" class="form-control form-control-lg <?php echo $validPassword; ?>" value="<?php echo $data['password']; ?>">
                        <span class="invalid-feedback"><?php echo $data['password_err']; ?></span>
                    </div>

                    <div class="row">
                        <div class="col">
                            <input type="submit" name="" value="Login" class="btn btn-outline-primary btn-block">
                        </div>
                        <div class="col">
                            <a href="<?php echo URLROOT; ?>/users/register" class="btn btn-link btn-block">No account? Register</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


<?php require_once APPROOT . '/views/inc/footer.php'; ?>