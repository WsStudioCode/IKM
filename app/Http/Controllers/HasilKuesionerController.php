<?php

namespace App\Http\Controllers;

use App\DataTables\HasilKuesionerDataTable;
use Illuminate\Http\Request;

class HasilKuesionerController extends Controller
{
    public function index(HasilKuesionerDataTable $databtale)
    {
        return $databtale->render('admin.hasilkuesioner.index');
    }
}
