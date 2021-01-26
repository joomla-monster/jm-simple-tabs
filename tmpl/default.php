<?php
/*
 * Copyright (C) joomla-monster.com
 * Website: http://www.joomla-monster.com
 * Support: info@joomla-monster.com
 *
 * JM Simple Tabs is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * JM Simple Tabs is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with JM Simple Tabs. If not, see <http://www.gnu.org/licenses/>.
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

$tcount = 0;
$ccount = 0;

?>
<div id="<?php echo $id; ?>" class="jmm-simple-tabs <?php echo $theme_class . ' ' . $mod_class_suffix; ?>" data-align="<?php echo $align_class; ?>" data-orientation="<?php echo $orientation; ?>" <?php echo $breakpoint; ?>>
	<div class="jmm-simple-tabs-in <?php echo $align_class; ?>">
		<ul class="nav nav-tabs" id="<?php echo $tabs_id; ?>" role="tablist">
			<?php foreach($output_data as $item) {
				$tcount++;

				$item_class = '';
				$aria_attr = ' aria-selected="false" tabindex="-1"';

				if( $tcount === 1 ) { //active element
					$item_class = 'active';
					$aria_attr = ' aria-selected="true" tabindex="0"';
				} elseif( $tcount === 2 ) { //next element
					$item_class = 'next';
				}

				$sanitized = preg_replace( '|%[a-fA-F0-9][a-fA-F0-9]|', '', $item->title );
				$sanitized = preg_replace( '/[^A-Za-z0-9_-]/', '', $sanitized );

				$tabID = $sanitized.'-tab'.$tcount.'-'.$moduleId;
				$panelID = $sanitized.'-panel'.$tcount.'-'.$moduleId;
				
				$image_hover_class = ( !empty($item->image_icon) && !empty($item->image_icon_active) ) ? ' class="image-2src"' : '';
			?>
			<li class="<?php echo $item_class; ?>">
				<a href="#<?php echo $panelID; ?>" id="<?php echo $tabID; ?>" <?php echo $image_hover_class; ?> data-toggle="tab" aria-controls="<?php echo $panelID; ?>" role="tab" <?php echo $aria_attr; ?>>
				<?php
				if( !empty($item->image_icon) ) {

					if( !empty($item->image_icon) ) {
						echo '<span class="jmm-icon image"><img src="' . $item->image_icon . '" alt=""></span>';
					}
					if( !empty($item->image_icon_active) ) {
						echo '<span class="jmm-icon image image-hover"><img src="' . $item->image_icon_active . '" alt=""></span>';
					}

				} elseif( !empty($item->icon) ) {
					echo '<span class="jmm-icon"><span class="' . $item->icon . '"></span></span>';
				}
				?>
					<span class="jmm-title"><?php echo $item->title; ?></span>
				<?php
					if( $item->subtitle ) {
						echo '<span class="jmm-subtitle">' . $item->subtitle . '</span>';
					}
				?>
				</a>
			</li>
			<?php } ?>
		</ul>
		<div class="tab-content">
			<?php foreach($output_data as $item) {
				$ccount++;
				$item_class = ( $ccount === 1 ) ? 'in active' : '';
				$tabindex = ( $ccount === 1 ) ? ' tabindex="0"' : ' tabindex="-1"';

				$sanitized = preg_replace( '|%[a-fA-F0-9][a-fA-F0-9]|', '', $item->title );
				$sanitized = preg_replace( '/[^A-Za-z0-9_-]/', '', $sanitized );

				$tabID = $sanitized.'-tab'.$ccount.'-'.$moduleId;
				$panelID = $sanitized.'-panel'.$ccount.'-'.$moduleId;
			?>
				<div class="tab-pane fade <?php echo $item_class; ?>" id="<?php echo $panelID; ?>" aria-labelledby="<?php echo $tabID; ?>" role="tabpanel" <?php echo $tabindex; ?>>
					<?php
						if( ! function_exists('video_wrapper') ) {
							function video_wrapper($content) {
								// match any iframes
								$pattern = '~<iframe.*</iframe>|<embed.*</embed>~';
								preg_match($pattern, $content, $matches);
								// wrap matched iframe with div
								if( !empty($matches) ) {
									$wrappedframe = '<div class="video-container">' . $matches[0] . '</div>';
									//replace original iframe with new in content
									$content = str_replace($matches[0], $wrappedframe, $content);
								}

								return $content;
							}
						}

						if( !empty($video_responsive) && $video_responsive == 1 ) {
							echo video_wrapper($item->content);
						} else {
							echo JHtml::_('content.prepare', $item->content);
						}

					?>
				</div>
			<?php } ?>
		</div>
	</div>
</div>
