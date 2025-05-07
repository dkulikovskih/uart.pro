<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class MusicianController extends Controller
{
    public function index(Request $request)
    {
        $instruments = [
            'piano' => 'Пианино',
            'guitar' => 'Гитара',
            'violin' => 'Скрипка',
            'drums' => 'Ударные',
            'saxophone' => 'Саксофон',
            'flute' => 'Флейта',
            'cello' => 'Виолончель',
            'trumpet' => 'Труба',
            'bass' => 'Бас-гитара',
            'accordion' => 'Аккордеон'
        ];

        $educationLevels = [
            'conservatory' => 'Консерватория',
            'music_college' => 'Музыкальное училище',
            'music_school' => 'Музыкальная школа',
            'self_taught' => 'Самоучка'
        ];

        $musicians = User::musicians()
            ->when($request->instrument, function ($query, $instrument) {
                return $query->where('instrument', $instrument);
            })
            ->when($request->education, function ($query, $education) {
                return $query->where('education_level', $education);
            })
            ->when($request->city, function ($query, $city) {
                return $query->where('city', 'like', "%{$city}%");
            })
            ->when($request->gender, function ($query, $gender) {
                return $query->where('gender', $gender);
            })
            ->when($request->min_age, function ($query, $minAge) {
                return $query->whereRaw('TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) >= ?', [$minAge]);
            })
            ->when($request->max_age, function ($query, $maxAge) {
                return $query->whereRaw('TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) <= ?', [$maxAge]);
            })
            ->paginate(12);

        return view('musicians.index', compact('musicians', 'instruments', 'educationLevels'));
    }

    public function show(User $musician)
    {
        $educationLevels = [
            'conservatory' => 'Консерватория',
            'music_college' => 'Музыкальное училище',
            'music_school' => 'Музыкальная школа',
            'self_taught' => 'Самоучка'
        ];

        return view('musicians.show', compact('musician', 'educationLevels'));
    }
}
