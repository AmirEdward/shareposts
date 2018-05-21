<?php require_once APPROOT . '/views/inc/header.php'; ?>
<?php $post = $data['post'];
$user = $data['user']; ?>
<a href="<?php echo URLROOT; ?>/posts" class="btn btn-light"><i class="fa fa-backward"></i> Back</a>
<br>
<h1><?php echo $post->title; ?></h1>
<div class="bg-secondary text-white p-2 mb-3">
    Written by: <?php echo $user->name; ?> On <?php echo $post->created_at; ?>
</div>
<p><?php echo $post->body; ?></p>

<?php if($post->user_id == $_SESSION['user_id']): ?>
    <hr>
    <a href="<?php echo URLROOT ?>/posts/edit/<?php echo $post->id ?>" class="btn btn-dark">Edit</a>

    <form class="float-right" action="<?php echo URLROOT; ?>/posts/delete/<?php echo $post->id; ?>" method="post">
        <input type="submit" value="Delete" class="btn btn-danger">
    </form>
<?php endif; ?>
<?php require_once APPROOT . '/views/inc/footer.php'; ?>
