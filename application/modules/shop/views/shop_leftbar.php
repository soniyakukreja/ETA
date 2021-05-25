<?php
$sort='';
$catid='0';
if(!empty($_GET['catid'])){ $catid = $_GET['catid'];	} 
if(!empty($_GET['sort'])){ $sort = $_GET['sort'];}
?>
<div class="aside">
	<h3>Shop</h3>
	<form class="shopForm">
		<input type="text" name="search_field" id="search_field" class="form-control" placeholder="Search...">
		<input type="hidden" name="search_pid" id="search_pid">
		<div style="position:relative;">
			<ul  style="position:absolute;z-index:111;cursor:pointer;width:100%;" class="list-group" id="prod_search_container">
			</ul>
		</div>	
	</form>
	<ul>
		<li>
			<a href="javascript:void(0)" id="0" class="searchbycat active">All Products</a>
		</li>
		<li>
			<a href="#">Shop by Category</a>
			<ul>
				<input type="hidden" id="catid" value="<?php echo $catid; ?>" />
				<?php if(!empty($prod_cat)){ foreach($prod_cat as $key=>$cat){ ?>
				<li>
					<a href="javascript:void(0)" class="searchbycat <?php if($catid==$cat['prod_cat_id']){ echo 'active'; } ?>" id="<?php echo $cat['prod_cat_id']; ?>"><?php echo $cat['prod_cat_name']; ?></a>
				</li>
				<?php } } ?>
			</ul>
		</li>
	</ul>
	<div class="sortBy">
		<form class="shopForm">
			<label>Sort by</label>
			<select class="form-control" id="sort_by" name="sort_by">
				<!-- <option value="popular">Most Popular</option> -->
				<option value="name_asc" <?php if($sort=='name_asc'){ echo 'selected'; } ?> >Alphabatically A-Z</option>
				<option value="name_desc" <?php if($sort=='name_desc'){ echo 'selected'; } ?> >Alphabatically Z-A</option>
				<option value="price_asc" <?php if($sort=='price_asc'){ echo 'selected'; } ?> >Price Low to High</option>
				<option value="price_desc" <?php if($sort=='price_desc'){ echo 'selected'; } ?> >Price High to Low</option>
				<option value="date_asc" <?php if($sort=='date_asc'){ echo 'selected'; } ?> >Date Old to New</option>
				<option value="date_desc" <?php if($sort=='date_desc'){ echo 'selected'; } ?> >Date New to Old</option>
			</select>
		</form>
	</div>
</div>
