<x-card>
    <h1>Simple show page</h1>
    <h2>Name: {{ $ninja->name }}</h2>
    <h2>Damage: {{ $ninja->damage }}</h2>
    <h2>Skill: {{ $ninja->skill }}</h2>
    <a href={{route("ninjas.index")}}>go to ninjas</a>
    <h1>Dojo Information</h1>
    <h2>Dojo ID: {{ $ninja->dojo->id }}</h2>
    <h2>Dojo Name: {{ $ninja->dojo->name }}</h2>
    <h2>Dojo Location: {{ $ninja->dojo->location }}</h2>
    <h2>Dojo Description: {{ $ninja->dojo->description }}</h2>
    <h2>Dojo Created At: {{ $ninja->dojo->created_at }}</h2>
    <h2>Dojo Updated At: {{ $ninja->dojo->updated_at }}</h2>
</x-card>
