@extends('base')

@section('title', 'Matice')

@section('content')
    @foreach($tables as $table)
        <table>
            <tbody>
            @foreach($table as $item)
                <tr>
                    @foreach($item as $subitem)
                        <td>
                            {{$subitem}}
                        </td>
                    @endforeach
                </tr>
            @endforeach
            </tbody>
        </table>
    @endforeach

@endsection