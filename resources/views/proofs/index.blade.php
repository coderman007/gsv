<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Pruebas</title>
</head>
<body>
<h1>Actualizar Pruebas</h1>

@if(session('success'))
    <div>{{ session('success') }}</div>
@endif

<form action="{{ route('proofs.update') }}" method="post">
    @csrf
    @foreach($proofs as $proof)
        <div>
            <input type="hidden" name="proofs[{{ $proof->id }}][id]" value="{{ $proof->id }}">
            <label for="name">Nombre:</label>
            <input type="text" name="proofs[{{ $proof->id }}][name]" value="{{ $proof->name }}">
            <label for="value">Valor:</label>
            <input type="text" name="proofs[{{ $proof->id }}][value]" value="{{ $proof->value }}">
        </div>
    @endforeach
    <button type="submit">Actualizar</button>
</form>
</body>
</html>
