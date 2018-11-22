<?php 
include "templates/header.php"; 
include "../functions.php";
?>

<?php 
    if(isset($_POST['login'])) {
        $login_successful = attempt_login($_POST['email'], $_POST['password']); 
        
        if(!$login_successful) {
            $message = 'Login unsuccessful. User not found!';
        }
    }
?>

<div class="row">
    <div class="col-md-6 mx-auto">
        <?php if($message) : ?>
            <div class="alert alert-danger" role="alert"><?php echo $message; ?></div>
        <?php endif; ?>
        <h1 class="text-center">Jokes App</h1>
        <h3 class="text-center">Login</h3>
        <form action="" method="post">
            <div class="form-group">
                <label for="email"></label>
                <input type="text" name="email" id="" class="form-control" value="marcus@codespace.co.za">
            </div>
            <div class="form-group">
                <label for="password"></label>
                <input type="password" name="password" class="form-control" value="p@55word">
            </div>
            <div class="form-group">
                <input type="submit" value="Login" name="login" class="btn btn-primary">
            </div>
        </form>
    </div>
</div>

<?php include "templates/footer.php"; ?>