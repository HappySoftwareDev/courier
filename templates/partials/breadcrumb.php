<?php
/**
 * Breadcrumb Navigation Partial
 */
?>
<nav aria-label="breadcrumb" class="breadcrumb-wrapper">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="<?php echo baseUrl(); ?>">
                <i class="fas fa-home"></i> Home
            </a>
        </li>
        <?php foreach ($breadcrumbs as $index => $breadcrumb): ?>
            <?php $isLast = ($index === count($breadcrumbs) - 1); ?>
            <li class="breadcrumb-item <?php echo $isLast ? 'active' : ''; ?>">
                <?php if (!$isLast && !empty($breadcrumb['url'])): ?>
                    <a href="<?php echo $breadcrumb['url']; ?>">
                        <?php echo $breadcrumb['name']; ?>
                    </a>
                <?php else: ?>
                    <?php echo $breadcrumb['name']; ?>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ol>
</nav>


