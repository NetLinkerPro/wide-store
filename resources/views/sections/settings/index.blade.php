@extends('wide-store::vendor.indigo-layout.main')

@section('meta_title', __('wide-store::settings.meta_title')  . ' // ' . config('app.name'))
@section('meta_description', __('wide-store::settings.meta_description'))

@push('head')
    @include('wide-store::integration.favicons')
    @include('wide-store::integration.ga')
@endpush

@section('create_button')
    <button class="frame__header-add" @click="AWES.emit('modal::form:open')"><i class="icon icon-plus"></i></button>
@endsection

@section('content')
    <div class="filter">
        <div class="grid grid-align-center grid-justify-between grid-justify-center--mlg">
            <div class="cell-inline cell-1-1--mlg">

            </div>
            <div class="cell-inline">
                @include('wide-store::sections.partials.menu-manage')
            </div>
        </div>
    </div>
    <div class="section">
        @table([
            'name' => 'settings_table',
            'row_url'=> '',
            'scope_api_url' => route('wide-store.settings.scope'),
            'scope_api_params' => []
        ])
        <template slot="header">
            <h3>{{__('wide-store::settings.setting_list') }}</h3>
        </template>
        <tb-column name="deliverer" label="{{__('wide-store::general.deliverer') }}">
            <template slot-scope="col">
                @{{ col.data.deliverer }}
            </template>
        </tb-column>
        <tb-column name="name" label="{{__('wide-store::general.name') }}">
            <template slot-scope="col">
                @{{ col.data.name }}
            </template>
        </tb-column>
        <tb-column name="key" label="{{__('wide-store::settings.key') }}">
            <template slot-scope="col">
                @{{ col.data.key }}
            </template>
        </tb-column>
            <tb-column name="no_field_options" label="{{ __('wide-store::general.options') }}">
                <template slot-scope="d">
                    <context-menu right boundary="table">
                        <button type="submit" slot="toggler" class="btn">
                            {{ __('wide-store::general.options') }}
                        </button>
                        <cm-button @click="AWES._store.commit('setData', {param: 'editSetting', data: d.data}); AWES.emit('modal::edit-setting:open')">
                            {{ __('wide-store::general.edit') }}
                        </cm-button>
                        <cm-button @click="AWES._store.commit('setData', {param: 'deleteSetting', data: d.data}); AWES.emit('modal::delete-setting:open');">
                            {{ __('wide-store::general.delete') }}
                        </cm-button>
                    </context-menu>
                </template>
            </tb-column>
        @endtable
    </div>

@endsection

@section('modals')

    {{--Add setting--}}
    <modal-window name="form" class="modal_formbuilder" title="{{ __('wide-store::settings.addition_setting') }}">
        <form-builder name="add-setting" url="{{ route('wide-store.settings.store') }}" @sended="AWES.emit('content::settings_table:update')"
                      send-text="{{ __('wide-store::general.add') }}"
                      cancel-text="{{ __('wide-store::general.cancel') }}">
            <div class="section" v-if="AWES._store.state.forms['add-setting']">

                <fb-input name="deliverer" label="{{ __('wide-store::general.deliverer') }}"></fb-input>
                <fb-input name="name" label="{{ __('wide-store::general.name') }}"></fb-input>
                <fb-input name="key" label="{{ __('wide-store::settings.key') }}"></fb-input>
                <fb-textarea name="value" label="{{ __('wide-store::settings.value') }}"></fb-textarea>
                <fb-editor name="editor" :options="{'visual': 'false'}"></fb-editor>
            </div>
        </form-builder>
    </modal-window>

    {{--Edit setting--}}
    <modal-window name="edit-setting" class="modal_formbuilder" title="{{ __('wide-store::settings.edition_setting') }}">
        <form-builder method="PATCH" url="{{ route('wide-store.settings.index') }}/{id}" store-data="editSetting" @sended="AWES.emit('content::settings_table:update')"
                      send-text="{{ __('wide-store::general.save') }}"
                      cancel-text="{{ __('wide-store::general.cancel') }}">

            <fb-input name="deliverer" label="{{ __('wide-store::general.deliverer') }}"></fb-input>
            <fb-input name="name" label="{{ __('wide-store::general.name') }}"></fb-input>
            <fb-input name="key" label="{{ __('wide-store::settings.key') }}"></fb-input>
            <fb-textarea name="value" label="{{ __('wide-store::settings.value') }}"></fb-textarea>
        </form-builder>
    </modal-window>

    {{--Delete setting--}}
    <modal-window name="delete-setting" class="modal_formbuilder" title="{{ __('wide-store::settings.are_you_sure_delete_setting') }}">
        <form-builder name="delete-setting" method="DELETE" url="{{ route('wide-store.settings.index') }}/{id}" store-data="deleteSetting" @sended="AWES.emit('content::settings_table:update')"
                      send-text="{{ __('wide-store::general.yes') }}"
                      cancel-text="{{ __('wide-store::general.no') }}"
                      disabled-dialog>
            <template slot-scope="block">

                <!-- Fix enable button yes for delete -->
                <input type="hidden" name="isEdited" :value="AWES._store.state.forms['delete-setting']['isEdited'] = true"/>
            </template>
        </form-builder>
    </modal-window>

@endsection
