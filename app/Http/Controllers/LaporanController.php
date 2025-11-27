<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\StatusLaporan;
use App\Models\TindakLanjut;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class LaporanController extends Controller
{
    public function index()
    {
        $laporan = Laporan::with("status", "user")->get();
        return view("dashboard.laporan.index", [
            "laporan" => $laporan,
        ]);
    }

    public function showByUser()
    {
        $laporan = Laporan::with("status", "user")
            ->where("user_id", Auth::id())
            ->get();
        return view("dashboard.laporan.index", [
            "laporan" => $laporan,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "judul" => "required|string|max:255",
            "deskripsi" => "required|string",
            "alamat" => "required|string|max:255",
            "latitude" => "required|numeric|between:-90,90",
            "longitude" => "required|numeric|between:-180,180",
            "foto_laporan" => "required|image|mimes:jpeg,png,jpg,gif|max:2048",
            "tanggal_laporan" => "required|date",
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route("dashboard.laporan.showByUser")
                ->withErrors($validator)
                ->withInput()
                ->with("form_type", "store");
        }

        $validated = $validator->validated();

        // Handle file upload
        if ($request->hasFile("foto_laporan")) {
            $file = $request->file("foto_laporan");
            $filename = time() . "_" . $file->getClientOriginalName();
            $path = $file->storeAs("laporan", $filename, "public");
            $validated["foto_laporan"] = $path;
        }

        Laporan::create([
            "judul" => $validated["judul"],
            "deskripsi" => $validated["deskripsi"],
            "alamat" => $validated["alamat"],
            "latitude" => $validated["latitude"],
            "longitude" => $validated["longitude"],
            "foto_laporan" => $validated["foto_laporan"],
            "tanggal_laporan" => $validated["tanggal_laporan"],
            "user_id" => Auth::id(),
            "status_id" => 1,
        ]);

        return redirect()
            ->route("dashboard.laporan.showByUser")
            ->with("success", "Laporan berhasil ditambahkan");
    }

    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            "judul" => "required|string|max:255",
            "deskripsi" => "required|string",
            "alamat" => "required|string|max:255",
            "latitude" => "required|numeric|between:-90,90",
            "longitude" => "required|numeric|between:-180,180",
            "foto_laporan" => "nullable|image|mimes:jpeg,png,jpg,gif|max:2048",
            "tanggal_laporan" => "required|date",
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route("dashboard.laporan.showByUser")
                ->withErrors($validator)
                ->withInput()
                ->with("form_type", "update");
        }

        $validated = $validator->validated();

        $laporan = Laporan::find($id);

        // Handle file upload if new file is provided
        if ($request->hasFile("foto_laporan")) {
            // Delete old file
            if (
                $laporan->foto_laporan &&
                Storage::disk("public")->exists($laporan->foto_laporan)
            ) {
                Storage::disk("public")->delete($laporan->foto_laporan);
            }

            $file = $request->file("foto_laporan");
            $filename = time() . "_" . $file->getClientOriginalName();
            $path = $file->storeAs("laporan", $filename, "public");
            $validated["foto_laporan"] = $path;
        }

        $laporan->update([
            "judul" => $validated["judul"],
            "deskripsi" => $validated["deskripsi"],
            "alamat" => $validated["alamat"],
            "latitude" => $validated["latitude"],
            "longitude" => $validated["longitude"],
            "foto_laporan" =>
            $validated["foto_laporan"] ?? $laporan->foto_laporan,
            "tanggal_laporan" => $validated["tanggal_laporan"],
        ]);

        return redirect()
            ->route("dashboard.laporan.showByUser")
            ->with("success", "Laporan berhasil diperbarui");
    }

    public function destroy(string $id)
    {
        $laporan = Laporan::findOrFail($id);

        // Delete associated file
        if (
            $laporan->foto_laporan &&
            Storage::disk("public")->exists($laporan->foto_laporan)
        ) {
            Storage::disk("public")->delete($laporan->foto_laporan);
        }

        $laporan->delete();

        return redirect()
            ->route("dashboard.laporan.showByUser")
            ->with("success", "Laporan berhasil dihapus");
    }

    public function showFollowup(Request $request, string $id)
    {
        $laporan = Laporan::with("tindakLanjut")->findOrFail($id);
        $statusLaporan = StatusLaporan::all();
        return view("dashboard.laporan.followup", [
            "laporan" => $laporan,
            "statusLaporan" => $statusLaporan,
        ]);
    }
    public function followup(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            "status_id" => "required|exists:status_laporan,id",
            "catatan" => "nullable|string|max:1000",
            "foto_bukti" => "nullable|image|mimes:jpeg,png,jpg,gif|max:2048",
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route("dashboard.laporan.showFollowup", ["id" => $id])
                ->withErrors($validator)
                ->withInput();
        }

        $validated = $validator->validated();

        $laporan = Laporan::findOrFail($id);

        // Update laporan status
        $laporan->update([
            "status_id" => $validated["status_id"],
        ]);

        // Handle foto_bukti upload if provided
        $fotoBuktiPath = null;
        if ($request->hasFile("foto_bukti")) {
            $file = $request->file("foto_bukti");
            $filename = time() . "_" . $file->getClientOriginalName();
            $fotoBuktiPath = $file->storeAs(
                "tindak_lanjut",
                $filename,
                "public",
            );
        }

        // Create tindak lanjut record
        TindakLanjut::create([
            "catatan" => $validated["catatan"] ?? null,
            "foto_bukti" => $fotoBuktiPath,
            "tanggal_laporan" => now()->toDateString(),
            "user_id" => Auth::id(),
            "laporan_id" => $id,
        ]);

        return redirect()
            ->route("dashboard.laporan.showFollowup", ["id" => $id])
            ->with("success", "Tindak lanjut laporan berhasil disimpan");
    }
}
