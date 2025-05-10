<?php

namespace App\Http\Controllers;

use App\DataTables\MasyarakatDataTable;
use Illuminate\Http\Request;

class MasyarakatController extends Controller
{
    public function index(MasyarakatDataTable $datatable)
    {
        return $datatable->render('admin.masyarakat.index');
    }
}
