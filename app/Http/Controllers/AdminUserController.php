<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->get();
        return view('Admin.users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('Admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|string|unique:users',
            'password' => 'required|min:6',
            'roles' => 'required'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole($request->roles);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully');
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        $userRole = $user->roles->pluck('name')->toArray();
        return view('Admin.users.edit', compact('user', 'roles', 'userRole'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|string|unique:users,email,'.$user->id,
            'roles' => 'required'
        ]);

        $data = ['name' => $request->name, 'email' => $request->email];
        if($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);
        $user->syncRoles($request->roles);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully');
    }

    public function uploadForm()
    {
        return view('Admin.users.upload');
    }

    public function downloadTemplateSiswa()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        $sheet->setCellValue('A1', 'Nama Lengkap');
        $sheet->setCellValue('B1', 'NISN');
        $sheet->setCellValue('C1', 'Kelas');

        $sheet->setCellValue('A2', 'Siswa Contoh');
        $sheet->setCellValue('B2', '1234567890');
        $sheet->setCellValue('C2', '10');

        $writer = new Xlsx($spreadsheet);
        $fileName = 'Template_Upload_Siswa.xlsx';
        $temp_file = tempnam(sys_get_temp_dir(), $fileName);
        $writer->save($temp_file);

        return response()->download($temp_file, $fileName)->deleteFileAfterSend(true);
    }

    public function downloadTemplateGuru()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        $sheet->setCellValue('A1', 'Nama & Gelar');
        $sheet->setCellValue('B1', 'NIK');

        $sheet->setCellValue('A2', 'Siti, S.Pd.');
        $sheet->setCellValue('B2', '198001012005012001');

        $writer = new Xlsx($spreadsheet);
        $fileName = 'Template_Upload_Guru.xlsx';
        $temp_file = tempnam(sys_get_temp_dir(), $fileName);
        $writer->save($temp_file);

        return response()->download($temp_file, $fileName)->deleteFileAfterSend(true);
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file_users' => 'required|file|mimes:xlsx,xls|max:10240',
        ]);

        $file = $request->file('file_users');
        
        try {
            $spreadsheet = IOFactory::load($file->getPathname());
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray();
            
            // Cari baris header yang sebenarnya (mencegah salah baca jika baris 1 adalah judul)
            $header = null;
            $headerRowIndex = 0;
            $nameIdx = -1;
            $nikIdx = -1;
            $nisnIdx = -1;
            $kelasIdx = -1;

            for ($i = 0; $i < min(10, count($rows)); $i++) {
                $currentRow = $rows[$i];
                $tempNameIdx = -1;
                $tempNikIdx = -1;
                $tempNisnIdx = -1;
                $tempKelasIdx = -1;

                foreach ($currentRow as $index => $colName) {
                    if (empty($colName)) continue;
                    $col = strtoupper(trim((string)$colName));
                    if (str_contains($col, 'NAMA')) $tempNameIdx = $index;
                    elseif (str_contains($col, 'NIK')) $tempNikIdx = $index;
                    elseif (str_contains($col, 'NISN')) $tempNisnIdx = $index;
                    elseif (str_contains($col, 'KELAS') || str_contains($col, 'KLS') || str_contains($col, 'KSL')) $tempKelasIdx = $index;
                }

                // Jika baris ini memiliki NAMA dan NIK/NISN, maka ini adalah header
                if ($tempNameIdx !== -1 && ($tempNikIdx !== -1 || $tempNisnIdx !== -1)) {
                    $header = $currentRow;
                    $headerRowIndex = $i;
                    $nameIdx = $tempNameIdx;
                    $nikIdx = $tempNikIdx;
                    $nisnIdx = $tempNisnIdx;
                    $kelasIdx = $tempKelasIdx;
                    
                    // Fallback jika Kelas tidak ditemukan tapi ada NISN (biasanya di sebelah kanan NISN)
                    if ($kelasIdx === -1 && $nisnIdx !== -1) {
                        $kelasIdx = $nisnIdx + 1;
                    }
                    break;
                }
            }

            // Hapus semua baris sampai dengan header row agar tersisa datanya saja
            if ($header !== null) {
                for ($i = 0; $i <= $headerRowIndex; $i++) {
                    array_shift($rows);
                }
                $isGuruTemplate = ($nikIdx !== -1);
            } else {
                // Fallback jika sama sekali tidak ada header yang valid
                if (count($rows) > 0) $header = array_shift($rows);
                $isGuruTemplate = (strtoupper(trim((string)($header[1] ?? ''))) === 'NIK');
                $nameIdx = 0;
                if ($isGuruTemplate) $nikIdx = 1; else $nisnIdx = 1;
            }

            $roleInput = $isGuruTemplate ? 'guru' : 'siswa';
            $createdUsers = [];

            foreach ($rows as $row) {
                // Ambil data sesuai index yang ditemukan
                $name = isset($row[$nameIdx]) ? trim($row[$nameIdx]) : '';
                $nomorInduk = $isGuruTemplate ? (isset($row[$nikIdx]) ? trim($row[$nikIdx]) : '') : (isset($row[$nisnIdx]) ? trim($row[$nisnIdx]) : '');
                
                if (empty($name) || empty($nomorInduk)) {
                    continue; // Skip baris tidak lengkap
                }

                $kelas = null;
                if (!$isGuruTemplate) {
                    $kelas = ($kelasIdx !== -1 && isset($row[$kelasIdx])) ? trim($row[$kelasIdx]) : null;
                }

                $baseUsername = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $name));
                $firstName = substr($baseUsername, 0, 8);
                $username = $firstName . rand(10, 99);
                
                while(User::where('email', $username)->exists()) {
                    $username = $firstName . rand(100, 999);
                }

                $email = $username;
                $nisn = $roleInput === 'siswa' ? $nomorInduk : null;
                $nik = $roleInput === 'guru' ? $nomorInduk : null;

                $userExists = User::where(function($query) use ($nisn, $nik) {
                                      if ($nisn) $query->orWhere('nisn', $nisn);
                                      if ($nik) $query->orWhere('nik', $nik);
                                  })->exists();

                if ($userExists) {
                    continue; 
                }

                // Generate password acak 6 karakter (Kombinasi huruf besar dan angka)
                $plainPassword = substr(str_shuffle("23456789ABCDEFGHJKLMNPQRSTUVWXYZ"), 0, 6);

                $user = User::create([
                    'name' => $name,
                    'email' => $email,
                    'password' => Hash::make($plainPassword),
                    'nisn' => $nisn,
                    'nik' => $nik,
                    'kelas' => $roleInput === 'siswa' ? $kelas : null,
                ]);

                $user->assignRole($roleInput);

                $createdUsers[] = [
                    'name' => $name,
                    'email' => $username, // Tampilkan username yang digenerate
                    'role' => $roleInput,
                    'nisn' => $nisn,
                    'nik' => $nik,
                    'kelas' => $roleInput === 'siswa' ? $kelas : '-',
                    'password' => $plainPassword
                ];
            }

            return view('Admin.users.upload_result', compact('createdUsers', 'isGuruTemplate'))->with('success', 'Berhasil mengunggah '.count($createdUsers).' pengguna baru.');

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat memproses file Excel: ' . $e->getMessage());
        }
    }
}
