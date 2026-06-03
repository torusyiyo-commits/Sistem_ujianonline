<?php
$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator('resources/views'));
$targetFilter = <<<EOT
                        <option value="Matematika" {{ request('mapel') == 'Matematika' ? 'selected' : '' }}>Matematika</option>
                        <option value="Pendidikan Jasmani Olahraga dan Kesehatan" {{ request('mapel') == 'Pendidikan Jasmani Olahraga dan Kesehatan' ? 'selected' : '' }}>Pendidikan Jasmani Olahraga dan Kesehatan</option>
                        <option value="Seni Budaya" {{ request('mapel') == 'Seni Budaya' ? 'selected' : '' }}>Seni Budaya</option>
                        <option value="Sejarah" {{ request('mapel') == 'Sejarah' ? 'selected' : '' }}>Sejarah</option>
                        <option value="Bimbingan Konseling dan Keminangkabauan" {{ request('mapel') == 'Bimbingan Konseling dan Keminangkabauan' ? 'selected' : '' }}>Bimbingan Konseling dan Keminangkabauan</option>
                        <option value="Pendidikan Pancasila dan Kewarganegaraan" {{ request('mapel') == 'Pendidikan Pancasila dan Kewarganegaraan' ? 'selected' : '' }}>Pendidikan Pancasila dan Kewarganegaraan</option>
                        <option value="Informatika" {{ request('mapel') == 'Informatika' ? 'selected' : '' }}>Informatika</option>
                        <option value="Koding" {{ request('mapel') == 'Koding' ? 'selected' : '' }}>Koding</option>
                        <option value="Bahasa Indonesia" {{ request('mapel') == 'Bahasa Indonesia' ? 'selected' : '' }}>Bahasa Indonesia</option>
                        <option value="Bahasa Inggris" {{ request('mapel') == 'Bahasa Inggris' ? 'selected' : '' }}>Bahasa Inggris</option>
EOT;

$replacementFilter = <<<EOT
                        <option value="Pancasila dan Kewarganegaraan" {{ request('mapel') == 'Pancasila dan Kewarganegaraan' ? 'selected' : '' }}>Pancasila dan Kewarganegaraan</option>
                        <option value="PAI" {{ request('mapel') == 'PAI' ? 'selected' : '' }}>PAI</option>
                        <option value="Kuliner" {{ request('mapel') == 'Kuliner' ? 'selected' : '' }}>Kuliner</option>
                        <option value="Bimbingan Konseling" {{ request('mapel') == 'Bimbingan Konseling' ? 'selected' : '' }}>Bimbingan Konseling</option>
                        <option value="Bahasa Inggris" {{ request('mapel') == 'Bahasa Inggris' ? 'selected' : '' }}>Bahasa Inggris</option>
                        <option value="Kewirausahaan" {{ request('mapel') == 'Kewirausahaan' ? 'selected' : '' }}>Kewirausahaan</option>
                        <option value="Bahasa Jepang" {{ request('mapel') == 'Bahasa Jepang' ? 'selected' : '' }}>Bahasa Jepang</option>
                        <option value="Perhotelan" {{ request('mapel') == 'Perhotelan' ? 'selected' : '' }}>Perhotelan</option>
                        <option value="Matematika" {{ request('mapel') == 'Matematika' ? 'selected' : '' }}>Matematika</option>
                        <option value="Sejarah Indonesia" {{ request('mapel') == 'Sejarah Indonesia' ? 'selected' : '' }}>Sejarah Indonesia</option>
                        <option value="Informatika" {{ request('mapel') == 'Informatika' ? 'selected' : '' }}>Informatika</option>
                        <option value="Seni Budaya" {{ request('mapel') == 'Seni Budaya' ? 'selected' : '' }}>Seni Budaya</option>
                        <option value="Bahasa Indonesia" {{ request('mapel') == 'Bahasa Indonesia' ? 'selected' : '' }}>Bahasa Indonesia</option>
                        <option value="PJOK" {{ request('mapel') == 'PJOK' ? 'selected' : '' }}>PJOK</option>
                        <option value="Kemuhammadiyahan dan Tahsin" {{ request('mapel') == 'Kemuhammadiyahan dan Tahsin' ? 'selected' : '' }}>Kemuhammadiyahan dan Tahsin</option>
EOT;

$targetStandard = <<<EOT
                        <option value="Matematika">Matematika</option>
                        <option value="Pendidikan Jasmani Olahraga dan Kesehatan">Pendidikan Jasmani Olahraga dan Kesehatan</option>
                        <option value="Seni Budaya">Seni Budaya</option>
                        <option value="Sejarah">Sejarah</option>
                        <option value="Bimbingan Konseling dan Keminangkabauan">Bimbingan Konseling dan Keminangkabauan</option>
                        <option value="Pendidikan Pancasila dan Kewarganegaraan">Pendidikan Pancasila dan Kewarganegaraan</option>
                        <option value="Informatika">Informatika</option>
                        <option value="Koding">Koding</option>
                        <option value="Bahasa Indonesia">Bahasa Indonesia</option>
                        <option value="Bahasa Inggris">Bahasa Inggris</option>
EOT;

$replacementStandard = <<<EOT
                        <option value="Pancasila dan Kewarganegaraan">Pancasila dan Kewarganegaraan</option>
                        <option value="PAI">PAI</option>
                        <option value="Kuliner">Kuliner</option>
                        <option value="Bimbingan Konseling">Bimbingan Konseling</option>
                        <option value="Bahasa Inggris">Bahasa Inggris</option>
                        <option value="Kewirausahaan">Kewirausahaan</option>
                        <option value="Bahasa Jepang">Bahasa Jepang</option>
                        <option value="Perhotelan">Perhotelan</option>
                        <option value="Matematika">Matematika</option>
                        <option value="Sejarah Indonesia">Sejarah Indonesia</option>
                        <option value="Informatika">Informatika</option>
                        <option value="Seni Budaya">Seni Budaya</option>
                        <option value="Bahasa Indonesia">Bahasa Indonesia</option>
                        <option value="PJOK">PJOK</option>
                        <option value="Kemuhammadiyahan dan Tahsin">Kemuhammadiyahan dan Tahsin</option>
EOT;

$count = 0;
foreach ($files as $file) {
    if ($file->isFile() && str_ends_with($file->getFilename(), '.blade.php')) {
        $path = $file->getPathname();
        $content = file_get_contents($path);
        
        // Coba dengan CRLF maupun LF
        $tFilterCRLF = str_replace("\n", "\r\n", str_replace("\r\n", "\n", $targetFilter));
        $tStandardCRLF = str_replace("\n", "\r\n", str_replace("\r\n", "\n", $targetStandard));
        
        $tFilterLF = str_replace("\r\n", "\n", $targetFilter);
        $tStandardLF = str_replace("\r\n", "\n", $targetStandard);
        
        $replaced = false;
        
        if (strpos($content, $tFilterCRLF) !== false) {
            $content = str_replace($tFilterCRLF, $replacementFilter, $content);
            $replaced = true;
        } elseif (strpos($content, $tFilterLF) !== false) {
            $content = str_replace($tFilterLF, $replacementFilter, $content);
            $replaced = true;
        }
        
        if (strpos($content, $tStandardCRLF) !== false) {
            $content = str_replace($tStandardCRLF, $replacementStandard, $content);
            $replaced = true;
        } elseif (strpos($content, $tStandardLF) !== false) {
            $content = str_replace($tStandardLF, $replacementStandard, $content);
            $replaced = true;
        }
        
        if ($replaced) {
            file_put_contents($path, $content);
            echo "Updated: $path\n";
            $count++;
        }
    }
}
echo "Total files updated: $count\n";
