<?php
class Animal
 {
    public $animals;

    public function __construct($ar_animal)
    {
        $this->animals = $ar_animal;
    }

    public function index()
    {
        foreach ($this->animals as $animal) {
            echo "- $animal <br/>";
        }
    }
    public function store($animal) {
        $this->animals[] = $animal;
    }

    public function update($index, $animal) {
        $this->animals[$index] = $animal;
    }

    public function destroy($index) {
        unset($this->animals[$index]);
    }
}

$animal = new Animal(["Ayam", "Ikan"]);

# Method Index
echo "Index - Menampilkan seluruh hewan <br/>";
$animal->index();
echo "<br/>";

# Method Store
echo "Store - Menampilkan hewan baru (burung) <br/>";
$animal->store("Burung");
$animal->index();
echo "<br/>";

# Method Update
echo "Update - Menampilkan hewan (burung) <br/>";
$animal->store(0, "Kucing Anggora");
$animal->index();
echo "<br/>";

# Method Destroy
echo "Destroy - Mengahapus hewan <br/>";
$animal->destroy(1);
$animal->index();
echo "<br/>";