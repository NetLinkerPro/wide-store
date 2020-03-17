@extends('wide-store::vendor.indigo-layout.main')

@section('meta_title', __('wide-store::identifiers.meta_title')  . ' // ' . config('app.name'))
@section('meta_description', __('wide-store::identifiers.meta_description'))

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
            'name' => 'identifiers_table',
            'row_url'=> '',
            'scope_api_url' => route('wide-store.identifiers.scope'),
            'scope_api_params' => []
        ])
        <template slot="header">
            <h3>{{__('wide-store::identifiers.identifier_list') }}</h3>
        </template>
        <tb-column name="no_field_product_uuid" label="{{__('wide-store::general.product') }}">
            <template slot-scope="col">
                @{{ col.data.product.name }}
            </template>
        </tb-column>
        <tb-column name="deliverer" label="{{__('wide-store::general.deliverer') }}">
            <template slot-scope="col">
                @{{ col.data.deliverer }}
            </template>
        </tb-column>
        <tb-column name="identifier" label="{{__('wide-store::identifiers.identifier') }}">
            <template slot-scope="col">
                @{{ col.data.identifier }}
            </template>
        </tb-column>
        <tb-column name="type" label="{{__('wide-store::general.type') }}">
            <template slot-scope="col">
                @{{ col.data.type }}
            </template>
        </tb-column>

            <tb-column name="no_field_options" label="{{ __('wide-store::general.options') }}">
                <template slot-scope="d">
                    <context-menu right boundary="table">
                        <button type="submit" slot="toggler" class="btn">
                            {{ __('wide-store::general.options') }}
                        </button>
                        <cm-button @click="AWES._store.commit('setData', {param: 'editIdentifier', data: d.data}); AWES.emit('modal::edit-identifier:open')">
                            {{ __('wide-store::general.edit') }}
                        </cm-button>
                        <cm-button @click="AWES._store.commit('setData', {param: 'deleteIdentifier', data: d.data}); AWES.emit('modal::delete-identifier:open');">
                            {{ __('wide-store::general.delete') }}
                        </cm-button>
                    </context-menu>
                </template>
            </tb-column>
        @endtable
    </div>
@endsection

@section('modals')

    {{--Add identifier--}}
    <modal-window name="form" class="modal_formbuilder" title="{{ __('wide-store::identifiers.addition_identifier') }}">
        <form-builder name="add-identifier" url="{{ route('wide-store.identifiers.store') }}" @sended="AWES.emit('content::identifiers_table:update')"
                      send-text="{{ __('wide-store::general.add') }}"
                      cancel-text="{{ __('wide-store::general.cancel') }}">
            <div class="section" v-if="AWES._store.state.forms['add-identifier']">
                <fb-select name="product_uuid" label="{{ __('wide-store::general.product') }}"
                           url="{{route('wide-store.products.scope')}}?q=%s"
                           options-value="uuid" options-name="name" :multiple="false" placeholder-text=" "></fb-select>

                <fb-input name="deliverer" label="{{ __('wide-store::general.deliverer') }}"></fb-input>
                <fb-input name="identifier" label="{{ __('wide-store::identifiers.identifier') }}"></fb-input>
                <fb-input name="type" label="{{ __('wide-store::general.type') }}"></fb-input>
            </div>
        </form-builder>
    </modal-window>

    {{--Edit identifier--}}
    <modal-window name="edit-identifier" class="modal_formbuilder" title="{{ __('wide-store::identifiers.edition_identifier') }}">
        <form-builder method="PATCH" url="{{ route('wide-store.identifiers.index') }}/{id}" store-data="editIdentifier" @sended="AWES.emit('content::identifiers_table:update')"
                      send-text="{{ __('wide-store::general.save') }}"
                      cancel-text="{{ __('wide-store::general.cancel') }}">

            <fb-input type="hidden" name="product_uuid"></fb-input>
            <fb-input name="deliverer" label="{{ __('wide-store::general.deliverer') }}"></fb-input>
            <fb-input name="identifier" label="{{ __('wide-store::identifiers.identifier') }}"></fb-input>
            <fb-input name="type" label="{{ __('wide-store::general.type') }}"></fb-input>
        </form-builder>
    </modal-window>

    {{--Delete identifier--}}
    <modal-window name="delete-identifier" class="modal_formbuilder" title="{{ __('wide-store::identifiers.are_you_sure_delete_identifier') }}">
        <form-builder name="delete-identifier" method="DELETE" url="{{ route('wide-store.identifiers.index') }}/{id}" store-data="deleteIdentifier" @sended="AWES.emit('content::identifiers_table:update')"
                      send-text="{{ __('wide-store::general.yes') }}"
                      cancel-text="{{ __('wide-store::general.no') }}"
                      disabled-dialog>
            <template slot-scope="block">

                <!-- Fix enable button yes for delete -->
                <input type="hidden" name="isEdited" :value="AWES._store.state.forms['delete-identifier']['isEdited'] = true"/>
            </template>
        </form-builder>
    </modal-window>

@endsection
