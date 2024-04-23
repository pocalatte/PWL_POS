<body>
    <h1>Form Tambah Data User</h1>
    <form method="post" action="/user/tambah_simpan">

        {{ csrf_field() }}
        <label>Username</label>
        <input type="text" name="username" placeholder="Masukan Username">

        <label>Nama</label>
        <input type="text" name="nama" placeholder="Masukan Nama">

        <label>Password</label>
        <input type="password" name="password" placeholder="Masukan Password">

        <label>Level ID</label>
        <input type="number" name="level_id" placeholder="Masukan ID Level">


        <input type="submit" class="btn btn-success" value="Simpan">
    </form>
</body>
