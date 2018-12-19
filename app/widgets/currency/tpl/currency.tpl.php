<option value="" class="label"><?= $currency->code; ?></option>
<?php foreach($currencies as $key => $value): ?>
    <?php if($value->code !== $currency->code): ?>
        <option value="<?= $value->code; ?>"><?= $value->code; ?></option>
    <?php endif; ?>
<?php endforeach; ?>

        


        