<div>
    <button class="{{
        $type === 'primary' ? 'bg-blue-500 hover:bg-blue-700 text-white' :
        ($type === 'secondary' ? 'bg-gray-500 hover:bg-gray-700 text-white' :
        ($type === 'success' ? 'bg-green-500 hover:bg-green-700 text-white' :
        ($type === 'danger' ? 'bg-red-500 hover:bg-red-700 text-white' :
        'bg-gray-300 text-black')) ) }} px-4 py-2 rounded">
        {{$name}}
    </button>
</div>
