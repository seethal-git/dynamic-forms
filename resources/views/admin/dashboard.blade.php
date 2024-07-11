@extends('layouts.master')
@section('contents')

                <!-- content @s -->
                <div class="nk-content ">
                    <div class="container-fluid">
                        <div class="nk-content-inner">
                            <div class="nk-content-body">
                            You're logged in!
                            @if (session('status') && session('msg'))
                                <div class="alert alert-{{ session('status') }}">
                                    <h3><b>{{ session('msg') }}</b></h3>
                                </div>
                            @endif
                            </div>
                        </div>
                    </div>
                </div>
                <!-- content @e -->
@endsection