    <link rel="stylesheet" href="dist/css/jquery-ui.css" />
    <script src="dist/js/jquery-1.12.4.js"></script>
    <script src="dist/js/jquery-ui.js"></script>

    <div class="col-md-2">
        <input type="text" name="namabarang" id="namabarang" class="form-control" placeholder="Nama Barang">
        <input type="text" name="barangid" id="barangid" class="form-control">

    </div>

    <script>
        $(document).ready(function() {
            var ac_config = {
                source: "json/barang.php",
                select: function(event, ui) {
                    $("#barangid").val(ui.item.id);
                    $("#namabarang").val(ui.item.namabarang);
                },
                focus: function(event, ui) {
                    $("#barangid").val(ui.item.id);
                    $("#namabarang").val(ui.item.namabarang);
                },
                minLength: 1
            };
            $("#namabarang").autocomplete(ac_config);
        });
    </script>