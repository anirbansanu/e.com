@extends('layouts.app')

@section('title', 'Website Settings')

@section('subtitle', 'Manage your website settings')
@section('content_header_title', 'Settings')
@section('content_header_subtitle', 'Manage Website Settings')

@section('content_body')
    <x-anilte::card headerClass="p-0 border-bottom-0 " bodyClass="" footerClass="custom-footer-class" minimize maximize close>
        <x-slot name="header">
                <x-anilte::tab-nav-item route="admin.settings.app" icon="fas fa-cogs">App Settings</x-anilte::tab-nav-item>
                <x-anilte::tab-nav-item route="admin.settings.website" icon="fas fa-cogs">Website Settings</x-anilte::tab-nav-item>
        </x-slot>
        <x-slot name="body">
            <div class="row">

                <div class="col-sm-12 col-md-8 px-4 pb-4 ">
                    <form action="{{ route('admin.settings.website.update') }}" method="POST" id="settings-form" >
                        @csrf
                        <div id="form-inputs">
                            @foreach($settings as $setting)
                                <div class="form-group">
                                    <label for="{{ $setting->key }}">{{ ucfirst(str_replace('_', ' ', $setting->key)) }}</label>
                                    <input type="text" class="form-control" id="{{ $setting->key }}" name="settings[{{ $setting->key }}]" value="{{ $setting->value }}">
                                </div>
                            @endforeach
                        </div>
                        <div id="new-settings" class="mt-5">
                            <div class="form-group d-flex p-0 m-0">
                                <label class="form-control mr-1 border-0 p-0 m-0 align-text-bottom" style="height:fit-content" for="new_key">New Key</label>
                                <label class="form-control border-0 p-0 m-0 align-text-bottom" style="height:fit-content" for="new_value">New Value</label>
                            </div>
                            <div class="form-group d-flex">
                                <input type="text" class="form-control mr-1" id="new_key" placeholder="Enter key">
                                <input type="text" class="form-control" id="new_value" placeholder="Enter value">
                            </div>
                        </div>
                        <button type="button" class="btn btn-secondary" id="add-setting">Add Setting</button>
                        <button type="submit" class="btn btn-primary">Update Settings</button>
                    </form>
                </div>
            </div>
        </x-slot>

    </x-anilte::card>
@stop

@push('js')
    <script>
        document.getElementById('add-setting').addEventListener('click', function() {
            var key = document.getElementById('new_key').value.trim();
            var value = document.getElementById('new_value').value.trim();

            if (key && value) {
                var newSettingDiv = document.createElement('div');
                newSettingDiv.className = 'form-group';

                var keyLabel = document.createElement('label');
                keyLabel.textContent = key.charAt(0).toUpperCase() + key.slice(1).replace('_', ' ');
                newSettingDiv.appendChild(keyLabel);

                var keyInput = document.createElement('input');
                keyInput.type = 'text';
                keyInput.className = 'form-control';
                keyInput.name = 'settings[' + key + ']';
                keyInput.value = value;
                newSettingDiv.appendChild(keyInput);

                document.getElementById('form-inputs').appendChild(newSettingDiv);

                // Clear the input fields
                document.getElementById('new_key').value = '';
                document.getElementById('new_value').value = '';
            } else {
                alert('Both key and value are required.');
            }
        });
    </script>
@endpush
