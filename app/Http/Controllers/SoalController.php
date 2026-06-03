<?php

namespace App\Http\Controllers;

use App\Models\Ujian;
use App\Models\Soal;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory as ExcelIOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpWord\IOFactory as WordIOFactory;
use PhpOffice\PhpWord\PhpWord;

class SoalController extends Controller
{
    public function index()
    {
        $ujians = Ujian::where('guru_id', auth()->id())->orderBy('created_at', 'desc')->get();
        return view('Guru.kelola_soal', compact('ujians'));
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file_soal' => 'required|file|mimes:xlsx,xls,docx,doc|max:10240',
            'judul' => 'required|string|max:255',
            'mata_pelajaran' => 'required|string|max:255',
            'kelas' => 'required|string|max:50',
            'durasi' => 'required|integer|min:10',
        ]);

        $file = $request->file('file_soal');
        $extension = strtolower($file->getClientOriginalExtension());
        $rows = [];
        
        try {
            if (in_array($extension, ['xls', 'xlsx'])) {
                $spreadsheet = ExcelIOFactory::load($file->getPathname());
                $worksheet = $spreadsheet->getActiveSheet();
                $rows = $worksheet->toArray();
            } elseif (in_array($extension, ['doc', 'docx'])) {
                $phpWord = WordIOFactory::load($file->getPathname());
                $sections = $phpWord->getSections();
                foreach ($sections as $section) {
                    $elements = $section->getElements();
                    foreach ($elements as $element) {
                        if ($element instanceof \PhpOffice\PhpWord\Element\Table) {
                            foreach ($element->getRows() as $row) {
                                $rowData = [];
                                foreach ($row->getCells() as $cell) {
                                    $cellText = '';
                                    // Helper function for recursive text extraction
                                    $extractText = function($element) use (&$extractText) {
                                        $text = '';
                                        if (method_exists($element, 'getElements')) {
                                            foreach ($element->getElements() as $child) {
                                                $text .= $extractText($child);
                                            }
                                        } elseif (method_exists($element, 'getText')) {
                                            $text .= $element->getText() . ' ';
                                        }
                                        return $text;
                                    };
                                    
                                    $cellText = $extractText($cell);
                                    $rowData[] = trim($cellText);
                                }
                                $rows[] = $rowData;
                            }
                            break; // Assume only first table is the question bank
                        }
                    }
                    if (count($rows) > 0) break;
                }
            }
            
            // Hapus baris pertama (selalu diasumsikan sebagai header tabel sesuai template)
            if (count($rows) > 0) {
                array_shift($rows);
            }

            // Buat Ujian baru
            $ujian = Ujian::create([
                'judul' => $request->judul,
                'mata_pelajaran' => $request->mata_pelajaran,
                'kelas' => $request->kelas,
                'durasi' => $request->durasi,
                'jumlah_soal_ditampilkan' => $request->jumlah_soal_ditampilkan,
                'tanggal_ujian' => null,
                'jam_mulai' => null,
                'jam_selesai' => null,
                'file_sumber' => $file->getClientOriginalName(),
                'guru_id' => auth()->id(),
            ]);

            $validSoalCount = 0;

            foreach ($rows as $row) {
                // Hapus elemen kosong di belakang agar panjang array konsisten
                while(count($row) > 0 && empty(end($row))) {
                    array_pop($row);
                }
                
                // Pastikan baris tidak kosong dan bukan header yang tertinggal
                if (empty($row) || empty(trim($row[0]))) continue;
                if (in_array(strtolower(trim($row[0])), ['soal', 'pertanyaan', 'no', 'nomor', 'no.'])) continue;

                // Auto-detect kolom "Nomor"
                if (is_numeric(trim($row[0])) && count($row) > 2) {
                    array_shift($row); // Buang kolom nomor urut
                }

                $jawabanBenar = strtoupper(trim(end($row)));
                array_pop($row);

                $pertanyaan = $row[0] ?? '';
                $opsi_a = $row[1] ?? '';
                $opsi_b = $row[2] ?? '';
                $opsi_c = $row[3] ?? '';
                $opsi_d = $row[4] ?? '';
                $opsi_e = $row[5] ?? '';

                Soal::create([
                    'ujian_id' => $ujian->id,
                    'pertanyaan' => $pertanyaan,
                    'opsi_a' => $opsi_a,
                    'opsi_b' => $opsi_b,
                    'opsi_c' => $opsi_c,
                    'opsi_d' => $opsi_d,
                    'opsi_e' => $opsi_e,
                    'jawaban_benar' => in_array($jawabanBenar, ['A', 'B', 'C', 'D', 'E']) ? $jawabanBenar : 'A',
                ]);
                $validSoalCount++;
            }

            if ($validSoalCount == 0) {
                $ujian->delete();
                return back()->with('error', 'Tidak ada soal valid yang ditemukan dalam file.');
            }

            return back()->with('success', 'Berhasil mengunggah ' . $validSoalCount . ' soal.');

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat memproses file: ' . $e->getMessage());
        }
    }

    public function downloadTemplate(Request $request)
    {
        $type = $request->query('type', 'excel');

        if ($type === 'word') {
            $phpWord = new PhpWord();
            $section = $phpWord->addSection(['orientation' => 'landscape']);
            
            $tableStyle = array(
                'borderColor' => '000000',
                'borderSize'  => 6,
                'cellMargin'  => 50
            );
            $phpWord->addTableStyle('myTable', $tableStyle);
            $table = $section->addTable('myTable');
            
            // Header
            $table->addRow();
            $table->addCell(3000)->addText('Soal', ['bold' => true]);
            $table->addCell(1500)->addText('Opsi A', ['bold' => true]);
            $table->addCell(1500)->addText('Opsi B', ['bold' => true]);
            $table->addCell(1500)->addText('Opsi C', ['bold' => true]);
            $table->addCell(1500)->addText('Opsi D', ['bold' => true]);
            $table->addCell(1500)->addText('Opsi E', ['bold' => true]);
            $table->addCell(1500)->addText('Jawaban Benar (A/B/C/D/E)', ['bold' => true]);
            
            // Row 1
            $table->addRow();
            $table->addCell(3000)->addText('Siapakah penemu bola lampu?');
            $table->addCell(1500)->addText('Thomas Edison');
            $table->addCell(1500)->addText('Albert Einstein');
            $table->addCell(1500)->addText('Nikola Tesla');
            $table->addCell(1500)->addText('Isaac Newton');
            $table->addCell(1500)->addText('Galileo Galilei');
            $table->addCell(1500)->addText('A');

            $filename = 'Template_Soal_Ujian.docx';
            
            header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
            header('Content-Disposition: attachment;filename="'. $filename .'"');
            header('Cache-Control: max-age=0');
            
            $objWriter = WordIOFactory::createWriter($phpWord, 'Word2007');
            $objWriter->save('php://output');
            exit;
        }

        // Default: Excel
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        $sheet->setCellValue('A1', 'Soal');
        $sheet->setCellValue('B1', 'Opsi A');
        $sheet->setCellValue('C1', 'Opsi B');
        $sheet->setCellValue('D1', 'Opsi C');
        $sheet->setCellValue('E1', 'Opsi D');
        $sheet->setCellValue('F1', 'Opsi E');
        $sheet->setCellValue('G1', 'Jawaban Benar (A/B/C/D/E)');

        $sheet->setCellValue('A2', 'Siapakah penemu bola lampu?');
        $sheet->setCellValue('B2', 'Thomas Edison');
        $sheet->setCellValue('C2', 'Albert Einstein');
        $sheet->setCellValue('D2', 'Nikola Tesla');
        $sheet->setCellValue('E2', 'Isaac Newton');
        $sheet->setCellValue('F2', 'Galileo Galilei');
        $sheet->setCellValue('G2', 'A');

        $writer = new Xlsx($spreadsheet);
        
        $filename = 'Template_Soal_Ujian.xlsx';
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'. $filename .'"');
        header('Cache-Control: max-age=0');
        
        $writer->save('php://output');
        exit;
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'mata_pelajaran' => 'required|string|max:255',
            'kelas' => 'required|string|max:50',
            'durasi' => 'required|integer|min:10',
            'tanggal_ujian' => 'required|date',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
        ]);

        $ujian = Ujian::where('guru_id', auth()->id())->findOrFail($id);
        $ujian->update([
            'judul' => $request->judul,
            'mata_pelajaran' => $request->mata_pelajaran,
            'kelas' => $request->kelas,
            'durasi' => $request->durasi,
            'jumlah_soal_ditampilkan' => $request->jumlah_soal_ditampilkan,
            'tanggal_ujian' => $request->tanggal_ujian,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
        ]);

        return back()->with('success', 'Data ujian berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $ujian = Ujian::where('guru_id', auth()->id())->findOrFail($id);
        $ujian->delete();

        return back()->with('success', 'Data ujian beserta soalnya berhasil dihapus.');
    }
}

