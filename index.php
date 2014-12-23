<?php
/**
 * @package     Slideshow
 * @subpackage  tpl_seb_slideshow
 * @copyright   Copyright (C) 2014 Rene Bentes Pinto, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see http://www.gnu.org/licenses/gpl-2.0.html
 */

// No direct access.
defined('_JEXEC') or die('Restricted access!');

// -- Initialize
require_once dirname(__FILE__) . '/config.php';

$cck = CCK_Rendering::getInstance($this->template);
if ($cck->initialize() === false)
	return;

// -- Prepare
$items      = $cck->getItems();
$itemsSlide = $cck->getStyleParam('slide_items');
$id         = !empty($cck->id_class) ? trim($cck->id_class) : 'generic-slideshow';
$count      = 0;

if ($cck->getStyleParam('navigator') == 1)
{
	$navLeft  = 'glyphicon glyphicon-chevron-left';
	$navRight = 'glyphicon glyphicon-chevron-right';
}
elseif ($cck->getStyleParam('navigator') == 2)
{
	$navLeft  = 'fa fa-chevron-left';
	$navRight = 'fa fa-chevron-right';
}
elseif ($cck->getStyleParam('navigator') == 0)
{
	$navLeft  = 'icon-prev';
	$navRight = 'icon-next';
}
else
{
  $navLeft  = '';
  $navRight = '';
}

// -- Render
if (!empty($items)) : ?>
<div id="<?php echo $id; ?>" class="carousel slide" data-ride="carousel">
	<ol class="carousel-indicators">
  <?php for ($i = 0; $i < round(count($items) / $itemsSlide); $i++) : ?>
    <li data-target="#<?php echo $id; ?>" data-slide-to="<?php echo $i ?>"<?php echo $i == 0 ? ' class="active"' : null;?>></li>
  <?php endfor; ?>
  </ol>
	<div class="carousel-inner" role="listbox">
	<?php foreach (array_chunk($items, $itemsSlide, true) as $row) : ?>
		<div class="item<?php echo $count == 0 ? ' active' : null; ?>">
    <?php if ($itemsSlide > 1) : ?>
      <div class="row">
    <?php endif; ?>
    <?php foreach ($row as $key => $item) :
      if ($itemsSlide > 1) : ?>
        <div class="col-md-<?php echo round(12 / $itemsSlide); ?>">
      <?php endif; ?>
		      <?php echo $cck->renderItem($key); ?>
      <?php if ($itemsSlide > 1) : ?>
        </div>
      <?php endif; ?>
    <?php endforeach; ?>
    <?php if ($itemsSlide > 1) : ?>
      </div>
    <?php endif; ?>
		</div>
	<?php $count++;
  endforeach; ?>
	</div>
<?php if($count > 1 && $cck->getStyleParam('navigator') != -1) : ?>
  <a class="left carousel-control" href="#<?php echo $id; ?>" role="button" data-slide="prev">
  	<span class="<?php echo $navLeft; ?>"></span>
  	<span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#<?php echo $id; ?>" role="button" data-slide="next">
  	<span class="<?php echo $navRight; ?>"></span>
  	<span class="sr-only">Next</span>
  </a>
<?php endif; ?>
</div>
<?php endif;

// -- Finalize
$cck->finalize(); ?>