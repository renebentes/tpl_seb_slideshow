<?php
/**
 * @package     Thumbs
 * @subpackage  tpl_seb_thumbs
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
$items = $cck->getItems();
$count = count($items);
$id    = !empty($cck->id_class) ? trim($cck->id_class) : 'generic-slideshow';

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
<div id="<?php echo $id; ?>" class="carousel<?php echo $cck->getStyleParam('event') == 1 ? ' slide' : null; ?>" data-ride="carousel">
	<ol class="carousel-indicators">
  <?php for($i = 0; $i < $count; $i++) : ?>
    <li data-target="#<?php echo $id; ?>" data-slide-to="<?php echo $i ?>"<?php echo $i == 0 ? ' class="active"' : null;?>></li>
  <?php endfor; ?>
  </ol>
	<div class="carousel-inner" role="listbox">
	<?php foreach ($items as $key => $item) : ?>
		<div class="item<?php echo $key == 0 ? ' active' : null; ?>">
			<?php echo $cck->renderItem($key); ?>
		</div>
	<?php endforeach; ?>
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