@extends('layouts.master')
@section('contents')
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Form') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    <div class="bg-slate-100 mt-2">
                   
                        <div class="ml-4">
                            <h1 class="font-extrabold  underline">Created Forms</h1>
                            @foreach ($forms as $form)
                                <div class="mb-4 mt-4">
                                    <h1
                                        class="font-bold {{ $form->deleted_at ? 'line-through decoration-red-500' : '' }}">
                                        {{ $form->name }}
                                    </h1>
                                        <a href="{{ route('form.edit', [$form->id]) }}">
                                            <x-button class=" mt-4 text-xs bg-red-500  text-white">
                                                {{ __('Edit') }}
                                            </x-button>
                                        </a>
                                        <a href="{{ route('form.force.delete', [$form->id]) }}">
                                            <x-button class=" mt-4 text-xs bg-red-500  text-white">
                                                {{ __('Delete') }}
                                            </x-button>
                                        </a>
                                       
                                </div>
                                <hr>
                            @endforeach
                        </div>
                    </div>

                    {{ $forms->count() ? $forms->links() : '' }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
@endsection
