{*
* 2007-2018 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2018 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

<div class="home_blog_post_area {$wbbdp_designlayout} {$hookName}">
	<div class="home_blog_post">
 <div class="page_title_area">
			{if isset($wbbdp_title)}
			     <div class="left-home-heading"><span>{$wbbdp_title}</span></div>
				
			{/if}
			<!-- {if isset($wbbdp_subtext)}
				<p class="page_subtitle">{$wbbdp_subtext}</p>
			{/if} -->
			{* <div class="heading-line d_none"><span></span></div> *}
		</div>
		<div class="home_blog_post_inner blog">
		{* <div id="blog" class="home_blog_post_inner owl-carousel owl-theme"> *}
		{if (isset($wbblogposts) && !empty($wbblogposts))}
			{foreach from=$wbblogposts item=wbblgpst}
				<article class="blog_post">
					<div class="blog_post_content col-xs-12">
						<div class="blog_post_content_top col-xs-4">
							<div class="post_thumbnail">
								{if $wbblgpst.post_format == 'video'}
									{assign var="postvideos" value=','|explode:$wbblgpst.video}
									{if $postvideos|@count > 1 }
										{include file="module:wbblog/views/templates/front/post-video.tpl" videos=$postvideos width='570' height="316" class="carousel"}
									{else}
										{include file="module:wbblog/views/templates/front/post-video.tpl" videos=$postvideos width='570' height="316" class=""}
									{/if}
								{elseif $wbblgpst.post_format == 'audio'}
									{assign var="postaudio" value=','|explode:$wbblgpst.audio}
									{if $postaudio|@count > 1 }
										{include file="module:wbblog/views/templates/front/post-audio.tpl" audios=$postaudio width='570' height="316" class="carousel"}
									{else}
										{include file="module:wbblog/views/templates/front/post-audio.tpl" audios=$postaudio width='570' height="316" class=""}
									{/if}
								{elseif $wbblgpst.post_format == 'gallery'}
									{if $wbblgpst.gallery_lists|@count > 1 }
										{include file="module:wbblog/views/templates/front/post-gallery.tpl" gallery=$wbblgpst.gallery_lists imagesize="home_blog" class="carousel"}
									{else}
										{include file="module:wbblog/views/templates/front/post-gallery.tpl" gallery=$wbblgpst.gallery_lists imagesize="home_blog" class=""}
									{/if}
								{else}
									<img class="wbblog_img img-responsive" src="{$wbblgpst.post_img_home_blog}" alt="{$wbblgpst.post_title}">
										{* <div class="blog_mask content">
											<div class="blog_mask_content">
											<a class="thumbnail_lightbox" href="{$wbblgpst.post_img_large}" data-lightbox="example-set">
											<i class="sicon fa fa-search"></i>
											</a>
											</div>
										</div> *}
										

								{/if}
							</div>
						</div>
						<div class="blog_post_content_bottom col-xs-8">
							<div class="post_meta clearfix">
								{* <p class="meta_date">
									<span class="btb">
									<span class="month">{$wbblgpst.post_date|date_format:"%d"}</span><br>
									<span class="date">{$wbblgpst.post_date|date_format:"%b"}</span>
									</span>
								</p> *}
								{* <span class="bseprato">/</span> *}
								{* <p class="meta_author">
									<span>{$wbblgpst.post_author_arr.firstname} {$wbblgpst.post_author_arr.lastname}</span>
								</p> *}
							</div>
							<h3 class="post_title"><a href="{$wbblgpst.link}">{$wbblgpst.post_title|truncate:40:' ...'}</a></h3>
							<div class="blog-name"><span class="bdate">{$wbblgpst.post_date|date_format:"%b %d , %Y"}</span></div>
							{* <div class="post_content">
								{if isset($wbblgpst.post_excerpt) && !empty($wbblgpst.post_excerpt)}
									<p>{$wbblgpst.post_excerpt|truncate:80:' ...'|escape:'html':'UTF-8'}</p>
								{else}
									<p>{$wbblgpst.post_content|truncate:80:' ...'|escape:'html':'UTF-8'}</p>
								{/if}
							</div> *}
							{* <div class="content_more">
								<a class="read_more" href="{$wbblgpst.link}">{l s='Read More' mod='wbblog'}&nbsp;<i class="fa fa-angle-double-right"></i>
								</a>
							</div> *}
						</div>
					</div>
					{* <a  href="{$wbblgpst.category_def_arr.link}">view all</a> *}
				</article>
			{/foreach}
		{else}
			<p>{l s='No Blog Post Found' mod='wbblog'}</p>
		{/if}
		{* </div> *}
		</div>
	</div>
</div>
