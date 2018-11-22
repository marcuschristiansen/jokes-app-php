<?php 
include "templates/header.php"; 
include "../functions.php";
?>

<?php if(isset($_POST['submit'])) {
    if(add_rating($_POST['rating'])) {
        $result['status'] = 'success';
        $result['message'] = 'Rating successfully added';
    } else {
        $result['status'] = 'danger';
        $result['message'] = 'Could not add rating.';
    }
} ?>

<?php $joke = get_joke(); ?>

<h1 class="text-center"><?php echo $joke['setup']; ?></h1>
<h1 class="text-center"><i><?php echo $joke['punchline']; ?></i></h1>

<?php if($result) : ?>
    <div class="alert alert-<?php echo $result['status'] ?>" role="alert"><?php echo $result['message']; ?></div>
<?php endif; ?>

<form action="" method="post">
    <select name="rating" id="" class="form-control">
        <option value="1">What? (1/5)</option>
        <option value="2">Get out of here! (2/5)</option>
        <option value="3">Meh! (3/5)</option>
        <option value="4">Not bad! (4/5)</option>
        <option value="5">Brilliant! (5/5)</option>
    </select>
    <input type="submit" name="submit" value="Rate!" class="btn btn-primary">
</form>

<?php include "templates/footer.php"; ?>