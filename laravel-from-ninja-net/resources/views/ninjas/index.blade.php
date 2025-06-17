<x-layout>
    <h1>All Ninjas</h1>
    <ul>
        @foreach ($ninjas as $ninja )
            <li>
                <x-card href="{{ route('ninjas.show', $ninja->id) }}">
                   <div>
                       <h1><a href={{route( 'ninjas.show',$ninja->id)}}>{{$ninja->name}}</a></h1>
                        {{-- <h2>dojo:{{$ninja->dojo->name}}</h2> --}}
                   </div>
                </x-card>
            </li>
        @endforeach
    </ul>
    {{-- {{$ninjas->links()}} --}}
</x-layout>
