$('.select2-multiple').select2();
$('#give_to_role').on('select2:select', function (e) {
    window.livewire.emit('data_manager', {"give_to_role": $('#give_to_role').val()});
});
$('#give_to_user').on('select2:select', function (e) {
    window.livewire.emit('data_manager', {"give_to_user": $('#give_to_user').val()});
});
window.addEventListener('refresh', event => {
    $('[data-toggle="tooltip"]').tooltip("dispose");
    $('[data-toggle="tooltip"]').tooltip();
    $('.select2-multiple').select2();
});
