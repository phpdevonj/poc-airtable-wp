jQuery(document).ready(function() {


var $grid = jQuery('.grid').masonry({
  // options...
  itemSelector: '.grid-item',
  gutter: 20
});

$grid.imagesLoaded().progress( function() {
  $grid.masonry('layout');
});

});