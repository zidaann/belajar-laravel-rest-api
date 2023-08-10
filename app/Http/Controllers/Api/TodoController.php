<?php

namespace App\Http\Controllers\Api;

use App\Enums\TodoStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\TodoResource;
use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{
    public function index()
    {
        // return response()->json([
        //     'message' => 'Success Get Todo',
        //     // 'data' => Todo::where('user_id', auth()->id())->latest('id')->get(), atau
        //     'data' => Auth::user()->todos()->latest('id')->get(),
        //     'count' => Auth::user()->todos()->count()
        //     /*
        //      * cara baca => ambil todo yang terbaru/id terakhir dari user yang sudah login
        //      * todos dapat dari relationship db 
        //      * cek di model user
        //      * abaikan deteksi error / red underline
        //     */
        // ], 200);

        return response()->json([
            'message' => 'Success get list todo',
            'data' => TodoResource::collection(Auth::user()->todos()->latest('id')->get())
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required'],
        ]);

        $todo = Todo::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'status' => TodoStatus::TODO->value //default
        ]);

        return response()->json([
            'message' => 'Success Post Data',
            'data' =>  TodoResource::make($todo), //make untuk single data
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Todo $todo)
    {
        $this->authorize('update', $todo);

        $this->validate($request, [
            'name' => ['required']
        ]);

        $todo->update([
            'name' => $request->name,
            'status' => $request->status
        ]);

        return response()->json([
            'message' => 'Success updated!',
            'data' => TodoResource::make($todo)
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Todo $todo)
    {
        $authorize = $this->authorize('delete', $todo);

        $todo->delete();

        return response()->json([
            'message' => 'Success deleted!'
        ]);
    }
}

/** Autorisasi API dengan Policy
 * create TodoPolicy dengan perintah "php artisan make:policy TodoPolicy --model=Todo"
 
 * Case: user hanya bisa update untuk todonya sendiri, tidak boleh todo orang lain
 * atur dibagian update, $user->id == $todo->user_id
 * cara baca => user id (yang saat ini login) harus sama dengan todo->user_id (todo yang dimiliki user sekarang)
 * Setelah diatur, tambahkan ke controller  $this->authorize( function yang diamankan, kirim datanya);
 * 
 
 * Case: user hanya bisa menghapus todonya sendiri 
 * kurang lebih penjelasan sama dengan case sebelumnya


 * Menangani response API sesuai standar, gunakan Resource
 * tuliskan perintah "php artisan make:resource TodoResource"
 * atur response di file TodoResource
 * return TodoController gunakan "return TodoResource::make()"
 * make() => untuk single data, gunakan collection() jika mengambil banyak data
 */
