<?php if(!empty($filters->getFilterGroups())): ?>
    <?php foreach ($filters->getFilterGroups() as $filter_id => $filter_name): ?>
        <section  class="sky-form">
            <h4><?=$filter_name?></h4>
            <div class="row1 scroll-pane">
                <div class="col col-4">
                    <?php foreach ($filters->getFilterGroup($filter_id) as $filter): ?>
                        <?php $checked = (!empty($filter_active) && in_array($filter->id, $filter_active)) ? ' checked ' : '' ?>
                        <label class="checkbox">
                            <input class="filter-value" type="checkbox" name="checkbox" value="<?=$filter->id?>" <?=$checked?> ><i></i><?=$filter->value?>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endforeach; ?>
<?php endif; ?>
