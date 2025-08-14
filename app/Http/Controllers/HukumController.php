<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ContentPage; 
use App\Models\Document; 
use Illuminate\Http\Request;

class HukumController extends Controller
{
    public function index()
    {
        // Untuk menampilkan jumlah di card (opsional)
        $totalDocuments = Document::count();

        return view('pages.law.index', compact('totalDocuments'));
    }
}