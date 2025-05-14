@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Оцінка волонтера</h2>

        <form action="{{ route('military.storeRating', $application) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="rating">Оцініть волонтера:</label>
                <select name="rating" id="rating" class="form-control">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success mt-3">Зберегти</button>
        </form>
    </div>
@endsection
