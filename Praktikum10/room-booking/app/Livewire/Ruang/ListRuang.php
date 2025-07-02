<?php

namespace App\Livewire\Ruang;

use App\Models\Ruang;
use Livewire\Component;
use Livewire\WithPagination;

class ListRuang extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;

    public function delete($id)
    {
        $ruang = Ruang::find($id);

        if ($ruang) {
            $ruang->delete();
            session()->flash('message', 'Ruang berhasil dihapus.');
        }
    }

    public function render()
    {
        return view('livewire.ruang.list-ruang', [
            'ruangs' => Ruang::when($this->search, function ($query) {
                return $query->where('nama', 'like', '%' . $this->search . '%')
                    ->orWhere('kode', 'like', '%' . $this->search . '%');
            })
                ->latest()
                ->paginate($this->perPage)
        ]);
    }
}
