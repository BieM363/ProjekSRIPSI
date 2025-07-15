<?php

namespace App\Http\Controllers;

use App\Models\ParameterIndikator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class IndicatorParameterController extends Controller
{
    /**
     * Display a listing of the parameter indicators.
     */
    public function index()
    {
        $parameters = ParameterIndikator::all();
        $totalBobot = $parameters->sum('bobot');
        
        return view('home.menu.parameter-indikator', compact('parameters', 'totalBobot'));
    }

    /**
     * Store a newly created parameter indicator in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'   => 'required|string|max:255|unique:parameter_indikators,nama',
            'target' => 'required|integer|min:0',
            'satuan' => 'required|string|max:100',
            'bobot'  => 'required|numeric|min:0|max:100',
        ]);

        // Validasi total bobot
        $currentTotal = ParameterIndikator::sum('bobot');
        $newTotal = $currentTotal + $validated['bobot'];
        
        if ($newTotal > 100) {
            return back()->withErrors([
                'bobot' => 'Total bobot tidak boleh melebihi 100%. Total saat ini: '.$currentTotal.'%'
            ])->withInput();
        }

        // Gunakan transaction untuk konsistensi data
        DB::beginTransaction();
        
        try {
            ParameterIndikator::create($validated);
            DB::commit();
            
            return redirect()
                ->route('parameter-indikator')
                ->with('success', 'Parameter indikator berhasil ditambahkan.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors([
                'error' => 'Terjadi kesalahan saat menyimpan data: '.$e->getMessage()
            ])->withInput();
        }
    }

    /**
     * Update the specified parameter indicator in storage.
     */
    public function update(Request $request, $id)
    {
        $param = ParameterIndikator::findOrFail($id);

        $validated = $request->validate([
            'nama'   => [
                'required',
                'string',
                'max:255',
                Rule::unique('parameter_indikators')->ignore($param->id)
            ],
            'target' => 'required|integer|min:0',
            'satuan' => 'required|string|max:100',
            'bobot'  => 'required|numeric|min:0|max:100',
        ]);

        // Validasi total bobot
        $currentTotal = ParameterIndikator::sum('bobot');
        $newTotal = $currentTotal - $param->bobot + $validated['bobot'];
        
        if ($newTotal > 100) {
            return back()->withErrors([
                'bobot' => 'Total bobot tidak boleh melebihi 100%. Total saat ini: '.$currentTotal.'%'
            ])->withInput();
        }

        // Gunakan transaction untuk konsistensi data
        DB::beginTransaction();
        
        try {
            $param->update($validated);
            DB::commit();
            
            return redirect()
                ->route('parameter-indikator')
                ->with('success', 'Parameter indikator berhasil diperbarui.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors([
                'error' => 'Terjadi kesalahan saat memperbarui data: '.$e->getMessage()
            ])->withInput();
        }
    }

    /**
     * Remove the specified parameter indicator from storage.
     */
    public function destroy($id)
    {
        $parameterIndikator = ParameterIndikator::findOrFail($id);
        $deletedBobot = $parameterIndikator->bobot;
        
        // Gunakan transaction untuk konsistensi data
        DB::beginTransaction();
        
        try {
            $parameterIndikator->delete();
            DB::commit();
            
            $newTotal = ParameterIndikator::sum('bobot');
            
            return redirect()
                ->route('parameter-indikator')
                ->with('warning', 'Parameter indikator dengan bobot '.$deletedBobot.'% berhasil dihapus. Total bobot sekarang: '.$newTotal.'%');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors([
                'error' => 'Terjadi kesalahan saat menghapus data: '.$e->getMessage()
            ]);
        }
    }
}