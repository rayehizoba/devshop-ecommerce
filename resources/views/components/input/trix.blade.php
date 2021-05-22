@props(['id'])

@php
    $id = $id ?? md5($attributes->wire('model'));
@endphp

<div wire:ignore>
    <trix-editor
            x-data
            x-on:trix-change="$dispatch('input', event.target.value)"
            wire:key="{{ $id }}"
            {{ $attributes->merge(['class' => 'trix-content border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 rounded-md shadow-sm']) }}
    ></trix-editor>
</div>
