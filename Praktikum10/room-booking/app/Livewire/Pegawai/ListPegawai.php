<?php

namespace App\Livewire\Pegawai;

use App\Models\Pegawai; // Tambahkan ini
use Livewire\Component;
use Livewire\WithPagination; // Tambahkan ini

class ListPegawai extends Component
{
    use WithPagination; // Gunakan trait pagination

    public $search = ''; // Property untuk pencarian

    // Method untuk hapus data
    public function delete($id)
    {
        Pegawai::find($id)->delete();
        session()->flash('message', 'Pegawai berhasil dihapus.');
    }

    public function render()
    {
        return view('livewire.pegawai.list-pegawai', [
            'pegawais' => Pegawai::with('unitKerja') // Eager load relasi
                ->when($this->search, function ($query) {
                    return $query->where('nama', 'like', '%' . $this->search . '%')
                        ->orWhere('nip', 'like', '%' . $this->search . '%');
                })
                ->latest()
                ->paginate(10)
        ]);
    }
}
