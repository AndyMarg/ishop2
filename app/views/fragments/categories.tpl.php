<?php  $categories = $categories->getFlatTree(); ?>

<select class="form-control" name="parent_id" id="parent">
    <option value="0" name="parent_id">Самостоятельная категория</option>
    <?php foreach ($categories as $category): ?>
        <option value="<?=$category['id']?>" name="parent_id"><?=str_repeat('&nbsp', $category['level']*10) . $category['title']?></option>
    <?php endforeach; ?>
</select>