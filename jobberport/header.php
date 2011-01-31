<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <title><?=$meta['title'];?></title>
    <meta name="description" content="<?=$meta['description'];?>" />
    <meta name="keywords" content="<?=$meta['keywords'];?>" />
    <meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />
	<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />
	<link rel="stylesheet" href="theme/css/screen.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="theme/css/print.css" media="print" type="text/css" />
	<script src="theme/js/jquery.js" type="text/javascript"></script>
	<!--[if !IE]><script src="theme/js/jquery.history.js" type="text/javascript"></script><![endif]-->
 	<script src="theme/js/jquery.form.js" type="text/javascript"></script>
	<script src="theme/js/cmxforms.js" type="text/javascript"></script>
	<script src="theme/js/jquery.metadata.js" type="text/javascript"></script>
	<script src="theme/js/jquery.validate.min.js" type="text/javascript"></script>
	<script src="theme/js/functions.js" type="text/javascript"></script>
	<style>
		a#link {
		background-image: initial; background-attachment: initial; background-origin: initial; background-clip: initial; border-top-width: 0px; border-right-width: 0px; border-bottom-width: 0px; border-left-width: 0px; border-style: initial; border-color: initial; font-size: 100%; margin-top: 0px; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; outline-width: 0px; outline-style: initial; outline-color: initial; padding-top: 0px; padding-right: 0px; padding-bottom: 0px; padding-left: 0px; vertical-align: baseline; display: inline; background-position: initial initial; background-repeat: initial initial;
		}</style>
</head>
<body>
	<div id="container">
		<div id="header">
			<h1 id="logo"><a href="index.php"></a></h1>
				<ul id="top">
					<li>
						<strong>
						<a href="http://twitter.com/jobber_ro" class=link>@ Jobber_ro</a>
						</strong>
					</li>
					<li>
						<font class=link>•</font>
					</li>
					<li>
						<a href="http://www.jobber.ro/premium/" class=link>
							Premium Services						
						</a>
					</li>
					<li>
						<font style="background-image: initial; background-attachment: initial; background-origin: initial; background-clip: initial; background-color: transparent; border-top-width: 0px; border-right-width: 0px; border-bottom-width: 0px; border-left-width: 0px; border-style: initial; border-color: initial; font-size: 100%; margin-top: 0px; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; outline-width: 0px; outline-style: initial; outline-color: initial; padding-top: 0px; padding-right: 0px; padding-bottom: 0px; padding-left: 0px; vertical-align: baseline; display: inline; background-position: initial initial; background-repeat: initial initial; ">
						<font style="background-image: initial; background-attachment: initial; background-origin: initial; background-clip: initial; background-color: transparent; border-top-width: 0px; border-right-width: 0px; border-bottom-width: 0px; border-left-width: 0px; border-style: initial; border-color: initial; font-size: 100%; margin-top: 0px; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; outline-width: 0px; outline-style: initial; outline-color: initial; padding-top: 0px; padding-right: 0px; padding-bottom: 0px; padding-left: 0px; vertical-align: baseline; display: inline; background-position: initial initial; background-repeat: initial initial; ">•</font>
						</font>
					</li>
					<li>
						<a href="http://www.jobber.ro/contact/" title="Pentru orice mărunţiş, scrie-ne!">
						<font style="background-image: initial; background-attachment: initial; background-origin: initial; background-clip: initial; background-color: transparent; border-top-width: 0px; border-right-width: 0px; border-bottom-width: 0px; border-left-width: 0px; border-style: initial; border-color: initial; font-size: 100%; margin-top: 0px; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; outline-width: 0px; outline-style: initial; outline-color: initial; padding-top: 0px; padding-right: 0px; padding-bottom: 0px; padding-left: 0px; vertical-align: baseline; display: inline; background-position: initial initial; background-repeat: initial initial; ">
						<font style="background-image: initial; background-attachment: initial; background-origin: initial; background-clip: initial; background-color: transparent; border-top-width: 0px; border-right-width: 0px; border-bottom-width: 0px; border-left-width: 0px; border-style: initial; border-color: initial; font-size: 100%; margin-top: 0px; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; outline-width: 0px; outline-style: initial; outline-color: initial; padding-top: 0px; padding-right: 0px; padding-bottom: 0px; padding-left: 0px; vertical-align: baseline; display: inline; background-position: initial initial; background-repeat: initial initial; ">contact</font>
						</font>
						</a>
					</li>
				</ul>
			<div id="the_feed">
				<a href="{$BASE_URL}rss/all/" title="{$translations.header.rss_title}"><img src="{$BASE_URL}_templates/{$THEME}/img/bt-rss.png" alt="{$translations.header.rss_alt}" /></a>
			</div>
		</div><!-- #header -->
		
		<div id="box">
			<div id="search">
				<form id="search_form" method="post" action="{$BASE_URL}search/">
					<fieldset>
						<div>
							<input type="text" name="keywords" id="keywords" maxlength="30" value="{if $keywords}{$keywords}{else}{$translations.search.default}{/if}" />
							<span id="indicator" style="display: none;"><img src="{$BASE_URL}_templates/{$THEME}/img/ajax-loader.gif" alt="" /></span>
						</div>
						<div><label class="suggestionTop">{$translations.search.example}</label></div>
					</fieldset>
				</form>
			</div><!-- #search -->
			{if $smarty.const.ENABLE_NEW_JOBS}
			<div class="addJob">
				<a href="{$BASE_URL}post/" title="{$translations.search.submit_title}" class="add">{$translations.search.submit}</a>
			</div><!-- .addJob -->
			{/if}
		</div><!-- #box -->
		
    <div id="categs-nav">
    	<ul>
			{section name=tmp loop=$categories}
				<li id="{$categories[tmp].var_name}" {if $current_category == $categories[tmp].var_name}class="selected"{/if}><a href="{$BASE_URL}{$URL_JOBS}/{$categories[tmp].var_name}/" title="{$categories[tmp].name}"><span>{$categories[tmp].name}</span><span class="cnr">&nbsp;</span></a></li>
			{/section}
    	</ul>
	</div><!-- #categs-nav -->
	<div class="clear"></div>
		
	<div id="sidebar">
		{include file="sidebar.tpl"}
	</div><!-- #sidebar -->
