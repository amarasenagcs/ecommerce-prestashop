<?php
/* Smarty version 3.1.43, created on 2023-01-02 05:05:43
  from 'module:wbblocksearchviewstemplat' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.43',
  'unifunc' => 'content_63b2ac77f33c25_55384318',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b8de0f71efbe158c813f6cf11de131ef8ab551fc' => 
    array (
      0 => 'module:wbblocksearchviewstemplat',
      1 => 1671695906,
      2 => 'module',
    ),
  ),
  'cache_lifetime' => 31536000,
),true)) {
function content_63b2ac77f33c25_55384318 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!-- Block search module TOP -->
<div class="wbSearch col-xl-9 col-lg-9 col-md-8 col-sm-12 col-xs-12">
	<div id="search_block_top">
		<form id="searchbox" method="get" action="http://localhost/prestadefault/search" class="input-group">
		   
			<input type="hidden" name="controller" value="search">
			
			<input type="hidden" name="orderby" value="position" />
			<input type="hidden" name="orderway" value="desc" />
			<select id="search_category" name="search_category" class="form-control float-xs-left text-capitalize">
				<option value="all">All Categories</option>
				<option value="2">Home</option><option value="3">--Clothes</option><option value="4">----Men</option><option value="5">----Women</option><option value="6">--Accessories</option><option value="7">----Stationery</option><option value="8">----Home Accessories</option><option value="9">--Art</option>
			</select>
			<input class="search_query form-control float-xs-left text-capitalize" type="text" id="search_query_top" name="s" placeholder="Search entire store..." value="" />
			
			<div id="wb_url_ajax_search" style="display:none">
			<input type="hidden" value="http://localhost/prestadefault/modules/wbblocksearch/controller_ajax_search.php" class="url_ajax" />
			</div>
			<div class="input-group-btn">
				<button type="submit" name="submit_search" class="btn btn-default button-search">
					<svg width="18px" height="18px">
	                    <use xlink:href="#hsearch"></use>
	                  </svg>
				</button>
		    </div>
		</form>
		
	</div>
</div>

<script type="text/javascript">
var limit_character = "<p class='limit'>Number of characters at least are 3</p>";
var close_text = "close";
</script>
<!-- /Block search module TOP -->
<?php }
}
