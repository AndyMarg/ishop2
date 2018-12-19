<li>
    <a href="category/<?= $category['alias']; ?>"><?= $category['title']; ?></a>
    <?php if(isset($category['childs'])): ?>
        <?php echo "<{$this->containerHtmlTag}>";  ?> 
            <?= $this->getChildsHtml($category['childs']); ?> 
        <?php echo "</{$this->containerHtmlTag}>";  ?>  
    <?php endif; ?>
</li>