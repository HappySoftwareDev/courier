<?php
/**
 * Placeholder Image Generator
 * Generates placeholder images as SVG
 */

$type = $_GET['type'] ?? 'logo';
$width = $_GET['w'] ?? 200;
$height = $_GET['h'] ?? 100;
$bg = $_GET['bg'] ?? '667eea';
$text = $_GET['text'] ?? 'Image';

// Sanitize inputs
$width = (int)$width;
$height = (int)$height;

header('Content-Type: image/svg+xml');
echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<svg width="<?php echo $width; ?>" height="<?php echo $height; ?>" xmlns="http://www.w3.org/2000/svg">
  <defs>
    <style>
      .placeholder-bg { fill: #<?php echo htmlspecialchars($bg); ?>; }
      .placeholder-text { font-family: Arial, sans-serif; font-size: 14px; fill: white; text-anchor: middle; }
    </style>
  </defs>
  
  <?php if ($type === 'logo'): ?>
    <!-- Logo Placeholder -->
    <rect width="<?php echo $width; ?>" height="<?php echo $height; ?>" class="placeholder-bg" rx="8"/>
    <text x="<?php echo $width/2; ?>" y="<?php echo $height/2 + 5; ?>" class="placeholder-text" font-weight="bold">
      WG ROOS
    </text>
  <?php elseif ($type === 'avatar'): ?>
    <!-- Avatar Placeholder -->
    <circle cx="<?php echo $width/2; ?>" cy="<?php echo $height/2; ?>" r="<?php echo min($width, $height)/2; ?>" class="placeholder-bg"/>
    <text x="<?php echo $width/2; ?>" y="<?php echo $height/2 + 5; ?>" class="placeholder-text" font-size="20" font-weight="bold">
      A
    </text>
  <?php else: ?>
    <!-- Generic Placeholder -->
    <rect width="<?php echo $width; ?>" height="<?php echo $height; ?>" class="placeholder-bg" rx="4"/>
    <text x="<?php echo $width/2; ?>" y="<?php echo $height/2 + 5; ?>" class="placeholder-text">
      <?php echo htmlspecialchars($text); ?>
    </text>
  <?php endif; ?>
</svg>
