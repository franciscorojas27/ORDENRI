@props(['users', 'select', 'excluedtitle','id_name'])

<select name="{{ $id_name }}" id="{{ $id_name}}"
    class="block mt-2 w-full text-black rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 appearance-none"
    {{ Auth::user()->jobTitle->title !== 'Supervisor' ? '' : '' }}>
    <option value="{{ is_null($select) ? 0 : '' }}" {{ is_null($select) ? 'selected' : 'disabled' }}
        class="text-gray-500 dark:text-gray-400">
        {{ $select['id']['name'] ?? __('Select an option') }}
    </option>

    @foreach ($users as $user)
        @if ($user->jobTitle->title !== $excluedtitle)
            <option value="{{ $user->id }}" class="text-black"
                {{ isset($select) && $user->id == $select['id'] ? 'selected' : '' }}>
                {{ $user->name }}
            </option>
        @endif
    @endforeach
</select>