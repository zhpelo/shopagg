<section id="box-categories" class="box">
    <div class="card-header">
        <h1 class="card-title"><?php echo language::translate('title_browse_by_category', 'Browse By Category'); ?></h1>
    </div>

    <div class="card-body">
        <div class="listing categories">
            <?php foreach ($categories as $category) echo functions::draw_listing_category($category); ?>
        </div>
    </div>
</section>