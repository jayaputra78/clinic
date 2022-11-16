
$('.form-btn-disabled').submit(function () {
    $('.btn-disabled').html('Please Wait...').attr('disabled', true);
    $(this).LoadingOverlay("show", {
        image: "",
        fontawesome: "fa fa-refresh fa-spin",
        size: 7
    });
});

function overlayFalse() {
    $('.btn-disabled').html('Submit').attr('disabled', false);
    $('.form-btn-disabled').LoadingOverlay("hide");
}

function toastSuccess(message) {
    toastr.info(message, 'Berhasil',
        {
            "showMethod": "slideDown",
            "closeButton": true,
            timeOut: 3000
        });
}

function toastWarning(message) {
    toastr.warning(message, 'Berhasil',
        {
            "showMethod": "slideDown",
            "closeButton": true,
            timeOut: 3000
        });
}

$(document).ready(function () {
    $(".select2").select2({
        dropdownAutoWidth: true,
        width: '100%'
    });
});