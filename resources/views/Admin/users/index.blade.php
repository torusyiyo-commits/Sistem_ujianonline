@extends('Admin.layout')

@section('title', 'Kelola Pengguna')

@section('content')
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
        <h3>Daftar Pengguna</h3>
        <div style="flex: 1; max-width: 300px; margin: 0 1rem; position: relative;">
            <i class="fas fa-search" style="position: absolute; left: 10px; top: 10px; color: #9ca3af;"></i>
            <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Cari nama atau role..." style="width: 100%; padding: 0.5rem 1rem 0.5rem 2.2rem; border: 1px solid #d1d5db; border-radius: 0.5rem; outline: none;">
        </div>
        <div>
            <a href="{{ route('admin.users.upload.form') }}" class="btn btn-warning" style="margin-right: 0.5rem;"><i class="fas fa-file-excel"></i> Upload Excel</a>
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Pengguna</a>
        </div>
    </div>

    <table id="userTable">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Role</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $index => $user)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $user->name }}</td>
                <td>
                    @foreach($user->roles as $role)
                        <span style="background-color: #d1fae5; color: #065f46; padding: 0.2rem 0.5rem; border-radius: 0.25rem; font-size: 0.8rem;">{{ $role->name }}</span>
                    @endforeach
                </td>
                <td>
                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning" style="padding: 0.3rem 0.5rem; font-size: 0.875rem;"><i class="fas fa-edit"></i> Edit</a>
                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" style="padding: 0.3rem 0.5rem; font-size: 0.875rem;" onclick="return confirm('Hapus pengguna ini?');"><i class="fas fa-trash"></i> Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
function searchTable() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("searchInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("userTable");
    tr = table.getElementsByTagName("tr");

    for (i = 1; i < tr.length; i++) {
        tr[i].style.display = "none";
        td = tr[i].getElementsByTagName("td");
        for (var j = 1; j < td.length - 1; j++) { // Skip kolom No (0) dan Aksi (terakhir)
            if (td[j]) {
                txtValue = td[j].textContent || td[j].innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                    break;
                }
            }
        }
    }
}
</script>
@endsection
