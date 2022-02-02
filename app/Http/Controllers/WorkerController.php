<?php

namespace App\Http\Controllers;
use App\Models\Worker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class WorkerController extends Controller
{
    public function index() {
        return view('index');
    }

    public function fetchAll() {
        $emps = Worker::all();
        $output = '';
        if($emps->count() > 0) {
        $output .= '<table class="table table-striped table-sm text-center align-middle">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Foto de Perfil</th>
                    <th>Nombre</th>
                    <th>E-mail</th>
                    <th>Sueldo</th>
                    <th>Teléfono</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>';
        foreach ($emps as $emp) {
        $output .= '<tr>
        <td>' . $emp->id . '</td>
        <td><img src="storage/images/' . $emp->perfil. '" width="50" class="img-thumbnail rounded-circle"></td>
        <td>' . $emp->primer_nombre. ' ' . $emp->apellido. '</td>
        <td>' . $emp->email . '</td>
        <td>' . $emp->sueldo. '</td>
        <td>' . $emp->telefono. '</td>
        <td> <a href="#" id="' . $emp->id . '" class="text-success mx-1 editIcon" data-bs-toggle="modal" data-bs-target="#editEmployeeModal"><i class="bi-pencil-square h4"></i></a>
    <a href="#" id="' . $emp->id . '" class="text-danger mx-1 deleteIcon"><i class="bi-trash h4"></i></a>
        </td>
        </tr>';
        }
        $output .= '</tbody></table>';
        echo $output;
            }else {
        echo '<h1 class="text-center text-secondary my-5">No hay registro alguno en la Base de Datos!</h1>';
            }
    }

    public function store(Request $request) {
        $file = $request->file('perfil');
        $fileName = time() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('public/images', $fileName);
    
        $empData = ['primer_nombre' => $request->fname,
                    'apellido' => $request->lname,
                    'email' => $request->email,
                    'telefono' => $request->phone,
                    'sueldo' => $request->post,
                    'perfil' => $fileName];
        Worker::create($empData);
        return response()->json([
            'status' => 200,
        ]);
    }

    public function edit(Request $request) {
        $id = $request->id;
        $emp = Worker::find($id);
        return response()->json($emp);
    }

    public function update(Request $request) {
        $fileName = '';
        $emp = Worker::find($request->emp_id);
        if($request->hasFile('perfil')) {
            $file = $request->file('perfil');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/images', $fileName);
            if($emp->perfil) {
                Storage::delete('public/images/' . $emp->perfil);
            }
        }else {
            $fileName = $request->emp_perfil;
        }
        $empData = ['primer_nombre' => $request->fname,
                    'apellido' => $request->lname,
                    'email' => $request->email,
                    'telefono' => $request->phone,
                    'sueldo' => $request->post,
                    'perfil' => $fileName];
        $emp->update($empData);
        return response()->json([
            'status' => 200,
        ]);
    }

    public function delete(Request $request) {
        $id = $request->id;
        $emp = Worker::find($id);
        if(Storage::delete('public/images/' . $emp->perfil)) {
        Worker::destroy($id);
        }
    }
}
