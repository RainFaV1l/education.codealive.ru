@extends('layouts.app')

@section('page-title') Политика конфиденциальности @endsection

@section('content')
    <x-guest-layout>
        <div class="pt-4 bg-gray-100 policy-markdown">
            <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
                {{-- <div>
                    <x-jet-authentication-card-logo />
                </div> --}}

                <div class="w-full sm:max-w-7xl mt-6 mb-6 p-10 bg-white shadow-md overflow-hidden sm:rounded-lg prose">
                    {!! $policy !!}
                </div>
            </div>
        </div>
    </x-guest-layout>
@endsection
