<?php

namespace App\Livewire\UnitKerja;

use App\Models\UnitKerja;  // Tambahkan ini
use Livewire\Component;
use Livewire\WithPagination;  // Tambahkan ini

class ListUnitKerja extends Component
{
    use WithPagination;  // Gunakan trait pagination

    public $search = '';  // Property untuk pencarian

    // Method untuk hapus data
    public function delete($id)
    {
        UnitKerja::find($id)->delete();
        session()->flash('message', 'Unit kerja berhasil dihapus.');
    }

    public function render()
    {
        return view('livewire.unit-kerja.list-unit-kerja', [
            // Data dengan pencarian dan pagination
            'unitKerjas' => UnitKerja::when($this->search, function ($query) {
                return $query->where('nama', 'like', '%' . $this->search . '%');
            })->latest()->paginate(10)
        ]);
    }
}
