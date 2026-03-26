@extends('layouts.app')

@section('content')
    <h1>Page Builder: {{ $page->title }}</h1>

    <form method="post" action="{{ route('tenant.pages.sections.update', $page) }}" x-data="builder()" class="card">
        @csrf
        <template x-for="(section, index) in sections" :key="index">
            <div class="card">
                <label>Type <input x-model="section.type" :name="`sections[${index}][type]`"></label>
                <label>Headline <input x-model="section.content.headline" :name="`sections[${index}][content][headline]`"></label>
                <label>Body <textarea x-model="section.content.body" :name="`sections[${index}][content][body]`"></textarea></label>
                <button class="btn" type="button" @click="moveUp(index)">Move Up</button>
                <button class="btn" type="button" @click="remove(index)">Delete</button>
            </div>
        </template>

        <button class="btn" type="button" @click="add()">Add Section</button>
        <button class="btn" type="submit">Publish Structure</button>
    </form>

    <script>
        function builder() {
            return {
                sections: @json($page->sections->map(fn($s) => ['type' => $s->type, 'content' => $s->content])->values()),
                add() { this.sections.push({ type: 'text', content: { headline: '', body: '' } }); },
                remove(index) { this.sections.splice(index, 1); },
                moveUp(index) {
                    if (index < 1) return;
                    [this.sections[index - 1], this.sections[index]] = [this.sections[index], this.sections[index - 1]];
                }
            }
        }
    </script>
@endsection
