<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VisiMisi; 
use App\Models\VillageOfficial; 
use App\Models\ContentPage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ProfilNagariContentController extends Controller
{
    // Menampilkan halaman indeks untuk manajemen konten profil nagari.
    public function index()
    {
        return view('pages.profile-nagari-content.index');
    }

    // Menampilkan form untuk mengedit Visi dan Misi.
    public function editVisiMisi()
    {
        $visi = VisiMisi::where('type', 'visi')->firstOrNew(['type' => 'visi']);
        $misiItems = VisiMisi::where('type', 'misi')->orderBy('order')->get();
        $misiIndex = count($misiItems);
        return view('pages.profile-nagari-content.edit-visi-misi', compact('visi', 'misiItems', 'misiIndex'));
    }

    // Menangani proses update Visi dan Misi.
    public function updateVisiMisi(Request $request)
    {
        $request->validate([
            'visi_content' => 'required|string',
            'misi_items' => 'nullable|array',
            'misi_items.*.id' => 'nullable|integer|exists:visi_misi,id', 
            'misi_items.*.content' => 'required|string',
            'misi_items.*.order' => 'nullable|integer',
        ]);

        $user = auth()->user(); // Ambil user yang sedang login, akan digunakan sebagai user_id

        DB::transaction(function () use ($request, $user) {
            // Update atau buat Visi
            VisiMisi::updateOrCreate(
                ['type' => 'visi'], // Kondisi pencarian
                [
                    'content' => $request->input('visi_content'),
                    'user_id' => $user->id // Mencatat siapa yang terakhir mengupdate
                ]
            );

            // Update dan Hapus Misi
            $submittedMisiIds = [];
            if ($request->has('misi_items') && is_array($request->input('misi_items'))) {
                foreach ($request->input('misi_items') as $itemData) {
                    $misi = VisiMisi::updateOrCreate(
                        ['id' => $itemData['id'] ?? null, 'type' => 'misi'], // Jika ID ada, update; jika tidak, buat baru
                        [
                            'content' => $itemData['content'],
                            'order' => $itemData['order'] ?? null, // Default ke null jika tidak ada
                            'user_id' => $user->id
                        ]
                    );
                    $submittedMisiIds[] = $misi->id;
                }
            }

            // Hapus misi yang tidak ada lagi di submit
            VisiMisi::where('type', 'misi')
                    ->whereNotIn('id', $submittedMisiIds)
                    ->delete();
        });


        return redirect('/profile-nagari-content')->with('success', 'Visi dan Misi berhasil diperbarui!');
    }

    // Menampilkan daftar Struktur Organisasi untuk dikelola (tambah, edit, hapus).
    public function indexStrukturOrganisasi()
    {
        // Mengambil semua data pengurus, diurutkan berdasarkan 'order' jika ada, atau 'name'
        $officials = VillageOfficial::orderBy('order')->orderBy('name')->get();

        $query = VillageOfficial::query();
        $query->orderBy('order')->orderBy('name');
        // Ambil hanya 10 item per halaman. Jika Anda punya 15 data, pagination akan muncul.
        $officials = $query->paginate(10); // <--- Ubah angka ini jika perlu

        return view('pages.profile-nagari-content.struktur-organisasi.index', compact('officials'));
    }

    // Menampilkan form untuk menambah pengurus baru.
    public function createStrukturOrganisasi()
    {
        return view('pages.profile-nagari-content.struktur-organisasi.create');
    }

    // Menangani proses penyimpanan pengurus baru.
    public function storeStrukturOrganisasi(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10240', // Validasi foto
            'task_description' => 'nullable|string',
            'order' => 'nullable|integer',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos/officials', 'public'); // Simpan di storage/app/public/photos/officials
        }

        VillageOfficial::create([
            'name' => $request->input('name'),
            'position' => $request->input('position'),
            'photo' => $photoPath,
            'task_description' => $request->input('task_description'),
            'order' => $request->input('order'),
            'user_id' => auth()->user()->id, // Mencatat admin yang menambahkan
        ]);

        return redirect('struktur-organisasi')->with('success', 'Pengurus berhasil ditambahkan!');
    }

    // Menampilkan form untuk mengedit pengurus.
    public function editStrukturOrganisasi($id)
    {
        $official = VillageOfficial::findOrFail($id); // Mencari pengurus, jika tidak ada akan 404

        return view('pages.profile-nagari-content.struktur-organisasi.edit', compact('official'));
    }

    // Menangani proses update pengurus.
    public function updateStrukturOrganisasi(Request $request, $id)
    {
        $official = VillageOfficial::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10240', // Validasi foto
            'task_description' => 'nullable|string',
            'order' => 'nullable|integer',
        ]);

        $photoPath = $official->photo; // Ambil path foto lama

        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($photoPath) {
                Storage::disk('public')->delete($photoPath);
            }
            $photoPath = $request->file('photo')->store('photos/officials', 'public');
        } elseif ($request->input('remove_photo')) { // Asumsi ada checkbox untuk menghapus foto
             if ($photoPath) {
                Storage::disk('public')->delete($photoPath);
                $photoPath = null;
            }
        }

        $official->update([
            'name' => $request->input('name'),
            'position' => $request->input('position'),
            'photo' => $photoPath,
            'task_description' => $request->input('task_description'),
            'order' => $request->input('order'),
            'user_id' => auth()->user()->id, // Mencatat admin yang terakhir mengupdate
        ]);

        return redirect('/struktur-organisasi')->with('success', 'Pengurus berhasil diperbarui!');
    }

    // Menangani proses penghapusan pengurus.
    public function destroyStrukturOrganisasi($id)
    {
        $official = VillageOfficial::findOrFail($id);

        // Hapus foto dari storage sebelum menghapus record dari database
        if ($official->photo) {
            Storage::disk('public')->delete($official->photo);
        }

        $official->delete();

        return redirect('/struktur-organisasi')->with('success', 'Pengurus berhasil dihapus!');
    }

    
    /**
     * Menampilkan form untuk mengedit kontak hukum (Polsek, Babinsa).
     */
    public function editLegalContact()
    {
        $legalContact = ContentPage::firstOrCreate(
            ['type' => 'legal_contact'],
            ['title' => 'Kontak Hukum Nagari', 'body' => 'Deskripsi umum kontak hukum di Nagari.']
        );
        // === PERBAIKAN DI SINI ===
        // Path view harus sesuai dengan folder Anda
        return view('pages.law.legal-contact-edit', compact('legalContact'));
        // === AKHIR PERBAIKAN ===
    }

    /**
     * Memperbarui kontak hukum.
     */
    public function updateLegalContact(Request $request)
    {
        $validated = $request->validate([
            'description' => 'nullable|string',
            'contact_polsek_phone' => 'nullable|string|max:15',
            'contact_polsek_name' => 'nullable|string|max:255',
            'contact_babinsa_phone' => 'nullable|string|max:15',
            'contact_babinsa_name' => 'nullable|string|max:255',
        ]);

        $legalContact = ContentPage::where('type', 'legal_contact')->firstOrFail();

        $legalContact->update([
            'body' => $validated['description'],
            'contact_polsek_phone' => $validated['contact_polsek_phone'],
            'contact_polsek_name' => $validated['contact_polsek_name'],
            'contact_babinsa_phone' => $validated['contact_babinsa_phone'],
            'contact_babinsa_name' => $validated['contact_babinsa_name'],
        ]);

        // === PERBAIKAN DI SINI ===
        // Gunakan redirect()->route() dengan nama rute yang benar
        return redirect()->route('law.index')->with('success', 'Kontak Hukum berhasil diperbarui!');
        // === AKHIR PERBAIKAN ===
    }
}
