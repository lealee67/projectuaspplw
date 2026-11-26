<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;

class GameController extends Controller
{
    //nampilin semua games
    public function index()
    {
        $games = Game::all();

        return view('games.index', compact('games'));
    }

    // form tambah game
    public function create()
    {
        return view('games.create');
    }

    // siapin game baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_game' => 'required|string|max:100',
            'developer' => 'required|string|max:100',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        Game::create($validated);

        return redirect()->route('games.index')
            ->with('success', 'Game berhasil ditambahkan!');
    }

    // form edit
    public function edit($id)
    {
        $game = Game::findOrFail($id);

        return view('games.edit', compact('game'));
    }

    // update game
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_game' => 'required|string|max:100',
            'developer' => 'required|string|max:100',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $game = Game::findOrFail($id);
        $game->update($validated);

        return redirect()->route('games.index')
            ->with('success', 'Game berhasil diperbarui!');
    }

    // hapus game
    public function destroy($id)
    {
        $game = Game::findOrFail($id);
        $game->delete();

        return redirect()->route('games.index')
            ->with('success', 'Game berhasil dihapus!');
    }
}
