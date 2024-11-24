@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>Transaksi Pembelian</h4>
        </div>
        <div class="card-body">
            <form id="pembelianForm">
                <div class="mb-3">
                    <label for="kodespl" class="form-label">Supplier</label>
                    <select id="kodespl" class="form-select">
                        <option value="" disabled selected>Pilih Supplier</option>
                        @foreach ($suplier as $item)
                            <option value="{{ $item->kodespl }}">{{ $item->namaspl }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="barang" class="form-label">Barang</label>
                    <select id="barang" class="form-select">
                        <option value="" disabled selected>Pilih Barang</option>
                        @foreach ($barang as $item)
                            <option value="{{ $item->kodebrg }}" data-harga="{{ $item->hargabeli }}">
                                {{ $item->namabrg }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="button" id="addItem" class="btn btn-primary">Tambah Barang</button>
            </form>

            <table class="table mt-4">
                <thead>
                    <tr>
                        <th>Nama Barang</th>
                        <th>Harga</th>
                        <th>Qty</th>
                        <th>Diskon (%)</th>
                        <th>Total</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="itemsTable"></tbody>
            </table>

            <button id="saveTransaction" class="btn btn-success">Simpan Transaksi</button>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let items = []; // Array untuk menyimpan data barang

            // Fungsi untuk menghitung total harga setelah diskon
            function calculateTotal(harga, qty, diskon) {
                let total = harga * qty;
                let diskonRp = (diskon / 100) * total;
                return total - diskonRp;
            }

            // Fungsi untuk merender tabel barang
            function renderTable() {
                const tableBody = document.getElementById('itemsTable');
                tableBody.innerHTML = ''; // Bersihkan tabel sebelum merender ulang

                items.forEach((item, index) => {
                    const row = `
                <tr>
                    <td>${item.namabrg}</td>
                    <td>Rp ${item.harga.toLocaleString()}</td>
                    <td>
                        <input type="number" min="1" class="form-control qty-input" 
                               data-index="${index}" value="${item.qty}">
                    </td>
                    <td>
                        <input type="number" min="0" max="100" class="form-control diskon-input" 
                               data-index="${index}" value="${item.diskon}">
                    </td>
                    <td>Rp ${item.total.toLocaleString()}</td>
                    <td>
                        <button class="btn btn-danger btn-sm remove-item" data-index="${index}">
                            Hapus
                        </button>
                    </td>
                </tr>
            `;
                    tableBody.insertAdjacentHTML('beforeend', row);
                });
            }

            // Tambah barang ke daftar
            document.getElementById('addItem').addEventListener('click', function() {
                const barangSelect = document.getElementById('barang');
                const selectedOption = barangSelect.options[barangSelect.selectedIndex];

                if (!selectedOption.value) {
                    alert('Pilih barang terlebih dahulu!');
                    return;
                }

                const kodebrg = selectedOption.value;
                const namabrg = selectedOption.text;
                const harga = parseFloat(selectedOption.getAttribute('data-harga'));

                // Cek apakah barang sudah ada dalam daftar
                const existingItem = items.find((item) => item.kodebrg === kodebrg);
                if (existingItem) {
                    alert('Barang sudah ada dalam daftar!');
                    return;
                }

                // Tambah barang baru ke dalam array
                items.push({
                    kodebrg,
                    namabrg,
                    harga,
                    qty: 1, // Default qty
                    diskon: 0, // Default diskon
                    total: calculateTotal(harga, 1, 0), // Hitung total
                });

                renderTable(); // Render ulang tabel
            });

            // Event untuk menghapus barang dari daftar
            document.getElementById('itemsTable').addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-item')) {
                    const index = e.target.getAttribute('data-index');
                    items.splice(index, 1); // Hapus item berdasarkan index
                    renderTable(); // Render ulang tabel
                }
            });

            // Event untuk mengupdate qty dan diskon
            document.getElementById('itemsTable').addEventListener('input', function(e) {
                if (e.target.classList.contains('qty-input') || e.target.classList.contains(
                    'diskon-input')) {
                    const index = e.target.getAttribute('data-index');
                    const field = e.target.classList.contains('qty-input') ? 'qty' : 'diskon';

                    let value = parseFloat(e.target.value);
                    if (isNaN(value) || value < 0) value = 0;

                    items[index][field] = value;
                    items[index].total = calculateTotal(items[index].harga, items[index].qty, items[index]
                        .diskon);

                    renderTable(); // Render ulang tabel
                }
            });

            // Simpan transaksi
            document.getElementById('saveTransaction').addEventListener('click', function() {
                const kodespl = document.getElementById('kodespl').value;

                if (!kodespl) {
                    alert('Pilih supplier terlebih dahulu!');
                    return;
                }

                if (items.length === 0) {
                    alert('Tambahkan barang ke daftar terlebih dahulu!');
                    return;
                }

                // Kirim data ke server menggunakan AJAX
                fetch('/pembelian/store', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content'),
                        },
                        body: JSON.stringify({
                            kodespl,
                            items,
                        }),
                    })
                    .then((response) => response.json())
                    .then((data) => {
                        if (data.success) {
                            alert('Transaksi berhasil disimpan!');
                            location.reload(); // Reload halaman
                        } else {
                            alert(data.error || 'Terjadi kesalahan saat menyimpan transaksi.');
                        }
                    })
                    .catch((error) => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat menghubungi server.');
                    });
            });
        });
    </script>
@endpush
