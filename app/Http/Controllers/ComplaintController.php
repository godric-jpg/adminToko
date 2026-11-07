<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    public function index()
    {
        $complaints = Complaint::with(['user', 'complaintType'])->latest()->get();

        return response()->json([
            'status' => 'success',
            'data'   => $complaints,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'jenis_aduan' => 'required|string|exists:complaint_types,code',
            'prioritas'   => 'required|in:low,medium,high',
            'text'        => 'required|string',
        ]);

        $validated['user_id'] = auth()->id() ?? 1;

        $complaint = Complaint::create($validated);

        return response()->json([
            'status'  => 'success',
            'message' => 'Keluhan berhasil dikirim',
            'data'    => $complaint,
        ], 201);
    }

    public function destroy($id)
    {
        $complaint = Complaint::findOrFail($id);
        $complaint->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Keluhan berhasil dihapus',
        ]);
    }
}
