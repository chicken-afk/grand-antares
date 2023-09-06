<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use RealRashid\SweetAlert\Facades\Alert;

class importCategoryController extends Controller
{
    public function store(Request $request)
    {
        if ($request->hasFile('csv_file')) {
            $file = $request->file('csv_file');
            $csvData = file_get_contents($file);
            $rows = array_map('str_getcsv', explode("\n", $csvData));
            // dd($rows);
            foreach ($rows as $row) {
                // dd($row);
                // Sesuaikan bagian berikut sesuai dengan struktur CSV dan tabel Anda
                if ($row[0] != NULL) {
                    Category::create([
                        'category_name' => $row[0],
                        'user_id' => auth()->user()->id,
                        'company_id' => auth()->user()->company_id
                        // Tambahkan kolom lainnya sesuai dengan struktur CSV dan tabel Anda
                    ]);
                }
            }
            Alert::success('Success', 'Berhasil Menambah Data');
            return redirect()->back()->with('success', 'Data has been imported successfully.');
        }
        Alert::error('Error', 'Gagal Menambahkan Data');
        return redirect()->back()->with('error', 'Please choose a CSV file to import.');
    }
}
