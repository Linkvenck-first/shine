<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_breadcrumbs
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::_('bootstrap.tooltip');

$app        = JFactory::getApplication();
$menuitem   = $app->getMenu()->getActive(); // get the active item
$m_params   = $menuitem->params; // get the params Menu

if (isset($menuitem) && $menuitem != '') {
	$m_params   = $menuitem->params; // get the params Menu
	$page_title = $m_params->get('page_title','');
}
?>
<div class="jsn-breadcrumb">
	<div class="row">
		<div class="container">
			<?php if( isset($page_title) && $page_title != '' ) { echo '<h2>' . $page_title . '</h2>'; }?>
			<ul itemscope itemtype="https://schema.org/BreadcrumbList" class="breadcrumb<?php echo $moduleclass_sfx; ?>">
				<?php if ($params->get('showHere', 1)) : ?>
					<li>
						<?php echo JText::_('MOD_BREADCRUMBS_HERE'); ?>&#160;
					</li>
				<?php else : ?>
					<li class="active">
						<i class="fa fa-home" aria-hidden="true"></i>
					</li>
				<?php endif; ?>

				<?php
				// Get rid of duplicated entries on trail including home page when using multilanguage
				for ($i = 0; $i < $count; $i++)
				{
					if ($i == 1 && !empty($list[$i]->link) && !empty($list[$i - 1]->link) && $list[$i]->link == $list[$i - 1]->link)
					{
						unset($list[$i]);
					}
				}

				// Find last and penultimate items in breadcrumbs list
				end($list);
				$last_item_key   = key($list);
				prev($list);
				$penult_item_key = key($list);

				// Make a link if not the last item in the breadcrumbs
				$show_last = $params->get('showLast', 1);

				// Generate the trail
				foreach ($list as $key => $item) :
					if ($key != $last_item_key) :
						// Render all but last item - along with separator ?>
						<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
							<?php if (!empty($item->link)) : ?>
								<a itemprop="item" href="<?php echo $item->link; ?>" class="pathway"><span itemprop="name"><?php echo $item->name; ?></span></a>
							<?php else : ?>
								<span itemprop="name">
						<?php echo $item->name; ?>
					</span>
							<?php endif; ?>

							<?php if (($key != $penult_item_key) || $show_last) : ?>
								<!--					<span class="divider">-->
								<!--						--><?php //echo $separator; ?>
								<!--					</span>-->
							<?php endif; ?>
							<meta itemprop="position" content="<?php echo $key + 1; ?>">
						</li>
					<?php elseif ($show_last) :
						// Render last item if reqd. ?>
						<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" class="active">
				<span itemprop="name">
					<?php echo $item->name; ?>
				</span>
							<meta itemprop="position" content="<?php echo $key + 1; ?>">
						</li>
					<?php endif;
				endforeach; ?>
			</ul>
		</div>
	</div>
</div>