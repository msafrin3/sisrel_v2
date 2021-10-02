<form id="formadduser">
    <div class="modal-header">
        <h4 class="modal-title">Tambah baru pengguna</h4>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label>Nama</label>
            <input type="text" class="form-control" name="name" placeholder="Nama pengguna" required>
        </div>
        <div class="form-group">
            <label>IC</label>
            <input type="text" class="form-control" name="ic" placeholder="Masukkan IC pengguna" required>
        </div>
        <div class="form-group">
            <label>E-Mel</label>
            <input type="email" class="form-control" name="email" placeholder="Masukkan Emel pengguna" required>
        </div>
        <div class="form-group">
            <label>Kata Laluan</label>
            <input type="password" class="form-control" name="password" placeholder="Masukkan kata laluan" required>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-success"><i class="fa fa-save fa-fw"></i> Save</button>
    </div>
</form>

<script>
    $("#formadduser").submit(function(e) {
        e.preventDefault();
    });
</script>