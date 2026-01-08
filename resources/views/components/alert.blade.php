@foreach (['success','error','warning','info'] as $type)
@if (session($type))
<div class="mb-4 flex items-center justify-between rounded-lg  border px-4 py-3 text-sm 
@if ($type === 'success') bg-green-100 border-green-400 text-green-700
@elseif ($type === 'error') bg-red-100 border-red-400 text-red-700 
@elseif ($type === 'warning') bg-yellow-100 border-yellow-400 text-yellow-700 
@else bg-blue-100 border-blue-400 text-blue-700 @endif">
    <span> {{ session($type) }}
    </span>
    <button onclick="this.parentElement.remove()" class="ml-4 font-bold focus:outline-none">
        X
    </button>
</div>
@endif
@endforeach