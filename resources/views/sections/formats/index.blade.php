@extends('wide-store::vendor.indigo-layout.main')

@section('meta_title', __('wide-store::formats.meta_title')  . ' // ' . config('app.name'))
@section('meta_description', __('wide-store::formats.meta_description'))

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
            'name' => 'formats_table',
            'row_url'=> '',
            'scope_api_url' => route('wide-store.formats.scope'),
            'scope_api_params' => []
        ])
        <template slot="header">
            <h3>{{__('wide-store::formats.format_list') }}</h3>
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
            <tb-column name="no_field_options" label="{{ __('wide-store::general.options') }}">
                <template slot-scope="d">
                    <context-menu right boundary="table">
                        <button type="submit" slot="toggler" class="btn">
                            {{ __('wide-store::general.options') }}
                        </button>
                        <cm-button @click="AWES._store.commit('setData', {param: 'editFormat', data: d.data}); AWES.emit('modal::edit-format:open')">
                            {{ __('wide-store::general.edit') }}
                        </cm-button>
                        <cm-button @click="AWES._store.commit('setData', {param: 'deleteFormat', data: d.data}); AWES.emit('modal::delete-format:open');">
                            {{ __('wide-store::general.delete') }}
                        </cm-button>
                    </context-menu>
                </template>
            </tb-column>
        @endtable
    </div>
@endsection

@section('modals')

    {{--Add format--}}
    <modal-window name="form" class="modal_formbuilder" title="{{ __('wide-store::formats.addition_format') }}">
        <form-builder name="add-format" url="{{ route('wide-store.formats.store') }}" @sended="AWES.emit('content::formats_table:update')"
                      send-text="{{ __('wide-store::general.add') }}"
                      cancel-text="{{ __('wide-store::general.cancel') }}">
            <div class="section" v-if="AWES._store.state.forms['add-format']">

                <fb-input name="deliverer" label="{{ __('wide-store::general.deliverer') }}"></fb-input>
                <fb-input name="name" label="{{ __('wide-store::general.name') }}"></fb-input>
                <fb-textarea name="configuration" label="{{ __('wide-store::formats.configuration') }}"></fb-textarea>
                <fb-textarea name="description" label="{{ __('wide-store::general.description') }}"></fb-textarea>
            </div>
        </form-builder>
    </modal-window>

    {{--Edit format--}}
    <modal-window name="edit-format" class="modal_formbuilder" title="{{ __('wide-store::formats.edition_format') }}">
        <form-builder method="PATCH" url="{{ route('wide-store.formats.index') }}/{id}" store-data="editFormat" @sended="AWES.emit('content::formats_table:update')"
                      send-text="{{ __('wide-store::general.save') }}"
                      cancel-text="{{ __('wide-store::general.cancel') }}">

            <fb-input type="hidden" name="deliverer" label="{{ __('wide-store::general.deliverer') }}"></fb-input>
            <fb-input name="name" label="{{ __('wide-store::general.name') }}"></fb-input>
            <fb-textarea name="configuration" label="{{ __('wide-store::formats.configuration') }}"></fb-textarea>
            <fb-textarea name="description" label="{{ __('wide-store::general.description') }}"></fb-textarea>
        </form-builder>
    </modal-window>

    {{--Delete format--}}
    <modal-window name="delete-format" class="modal_formbuilder" title="{{ __('wide-store::formats.are_you_sure_delete_format') }}">
        <form-builder name="delete-format" method="DELETE" url="{{ route('wide-store.formats.index') }}/{id}" store-data="deleteFormat" @sended="AWES.emit('content::formats_table:update')"
                      send-text="{{ __('wide-store::general.yes') }}"
                      cancel-text="{{ __('wide-store::general.no') }}"
                      disabled-dialog>
            <template slot-scope="block">

                <!-- Fix enable button yes for delete -->
                <input type="hidden" name="isEdited" :value="AWES._store.state.forms['delete-format']['isEdited'] = true"/>
            </template>
        </form-builder>
    </modal-window>

@endsection
