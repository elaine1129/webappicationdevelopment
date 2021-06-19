<?php if(count($errors)>0):?>
<div class="error">
    <?php foreach($errors as $error):?>
    <p><?php echo $error?></p>
    <?php endforeach?>
</div>
<?php endif ?>

<style>
    .error{
        font-size:15px; 
        color: red;
        text-align:center;
        margin:0px 0px 3px 0px;
    }
</style>