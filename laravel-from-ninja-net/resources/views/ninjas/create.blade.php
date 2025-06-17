<x-layout>
    <x-slot name="title">Create Ninja</x-slot>
    <h1>Create Ninja</h1>
    <form method="POST" action="/ninjas">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            {{-- use old() to prevent from remove old value --}}
            <input type="text" value="{{old("name")}}" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="skill" class="form-label">Skill</label>
            <input type="text" value="{{old("skill")}}" class="form-control" id="skill" name="skill" required>
        </div>
        
        <div class="mb-3">
            <label for="damage" class="form-label">damage</label>
            <input type="number" value="{{old("damage")}}" class="form-control" id="damage" name="damage" required>
        </div>      
      
        <div class="mb-3">
            <label for="dojo">select dojo</label>
            <select name="dojo_id" id="dojo_id">
                <option value="" disabled selected>select dojo</option>
                @foreach ($dojos as $dojo)
                    <option value="{{ $dojo->id }}" {{$dojo->id==old('dojo_id')?'selected':''}}>{{ $dojo->name }}</option>
                @endforeach
                
            </select>
            <button type="submit" class="btn btn-primary">Create Ninja</button>
            @if($errors->any())
                <div class="alert alert-danger mt-2">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>      
    </form>
</x-layout>