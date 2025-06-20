@extends('layouts.main')
@section('cotent')

<iframe 
    src="{{ Storage::disk('Public')->get('books/pdf/'.'lol'.'.pdf') }}" 
    width="100%"
    height="600px"
></iframe>

@endsection