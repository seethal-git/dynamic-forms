@extends('layouts.master')
@section('contents')
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Form') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class=" flex flex-col sm:justify-center items-center py-4  sm:pt-0">
                        <x-auth-validation-errors class="mb-4" :errors="$errors" />
                        <form action="{{ route('form.edit.submit') }}" method="POST">
                            @csrf
                            <div class="mt-4">
                                <input type="hidden" name="hidden_form_id" value="{{$formData->id}}">
                                <x-label for="name" :value="__('Form Name')" />
                                <x-input id="name" class="block mt-1 w-60" type="text" name="form_name" required
                                    autocomplete="Enter form name" value="{{$formData->name}}"/> 
                            </div>
                      
                           
                                @livewire('form.edit-dynamic-form-fields', ['formId' => $formData->id])
                           
                            <x-button type="submit" class=" mt-4 ml-4 text-xs bg-red-400 hover:bg-red-700 text-white">
                                {{ __('Update Form') }}
                            </x-button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
@endsection
