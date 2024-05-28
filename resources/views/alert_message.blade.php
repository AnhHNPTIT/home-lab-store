@if(Session::has('successfully'))
    <div class="hidden alert-msg">
        {!!Session::get('successfully')!!}
    </div>
    <br>

    <script>
        $(function () {
            showMessageSuccess();
            function showMessageSuccess() {
                var $alert = $('.alert-msg');
                if ($alert.length) {
                    $alert.addClass('hidden');
                    return swal({
                                text: $alert.text(),
                                icon: "success",
                                buttons: true,
                                dangerMode: true,
                                buttons: ["Đóng", "Cám ơn"],
                            });
                }
            }
        });
    </script>
@endif
