
$("#image-gallery").on('show.bs.modal', function (event) {
    loadGallery(event, $(this));
});

$('#image-gallery').on('hidden.bs.modal', function (e) {

})

function loadGallery(event, $modal) {
    let Target = $(event.relatedTarget); // Button that triggered the modal
    let image = Target.data('image');
    $('#image-gallery-image')
        .attr('src', image);
}