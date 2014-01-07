
<?php

/**
 * The template for displaying Search form.
 *
 * @package WordPress
 * @subpackage JBlog
 * @since JBlog 1.0
 * 
 */

?>

<form class="form-inline" role="search" method="get" id="searchform" action="<?php echo home_url( '/' ); ?>">
    <div class="form-group jblog-search-field">
        <input class="form-control" type="text" value="" name="s" id="s" placeholder="Search" />
    </div>
	<button type="submit" class="btn btn-default jblog-search-btn" id="searchsubmit" value="Search">Search</button>
</form>