use App\Models\Peminjaman;

class ListPeminjaman extends Component {
use WithPagination;
public $search = '';

public function render() {
return view('livewire.peminjaman.list-peminjaman', [
'peminjamans' => Peminjaman::with(['pegawai', 'ruang'])
->whereHas('pegawai', fn($q) =>
$q->where('nama', 'like', "%{$this->search}%")
)
->paginate(10)
]);
}
}