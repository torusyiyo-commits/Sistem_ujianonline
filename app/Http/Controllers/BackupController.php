<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class BackupController extends Controller
{
    public function index()
    {
        return view('Admin.backup');
    }

    public function create()
    {
        try {
            $filename = "backup-" . date('Y-m-d-H-i-s') . ".sql";
            $path = storage_path("app/" . $filename);
            
            $dbHost = env('DB_HOST');
            $dbPort = env('DB_PORT');
            $dbUser = env('DB_USERNAME');
            $dbPass = env('DB_PASSWORD');
            $dbName = env('DB_DATABASE');

            $passwordParam = $dbPass ? "-p{$dbPass}" : "";
            
            $command = "mysqldump -h {$dbHost} -P {$dbPort} -u {$dbUser} {$passwordParam} {$dbName} > {$path}";
            
            $output = null;
            $resultCode = null;
            exec($command, $output, $resultCode);

            if ($resultCode === 0) {
                return response()->download($path)->deleteFileAfterSend(true);
            } else {
                return back()->with('error', 'Gagal membuat backup. Pastikan mysqldump tersedia di server.');
            }
        } catch (\Exception $e) {
            Log::error('Backup failed: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat backup: ' . $e->getMessage());
        }
    }

    public function restore(Request $request)
    {
        $request->validate([
            'backup_file' => 'required|file|mimes:sql,txt'
        ]);

        try {
            $file = $request->file('backup_file');
            $path = $file->getRealPath();
            
            $dbHost = env('DB_HOST');
            $dbPort = env('DB_PORT');
            $dbUser = env('DB_USERNAME');
            $dbPass = env('DB_PASSWORD');
            $dbName = env('DB_DATABASE');

            $passwordParam = $dbPass ? "-p{$dbPass}" : "";
            
            $command = "mysql -h {$dbHost} -P {$dbPort} -u {$dbUser} {$passwordParam} {$dbName} < {$path}";
            
            $output = null;
            $resultCode = null;
            exec($command, $output, $resultCode);

            if ($resultCode === 0) {
                return back()->with('success', 'Database berhasil direstore.');
            } else {
                return back()->with('error', 'Gagal merestore database. Pastikan perintah mysql tersedia.');
            }
        } catch (\Exception $e) {
            Log::error('Restore failed: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat restore: ' . $e->getMessage());
        }
    }
}
