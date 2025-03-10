<x-layout>
    <x-posts.form 
        :post="$post"
        :action="route('posts.update', $post)"
        method="PUT"
    />
</x-layout>
